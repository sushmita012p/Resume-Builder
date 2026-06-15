<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResumeProject extends Model
{
    protected $table = 'resume_projects';

    protected $fillable = [
        'resume_id', 'title', 'description', 'url', 'technologies', 'start_date', 'end_date', 'sort_order',
    ];

    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
