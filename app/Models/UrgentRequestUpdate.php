<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UrgentRequestUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'urgent_request_id',
        'tanod_id',
        'status',
        'message',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    /**
     * Get the urgent request this update belongs to
     */
    public function urgentRequest(): BelongsTo
    {
        return $this->belongsTo(UrgentRequest::class);
    }

    /**
     * Get the tanod who made this update
     */
    public function tanod(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tanod_id');
    }

    /**
     * Get status badge HTML
     */
    public function getStatusBadge(): string
    {
        $colors = [
            'in_progress' => 'orange',
            'on_the_way' => 'purple',
            'resolved' => 'green',
        ];
        $color = $colors[$this->status] ?? 'gray';
        return "<span class=\"px-2 py-1 text-xs font-semibold rounded-full bg-{$color}-100 text-{$color}-800\">" . ucfirst(str_replace('_', ' ', $this->status)) . "</span>";
    }
}
