<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Resume extends Model
{
    protected $fillable = [
        'user_id', 'title', 'slug', 'template', 'accent_color', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Resume $resume) {
            if (empty($resume->slug)) {
                $resume->slug = Str::slug($resume->title) . '-' . Str::random(6);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function personalInfo()
    {
        return $this->hasOne(ResumePersonalInfo::class);
    }

    public function educations()
    {
        return $this->hasMany(ResumeEducation::class)->orderBy('sort_order');
    }

    public function experiences()
    {
        return $this->hasMany(ResumeExperience::class)->orderBy('sort_order');
    }

    public function skills()
    {
        return $this->hasMany(ResumeSkill::class)->orderBy('sort_order');
    }

    public function projects()
    {
        return $this->hasMany(ResumeProject::class)->orderBy('sort_order');
    }

    public function certifications()
    {
        return $this->hasMany(ResumeCertification::class)->orderBy('sort_order');
    }

    public static function templates(): array
    {
        return [
            'classic'   => ['name' => 'Classic',   'description' => 'Clean and traditional professional layout'],
            'modern'    => ['name' => 'Modern',    'description' => 'Contemporary design with bold typography'],
            'minimal'   => ['name' => 'Minimal',   'description' => 'Elegant minimalist style'],
            'creative'  => ['name' => 'Creative',  'description' => 'Eye-catching two-column sidebar layout'],
            'executive' => ['name' => 'Executive', 'description' => 'Sophisticated dark-header executive style'],
        ];
    }
}
