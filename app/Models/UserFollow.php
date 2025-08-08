<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserFollow extends Model
{
    protected $fillable = [
        'follower_id',
        'following_id',
        'notifications_enabled',
    ];

    protected $casts = [
        'notifications_enabled' => 'boolean',
    ];

    /**
     * L'utente che segue
     */
    public function follower(): BelongsTo
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    /**
     * L'utente che viene seguito
     */
    public function following(): BelongsTo
    {
        return $this->belongsTo(User::class, 'following_id');
    }

    /**
     * Scope per follow attivi con notifiche
     */
    public function scopeWithNotifications($query)
    {
        return $query->where('notifications_enabled', true);
    }

    /**
     * Scope per follow di un utente specifico
     */
    public function scopeForFollower($query, $userId)
    {
        return $query->where('follower_id', $userId);
    }

    /**
     * Scope per followers di un utente specifico
     */
    public function scopeForFollowing($query, $userId)
    {
        return $query->where('following_id', $userId);
    }
}