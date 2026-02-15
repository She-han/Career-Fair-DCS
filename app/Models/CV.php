<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CV extends Model
{
    protected $table = 'cvs';

    protected $fillable = [
        'student_id',
        'applying_job_position',
        'tech_skills',
        'cv_file_path',
        'status',
    ];

    /**
     * Get the student that owns this CV.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the companies this CV is assigned to.
     */
    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'cv_company', 'cv_id', 'company_id')
            ->withPivot('assigned_at', 'viewed_status')
            ->withTimestamps();
    }
}
