<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResumeSkill extends Model
{
    protected $table = 'resume_skills';

    protected $fillable = ['resume_id', 'name', 'level', 'category', 'sort_order'];

    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }

    public function levelPercent(): int
    {
        return match ($this->level) {
            'beginner'     => 20,
            'elementary'   => 40,
            'intermediate' => 60,
            'advanced'     => 80,
            'expert'       => 100,
            default        => 60,
        };
    }
}
