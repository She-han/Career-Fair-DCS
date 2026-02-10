<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Company extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'contact_person',
        'email',
        'phone',
        'address',
        'description',
        'website',
        'industry',
        'access_token',
        'token_expires_at',
        'participation_response_id',
    ];

    protected function casts(): array
    {
        return [
            'token_expires_at' => 'datetime',
        ];
    }

    /**
     * Boot method to auto-generate access token
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($company) {
            if (empty($company->access_token)) {
                $company->access_token = self::generateUniqueToken();
            }
        });
    }

    /**
     * Generate a unique secure access token
     */
    public static function generateUniqueToken(): string
    {
        do {
            $token = Str::random(64);
        } while (self::where('access_token', $token)->exists());

        return $token;
    }

    /**
     * Get the public CV viewing URL
     */
    public function getAccessUrlAttribute(): string
    {
        return route('company.access', ['token' => $this->access_token]);
    }

    /**
     * Check if token is expired
     */
    public function isTokenExpired(): bool
    {
        if (is_null($this->token_expires_at)) {
            return false; // No expiry set
        }

        return $this->token_expires_at->isPast();
    }

    /**
     * Get the user that owns the company (optional now).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the participation response that created this company
     */
    public function participationResponse(): BelongsTo
    {
        return $this->belongsTo(CompanyParticipationResponse::class, 'participation_response_id');
    }

    /**
     * Get the CVs assigned to this company.
     */
    public function cvs(): BelongsToMany
    {
        return $this->belongsToMany(CV::class, 'cv_company', 'company_id', 'cv_id')
            ->withPivot('assigned_at', 'viewed_status')
            ->withTimestamps();
    }
}
