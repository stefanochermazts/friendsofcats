<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Models\CatFollow;
use App\Models\User;
use App\Models\UserFollow;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FollowController extends Controller
{
    /**
     * Segui/Smetti di seguire un utente
     */
    public function toggleUserFollow(Request $request, User $user): JsonResponse
    {
        $currentUser = Auth::user();
        
        if (!$currentUser) {
            return response()->json(['error' => 'Utente non autenticato'], 401);
        }

        if ($currentUser->id === $user->id) {
            return response()->json(['error' => 'Non puoi seguire te stesso'], 400);
        }

        try {
            $isFollowing = $currentUser->isFollowing($user);
            
            if ($isFollowing) {
                // Unfollow
                $currentUser->unfollowUser($user);
                $action = 'unfollowed';
                $message = 'Non segui più ' . $user->name;
                
                Log::info('User unfollowed', [
                    'follower_id' => $currentUser->id,
                    'following_id' => $user->id
                ]);
            } else {
                // Follow
                $notifications = $request->get('notifications', true);
                $currentUser->followUser($user, $notifications);
                $action = 'followed';
                $message = 'Ora segui ' . $user->name;
                
                Log::info('User followed', [
                    'follower_id' => $currentUser->id,
                    'following_id' => $user->id,
                    'notifications' => $notifications
                ]);
            }

            $followersCount = $user->followerUsers()->count();
            
            return response()->json([
                'success' => true,
                'action' => $action,
                'message' => $message,
                'is_following' => !$isFollowing,
                'followers_count' => $followersCount
            ]);

        } catch (\Exception $e) {
            Log::error('Error toggling user follow', [
                'error' => $e->getMessage(),
                'follower_id' => $currentUser->id,
                'following_id' => $user->id
            ]);

            return response()->json([
                'error' => 'Errore durante l\'operazione di follow'
            ], 500);
        }
    }

    /**
     * Segui/Smetti di seguire un gatto
     */
    public function toggleCatFollow(Request $request, Cat $cat): JsonResponse
    {
        $currentUser = Auth::user();
        
        if (!$currentUser) {
            return response()->json(['error' => 'Utente non autenticato'], 401);
        }

        try {
            $isFollowing = $currentUser->isFollowingCat($cat);
            
            if ($isFollowing) {
                // Unfollow
                $currentUser->unfollowCat($cat);
                $action = 'unfollowed';
                $message = 'Non segui più ' . $cat->nome;
                
                Log::info('Cat unfollowed', [
                    'user_id' => $currentUser->id,
                    'cat_id' => $cat->id
                ]);
            } else {
                // Follow
                $notifications = $request->get('notifications', true);
                $currentUser->followCat($cat, $notifications);
                $action = 'followed';
                $message = 'Ora segui ' . $cat->nome;
                
                Log::info('Cat followed', [
                    'user_id' => $currentUser->id,
                    'cat_id' => $cat->id,
                    'notifications' => $notifications
                ]);
            }

            $followersCount = $cat->getFollowersCount();
            
            return response()->json([
                'success' => true,
                'action' => $action,
                'message' => $message,
                'is_following' => !$isFollowing,
                'followers_count' => $followersCount
            ]);

        } catch (\Exception $e) {
            Log::error('Error toggling cat follow', [
                'error' => $e->getMessage(),
                'user_id' => $currentUser->id,
                'cat_id' => $cat->id
            ]);

            return response()->json([
                'error' => 'Errore durante l\'operazione di follow'
            ], 500);
        }
    }

    /**
     * Aggiorna le impostazioni di notifica per un follow utente
     */
    public function updateUserNotifications(Request $request, User $user): JsonResponse
    {
        $currentUser = Auth::user();
        
        if (!$currentUser || !$currentUser->isFollowing($user)) {
            return response()->json(['error' => 'Follow non trovato'], 404);
        }

        $request->validate([
            'notifications_enabled' => 'required|boolean'
        ]);

        try {
            UserFollow::where('follower_id', $currentUser->id)
                      ->where('following_id', $user->id)
                      ->update(['notifications_enabled' => $request->notifications_enabled]);

            return response()->json([
                'success' => true,
                'message' => 'Impostazioni notifiche aggiornate'
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating user notification settings', [
                'error' => $e->getMessage(),
                'follower_id' => $currentUser->id,
                'following_id' => $user->id
            ]);

            return response()->json([
                'error' => 'Errore durante l\'aggiornamento'
            ], 500);
        }
    }

    /**
     * Aggiorna le impostazioni di notifica per un follow gatto
     */
    public function updateCatNotifications(Request $request, Cat $cat): JsonResponse
    {
        $currentUser = Auth::user();
        
        if (!$currentUser || !$currentUser->isFollowingCat($cat)) {
            return response()->json(['error' => 'Follow non trovato'], 404);
        }

        $request->validate([
            'notifications_enabled' => 'required|boolean'
        ]);

        try {
            CatFollow::where('user_id', $currentUser->id)
                     ->where('cat_id', $cat->id)
                     ->update(['notifications_enabled' => $request->notifications_enabled]);

            return response()->json([
                'success' => true,
                'message' => 'Impostazioni notifiche aggiornate'
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating cat notification settings', [
                'error' => $e->getMessage(),
                'user_id' => $currentUser->id,
                'cat_id' => $cat->id
            ]);

            return response()->json([
                'error' => 'Errore durante l\'aggiornamento'
            ], 500);
        }
    }

    /**
     * Ottieni i follow dell'utente corrente
     */
    public function myFollows(): JsonResponse
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Utente non autenticato'], 401);
        }

        try {
            $followingUsers = $user->followingUsers()
                                   ->select(['id', 'name', 'email', 'ragione_sociale'])
                                   ->withPivot('notifications_enabled', 'created_at')
                                   ->get();

            $followingCats = $user->followingCats()
                                  ->select(['id', 'nome', 'razza', 'eta', 'foto_principale'])
                                  ->withPivot('notifications_enabled', 'created_at')
                                  ->get();

            return response()->json([
                'following_users' => $followingUsers,
                'following_cats' => $followingCats,
                'counts' => $user->getFollowCounts()
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching user follows', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);

            return response()->json([
                'error' => 'Errore durante il caricamento dei follow'
            ], 500);
        }
    }

    /**
     * Ottieni i followers dell'utente corrente
     */
    public function myFollowers(): JsonResponse
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Utente non autenticato'], 401);
        }

        try {
            $followers = $user->followerUsers()
                             ->select(['id', 'name', 'email', 'ragione_sociale'])
                             ->withPivot('notifications_enabled', 'created_at')
                             ->get();

            return response()->json([
                'followers' => $followers,
                'count' => $followers->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching user followers', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);

            return response()->json([
                'error' => 'Errore durante il caricamento dei followers'
            ], 500);
        }
    }
}