<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResumeEducation extends Model
{
    protected $table = 'resume_educations';

    protected $fillable = [
        'resume_id', 'institution', 'degree', 'field_of_study',
        'start_date', 'end_date', 'is_current', 'gpa', 'description', 'sort_order',
    ];

    protected $casts = ['is_current' => 'boolean'];

    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
