<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UrgentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'citizen_id',
        'title',
        'description',
        'location',
        'category',
        'priority',
        'status',
        'tanod_id',
        'tanod_response',
        'resolution_notes',
        'submitted_at',
        'assigned_at',
        'responded_at',
        'resolved_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'assigned_at' => 'datetime',
        'responded_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    /**
     * Get the citizen who submitted this request
     */
    public function citizen(): BelongsTo
    {
        return $this->belongsTo(User::class, 'citizen_id');
    }

    /**
     * Get the tanod assigned to this request
     */
    public function tanod(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tanod_id');
    }

    /**
     * Get all status updates for this request
     */
    public function updates(): HasMany
    {
        return $this->hasMany(UrgentRequestUpdate::class);
    }

    /**
     * Check if request is urgent
     */
    public function isUrgent(): bool
    {
        return $this->priority === 'urgent';
    }

    /**
     * Check if request is resolved
     */
    public function isResolved(): bool
    {
        return $this->status === 'resolved';
    }

    /**
     * Check if request is active
     */
    public function isActive(): bool
    {
        return in_array($this->status, ['assigned', 'in_progress', 'on_the_way']);
    }

    /**
     * Get status badge color
     */
    public function getStatusColor(): string
    {
        return match($this->status) {
            'submitted' => 'bg-yellow-100 text-yellow-800',
            'assigned' => 'bg-blue-100 text-blue-800',
            'in_progress' => 'bg-orange-100 text-orange-800',
            'on_the_way' => 'bg-purple-100 text-purple-800',
            'resolved' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
