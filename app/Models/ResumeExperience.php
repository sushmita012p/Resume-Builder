<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResumeExperience extends Model
{
    protected $table = 'resume_experiences';

    protected $fillable = [
        'resume_id', 'company', 'position', 'location',
        'start_date', 'end_date', 'is_current', 'description', 'sort_order',
    ];

    protected $casts = ['is_current' => 'boolean'];

    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
