<?php

namespace App\Jobs;

use App\Models\Cat;
use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendFollowNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private string $type, // 'user_post', 'cat_post', 'cat_update'
        private int $entityId, // ID dell'utente o gatto
        private ?int $postId = null, // ID del post se applicabile
        private array $updateData = [] // Dati dell'aggiornamento
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('🔔 Invio notifiche follow', [
            'type' => $this->type,
            'entity_id' => $this->entityId,
            'post_id' => $this->postId
        ]);

        try {
            match ($this->type) {
                'user_post' => $this->handleUserPostNotification(),
                'cat_post' => $this->handleCatPostNotification(),
                'cat_update' => $this->handleCatUpdateNotification(),
                default => Log::warning('Tipo di notifica follow non riconosciuto', ['type' => $this->type])
            };
        } catch (\Exception $e) {
            Log::error('Errore nell\'invio delle notifiche follow', [
                'error' => $e->getMessage(),
                'type' => $this->type,
                'entity_id' => $this->entityId
            ]);
            throw $e;
        }
    }

    /**
     * Gestisce le notifiche per un nuovo post di un utente
     */
    private function handleUserPostNotification(): void
    {
        $user = User::find($this->entityId);
        $post = $this->postId ? Post::find($this->postId) : null;
        
        if (!$user || !$post) {
            Log::warning('Utente o post non trovato per notifica', [
                'user_id' => $this->entityId,
                'post_id' => $this->postId
            ]);
            return;
        }

        // Trova tutti i followers con notifiche attive
        $followers = $user->followerUsers()
                         ->wherePivot('notifications_enabled', true)
                         ->get();

        if ($followers->isEmpty()) {
            Log::info('Nessun follower con notifiche attive', ['user_id' => $user->id]);
            return;
        }

        Log::info("Invio notifiche a {$followers->count()} followers per post utente", [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'followers_count' => $followers->count()
        ]);

        foreach ($followers as $follower) {
            $this->sendInAppNotification($follower, [
                'title' => "Nuovo post da {$user->name}",
                'message' => substr(strip_tags($post->content), 0, 100) . '...',
                'type' => 'user_post',
                'action_url' => route('catbook.post', $post->id),
                'from_user' => $user->name,
                'post_id' => $post->id
            ]);
        }
    }

    /**
     * Gestisce le notifiche per un nuovo post di un gatto
     */
    private function handleCatPostNotification(): void
    {
        $post = $this->postId ? Post::find($this->postId) : null;
        
        if (!$post || !$post->cat_id) {
            Log::warning('Post o gatto non trovato per notifica', [
                'post_id' => $this->postId
            ]);
            return;
        }

        $cat = $post->cat;
        if (!$cat) {
            Log::warning('Gatto non trovato', ['cat_id' => $post->cat_id]);
            return;
        }

        // Trova tutti i followers del gatto con notifiche attive
        $followers = $cat->followerUsers()
                        ->wherePivot('notifications_enabled', true)
                        ->get();

        if ($followers->isEmpty()) {
            Log::info('Nessun follower con notifiche attive per gatto', ['cat_id' => $cat->id]);
            return;
        }

        Log::info("Invio notifiche a {$followers->count()} followers per post gatto", [
            'cat_id' => $cat->id,
            'cat_name' => $cat->nome,
            'post_id' => $post->id,
            'followers_count' => $followers->count()
        ]);

        foreach ($followers as $follower) {
            $this->sendInAppNotification($follower, [
                'title' => "Aggiornamento su {$cat->nome} 🐱",
                'message' => substr(strip_tags($post->content), 0, 100) . '...',
                'type' => 'cat_post',
                'action_url' => route('cats.show', $cat->id),
                'cat_name' => $cat->nome,
                'cat_id' => $cat->id,
                'post_id' => $post->id
            ]);
        }
    }

    /**
     * Gestisce le notifiche per un aggiornamento di un gatto
     */
    private function handleCatUpdateNotification(): void
    {
        $cat = Cat::find($this->entityId);
        
        if (!$cat) {
            Log::warning('Gatto non trovato per notifica update', ['cat_id' => $this->entityId]);
            return;
        }

        // Trova tutti i followers del gatto con notifiche attive
        $followers = $cat->followerUsers()
                        ->wherePivot('notifications_enabled', true)
                        ->get();

        if ($followers->isEmpty()) {
            Log::info('Nessun follower con notifiche attive per aggiornamento gatto', ['cat_id' => $cat->id]);
            return;
        }

        $message = $this->buildUpdateMessage($cat, $this->updateData);

        Log::info("Invio notifiche a {$followers->count()} followers per aggiornamento gatto", [
            'cat_id' => $cat->id,
            'cat_name' => $cat->nome,
            'update_data' => $this->updateData,
            'followers_count' => $followers->count()
        ]);

        foreach ($followers as $follower) {
            $this->sendInAppNotification($follower, [
                'title' => "📝 Aggiornamento su {$cat->nome}",
                'message' => $message,
                'type' => 'cat_update',
                'action_url' => route('cats.show', $cat->id),
                'cat_name' => $cat->nome,
                'cat_id' => $cat->id,
                'updates' => $this->updateData
            ]);
        }
    }

    /**
     * Costruisce il messaggio per gli aggiornamenti del gatto
     */
    private function buildUpdateMessage(Cat $cat, array $updateData): string
    {
        $changes = [];
        
        foreach ($updateData as $field => $value) {
            match ($field) {
                'disponibile_adozione' => $changes[] = $value ? 'Ora disponibile per adozione!' : 'Non più disponibile per adozione',
                'stato_salute' => $changes[] = "Stato salute aggiornato",
                'foto_principale' => $changes[] = "Nuova foto profilo",
                'galleria_foto' => $changes[] = "Nuove foto aggiunte",
                'peso' => $changes[] = "Peso aggiornato: {$value}kg",
                'eta' => $changes[] = "Età aggiornata: {$value} mesi",
                default => null
            };
        }

        return empty($changes) 
            ? "Informazioni aggiornate" 
            : implode(', ', array_slice($changes, 0, 2)) . (count($changes) > 2 ? '...' : '');
    }

    /**
     * Invia una notifica in-app (placeholder per ora)
     */
    private function sendInAppNotification(User $user, array $data): void
    {
        // Per ora logghiamo solo la notifica
        // In futuro si può implementare un sistema di notifiche in-app
        Log::info("📧 Notifica inviata", [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'notification_data' => $data
        ]);

        // TODO: Implementare notifiche in-app reali
        // Notification::send($user, new FollowUpdateNotification($data));
    }

    /**
     * Dispatch automatico per nuovi post
     */
    public static function dispatchForPost(Post $post): void
    {
        if ($post->cat_id) {
            // Post relativo a un gatto
            self::dispatch('cat_post', $post->cat_id, $post->id);
        }
        
        if ($post->user_id) {
            // Post di un utente
            self::dispatch('user_post', $post->user_id, $post->id);
        }
    }

    /**
     * Dispatch automatico per aggiornamenti gatto
     */
    public static function dispatchForCatUpdate(Cat $cat, array $changes): void
    {
        if (!empty($changes)) {
            self::dispatch('cat_update', $cat->id, null, $changes);
        }
    }
}