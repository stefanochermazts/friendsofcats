<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CatFollow extends Model
{
    protected $fillable = [
        'user_id',
        'cat_id',
        'notifications_enabled',
    ];

    protected $casts = [
        'notifications_enabled' => 'boolean',
    ];

    /**
     * L'utente che segue il gatto
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Il gatto che viene seguito
     */
    public function cat(): BelongsTo
    {
        return $this->belongsTo(Cat::class);
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
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope per followers di un gatto specifico
     */
    public function scopeForCat($query, $catId)
    {
        return $query->where('cat_id', $catId);
    }
}