<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'status',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    /**
     * Get the full name of the contact
     */
    public function getFullNameAttribute(): string
    {
        return $this->name;
    }

    /**
     * Scope to get only new contacts
     */
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    /**
     * Scope to get only read contacts
     */
    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    /**
     * Scope to get only replied contacts
     */
    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }

    /**
     * Mark contact as read
     */
    public function markAsRead(): void
    {
        $this->update([
            'status' => 'read',
            'read_at' => now(),
        ]);
    }

    /**
     * Mark contact as replied
     */
    public function markAsReplied(): void
    {
        $this->update([
            'status' => 'replied',
        ]);
    }

    /**
     * Check if contact is new
     */
    public function isNew(): bool
    {
        return $this->status === 'new';
    }

    /**
     * Check if contact is read
     */
    public function isRead(): bool
    {
        return $this->status === 'read';
    }

    /**
     * Check if contact is replied
     */
    public function isReplied(): bool
    {
        return $this->status === 'replied';
    }
}
