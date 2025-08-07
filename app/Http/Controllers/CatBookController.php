<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLike;
use App\Models\PostComment;
use App\Models\Cat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CatBookController extends Controller
{
    /**
     * Mostra il feed principale del CatBook
     */
    public function index(Request $request)
    {
        $perPage = 10;
        $page = $request->get('page', 1);
        
        // Ottieni i post ordinati cronologicamente
        $posts = Post::with(['user', 'cat', 'likes', 'comments.user'])
            ->active()
            ->recent()
            ->paginate($perPage);
            
        // Logica per inserire richieste di adozione casuali
        $posts = $this->injectAdoptionRequests($posts, $page);
        
        if ($request->ajax()) {
            return response()->json([
                'posts' => view('catbook.partials.posts', compact('posts'))->render(),
                'hasMore' => $posts->hasMorePages(),
                'currentPage' => $posts->currentPage(),
                'lastPage' => $posts->lastPage()
            ]);
        }
        
        return view('catbook.index', compact('posts'));
    }

    /**
     * Inserisce richieste di adozione casuali nel feed
     */
    private function injectAdoptionRequests($posts, $page)
    {
        // Solo per la prima pagina, inserisci richieste casuali
        if ($page == 1) {
            $adoptionCats = Cat::where('disponibile_adozione', true)
                ->whereDoesntHave('posts', function($query) {
                    $query->where('type', 'adoption_request')
                          ->where('created_at', '>', now()->subDays(7)); // Non più di una volta a settimana
                })
                ->inRandomOrder()
                ->limit(2) // Massimo 2 richieste per pagina
                ->get();
            
            foreach ($adoptionCats as $cat) {
                // Crea automaticamente un post di richiesta adozione
                Post::createAdoptionRequest($cat);
            }
            
            // Ricarica i post per includere quelli appena creati
            $posts = Post::with(['user', 'cat', 'likes', 'comments.user'])
                ->active()
                ->recent()
                ->paginate(10);
        }
        
        return $posts;
    }

    /**
     * Crea un nuovo post
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:500',
            'cat_id' => 'nullable|exists:cats,id',
            'image' => 'nullable|image|max:' . (ini_get('upload_max_filesize') ?: '2M')
        ]);

        $post = new Post([
            'user_id' => Auth::id(),
            'cat_id' => $request->cat_id,
            'content' => $request->content,
            'type' => 'user_post'
        ]);

        // Gestione upload immagine
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
            $post->image = $imagePath;
        }

        // Estrazione hashtag
        $hashtags = $post->extractHashtags();
        $post->hashtags = $hashtags;

        $post->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Post pubblicato con successo!',
                'post' => view('catbook.partials.single-post', ['post' => $post->load(['user', 'cat'])])->render()
            ]);
        }

        return redirect()->route('catbook.index')->with('success', 'Post pubblicato con successo!');
    }

    /**
     * Metti/rimuovi like a un post
     */
    public function toggleLike(Post $post)
    {
        $user = Auth::user();
        $like = PostLike::where('post_id', $post->id)
                       ->where('user_id', $user->id)
                       ->first();

        if ($like) {
            // Rimuovi like
            $like->delete();
            $post->decrement('likes_count');
            $liked = false;
        } else {
            // Aggiungi like
            PostLike::create([
                'post_id' => $post->id,
                'user_id' => $user->id
            ]);
            $post->increment('likes_count');
            $liked = true;
        }

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likes_count' => $post->fresh()->likes_count
        ]);
    }

    /**
     * Aggiungi un commento a un post
     */
    public function addComment(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:300'
        ]);

        $comment = PostComment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'content' => $request->content
        ]);

        $post->increment('comments_count');

        return response()->json([
            'success' => true,
            'message' => 'Commento aggiunto con successo!',
            'comment' => view('catbook.partials.comment', [
                'comment' => $comment->load('user')
            ])->render(),
            'comments_count' => $post->fresh()->comments_count
        ]);
    }

    /**
     * Mostra i commenti di un post
     */
    public function getComments(Post $post)
    {
        $comments = $post->comments()
            ->with('user')
            ->active()
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'comments' => view('catbook.partials.comments', compact('comments'))->render()
        ]);
    }

    /**
     * Condivisione di un post
     */
    public function share(Post $post, Request $request)
    {
        $platform = $request->get('platform', 'link');
        
        $post->increment('shares_count');
        
        $url = route('catbook.post', $post->id);
        $text = "Guarda questo post su FriendsOfCats: " . substr($post->content, 0, 100) . "...";
        
        $shareUrls = [
            'whatsapp' => "https://wa.me/?text=" . urlencode($text . " " . $url),
            'facebook' => "https://www.facebook.com/sharer/sharer.php?u=" . urlencode($url),
            'twitter' => "https://twitter.com/intent/tweet?text=" . urlencode($text) . "&url=" . urlencode($url),
            'link' => $url
        ];
        
        return response()->json([
            'success' => true,
            'share_url' => $shareUrls[$platform] ?? $shareUrls['link'],
            'shares_count' => $post->fresh()->shares_count
        ]);
    }

    /**
     * Mostra un singolo post (per condivisioni)
     */
    public function show(Post $post)
    {
        $post->load(['user', 'cat', 'comments.user']);
        
        return view('catbook.show', compact('post'));
    }

    /**
     * Feed filtrato per hashtag
     */
    public function hashtag($hashtag)
    {
        $posts = Post::with(['user', 'cat', 'likes', 'comments.user'])
            ->active()
            ->whereJsonContains('hashtags', $hashtag)
            ->recent()
            ->paginate(10);
            
        return view('catbook.hashtag', compact('posts', 'hashtag'));
    }
}