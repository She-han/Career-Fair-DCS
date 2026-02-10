<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'sc_number',
        'name_with_initials',
        'uni_email',
        'gpa',
        'phone',
    ];

    protected function casts(): array
    {
        return [
            'gpa' => 'decimal:2',
        ];
    }

    /**
     * Get the user that owns the student profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all CVs uploaded by this student.
     */
    public function cvs(): HasMany
    {
        return $this->hasMany(CV::class);
    }
}
