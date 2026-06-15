<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResumePersonalInfo extends Model
{
    protected $table = 'resume_personal_infos';

    protected $fillable = [
        'resume_id', 'full_name', 'job_title', 'email', 'phone',
        'address', 'city', 'state', 'country', 'zip',
        'linkedin', 'github', 'website', 'profile_photo', 'summary',
    ];

    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
