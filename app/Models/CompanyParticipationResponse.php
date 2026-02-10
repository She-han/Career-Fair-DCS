<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CompanyParticipationResponse extends Model
{
    protected $fillable = [
        'company_name',
        'contact_person',
        'email',
        'phone',
        'message',
        'interested',
        'status',
        'will_participate',
        'expected_cvs',
        'intern_positions',
        'vacant_positions',
        'preferred_languages',
        'preferred_frameworks',
        'preferred_timeslot',
        'consent_to_receive_cvs',
    ];

    protected function casts(): array
    {
        return [
            'interested' => 'boolean',
            'will_participate' => 'boolean',
            'consent_to_receive_cvs' => 'boolean',
            'vacant_positions' => 'array',
            'preferred_languages' => 'array',
            'preferred_frameworks' => 'array',
        ];
    }

    /**
     * Get the company created from this response
     */
    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'participation_response_id');
    }
}
