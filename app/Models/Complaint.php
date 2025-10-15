<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Complaint extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'complaint_number',
        'user_id',
        'complaint_category_id',
        'subject',
        'description',
        'location',
        'status',
        'secretary_notes',
        'captain_resolution',
        'recommendation',
        'validated_at',
        'resolved_at',
        'validated_by',
        'resolved_by',
    ];

    protected function casts(): array
    {
        return [
            'validated_at' => 'datetime',
            'resolved_at' => 'datetime',
        ];
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($complaint) {
            if (empty($complaint->complaint_number)) {
                $complaint->complaint_number = 'CMP-' . strtoupper(uniqid());
            }
        });
    }

    /**
     * Get the user who filed the complaint
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the complaint category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ComplaintCategory::class, 'complaint_category_id');
    }

    /**
     * Get the secretary who validated the complaint
     */
    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    /**
     * Get the captain who resolved the complaint
     */
    public function resolver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('evidence')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg', 'video/mp4', 'video/mpeg', 'video/quicktime']);
    }
}
