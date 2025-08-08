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
        // Usa la lingua corrente della sessione (quella selezionata dall'header)
        $currentLocale = app()->getLocale();
        $showAllLanguages = $request->get('all_languages', false);
        
        // Ottieni i post ordinati cronologicamente
        $query = Post::with(['user', 'cat', 'likes', 'comments.user'])
            ->active();
        
        // Applica filtro lingua solo se non è richiesta la visualizzazione di tutte le lingue
        if (!$showAllLanguages) {
            $query->inUserArea($currentLocale);
        }
        
        $posts = $query->recent()->paginate($perPage);
            
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
     * Nota: La generazione automatica di post di adozione è stata spostata
     * al job schedulato GenerateAdoptionPosts che viene eseguito quotidianamente.
     * Questo metodo ora restituisce semplicemente i post esistenti.
     */
    private function injectAdoptionRequests($posts, $page)
    {
        // I post di adozione vengono ora generati automaticamente 
        // dal job schedulato GenerateAdoptionPosts (daily at 10:00)
        // Non è più necessario crearli ad ogni visita della pagina
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
            'type' => 'user_post',
            'locale' => app()->getLocale() // Usa la lingua corrente della sessione
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
        $currentLocale = app()->getLocale();
        
        $posts = Post::with(['user', 'cat', 'likes', 'comments.user'])
            ->active()
            ->inUserArea($currentLocale)
            ->whereJsonContains('hashtags', $hashtag)
            ->recent()
            ->paginate(10);
            
        return view('catbook.hashtag', compact('posts', 'hashtag'));
    }
}