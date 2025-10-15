<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'email',
        'password',
        'role',
        'national_id',
        'national_id_image',
        'date_of_birth',
        'age',
        'gender',
        'civil_status',
        'phone',
        'address',
        'house_number',
        'street',
        'barangay',
        'city',
        'province',
        'zip_code',
        'occupation',
        'emergency_contact_name',
        'emergency_contact_number',
        'qr_code',
        'verification_status',
        'verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'verified_at' => 'datetime',
            'date_of_birth' => 'date',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's full name
     */
    public function getFullNameAttribute(): string
    {
        $name = trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
        return $this->suffix ? "{$name} {$this->suffix}" : $name;
    }

    /**
     * Get the user's complete address
     */
    public function getCompleteAddressAttribute(): string
    {
        $parts = array_filter([
            $this->house_number,
            $this->street,
            $this->barangay,
            $this->city,
            $this->province,
            $this->zip_code,
        ]);
        
        return implode(', ', $parts);
    }

    /**
     * Check if user is a citizen
     */
    public function isCitizen(): bool
    {
        return $this->role === 'citizen';
    }

    /**
     * Check if user is a secretary
     */
    public function isSecretary(): bool
    {
        return $this->role === 'secretary';
    }

    /**
     * Check if user is a captain
     */
    public function isCaptain(): bool
    {
        return $this->role === 'captain';
    }

    /**
     * Check if user is verified
     */
    public function isVerified(): bool
    {
        return $this->verification_status === 'approved';
    }

    /**
     * Get the complaints filed by this user
     */
    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }

    /**
     * Get the complaints validated by this user (secretary)
     */
    public function validatedComplaints(): HasMany
    {
        return $this->hasMany(Complaint::class, 'validated_by');
    }

    /**
     * Get the complaints resolved by this user (captain)
     */
    public function resolvedComplaints(): HasMany
    {
        return $this->hasMany(Complaint::class, 'resolved_by');
    }
}
