<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use App\Models\ResumePersonalInfo;
use App\Models\ResumeEducation;
use App\Models\ResumeExperience;
use App\Models\ResumeSkill;
use App\Models\ResumeProject;
use App\Models\ResumeCertification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ResumeController extends Controller
{
    public function index()
    {
        return redirect()->route('dashboard');
    }

    public function create()
    {
        $templates = Resume::templates();
        return view('resumes.create', compact('templates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'    => 'required|string|max:255',
            'template' => 'required|in:classic,modern,minimal,creative,executive',
        ]);

        $resume = auth()->user()->resumes()->create([
            'title'        => $validated['title'],
            'template'     => $validated['template'],
            'slug'         => Str::slug($validated['title']) . '-' . Str::random(6),
            'accent_color' => '#2563eb',
        ]);

        $resume->personalInfo()->create(['resume_id' => $resume->id]);

        return redirect()->route('resumes.edit', $resume)->with('success', 'Resume created! Start filling in your details.');
    }

    public function edit(Resume $resume)
    {
        $this->authorize('update', $resume);

        $resume->load(['personalInfo', 'educations', 'experiences', 'skills', 'projects', 'certifications']);
        $templates = Resume::templates();

        return view('resumes.edit', compact('resume', 'templates'));
    }

    public function update(Request $request, Resume $resume)
    {
        $this->authorize('update', $resume);

        $request->validate([
            'title'        => 'required|string|max:255',
            'template'     => 'required|in:classic,modern,minimal,creative,executive',
            'accent_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $resume->update($request->only('title', 'template', 'accent_color'));

        // Personal Info
        $personalData = $request->only([
            'full_name', 'job_title', 'email', 'phone', 'address', 'city',
            'state', 'country', 'zip', 'linkedin', 'github', 'website', 'summary',
        ]);

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $personalData['profile_photo'] = $path;
        }

        $resume->personalInfo()->updateOrCreate(['resume_id' => $resume->id], $personalData);

        // Education
        $resume->educations()->delete();
        foreach ($request->input('educations', []) as $i => $edu) {
            if (!empty($edu['institution'])) {
                $resume->educations()->create(array_merge($edu, ['sort_order' => $i]));
            }
        }

        // Experience
        $resume->experiences()->delete();
        foreach ($request->input('experiences', []) as $i => $exp) {
            if (!empty($exp['company'])) {
                $resume->experiences()->create(array_merge($exp, ['sort_order' => $i]));
            }
        }

        // Skills
        $resume->skills()->delete();
        foreach ($request->input('skills', []) as $i => $skill) {
            if (!empty($skill['name'])) {
                $resume->skills()->create(array_merge($skill, ['sort_order' => $i]));
            }
        }

        // Projects
        $resume->projects()->delete();
        foreach ($request->input('projects', []) as $i => $project) {
            if (!empty($project['title'])) {
                $resume->projects()->create(array_merge($project, ['sort_order' => $i]));
            }
        }

        // Certifications
        $resume->certifications()->delete();
        foreach ($request->input('certifications', []) as $i => $cert) {
            if (!empty($cert['name'])) {
                $resume->certifications()->create(array_merge($cert, ['sort_order' => $i]));
            }
        }

        return redirect()->route('resumes.edit', $resume)->with('success', 'Resume saved successfully!');
    }

    public function destroy(Resume $resume)
    {
        $this->authorize('delete', $resume);
        $resume->delete();
        return redirect()->route('dashboard')->with('success', 'Resume deleted.');
    }

    public function duplicate(Resume $resume)
    {
        $this->authorize('view', $resume);
        $resume->load(['personalInfo', 'educations', 'experiences', 'skills', 'projects', 'certifications']);

        $newResume = $resume->replicate();
        $newResume->title = $resume->title . ' (Copy)';
        $newResume->slug  = Str::slug($resume->title) . '-' . Str::random(6);
        $newResume->save();

        if ($resume->personalInfo) {
            $pi = $resume->personalInfo->replicate();
            $pi->resume_id = $newResume->id;
            $pi->save();
        }

        foreach (['educations', 'experiences', 'skills', 'projects', 'certifications'] as $relation) {
            foreach ($resume->$relation as $item) {
                $copy = $item->replicate();
                $copy->resume_id = $newResume->id;
                $copy->save();
            }
        }

        return redirect()->route('resumes.edit', $newResume)->with('success', 'Resume duplicated!');
    }

    public function preview(Resume $resume)
    {
        $this->authorize('view', $resume);
        $resume->load(['personalInfo', 'educations', 'experiences', 'skills', 'projects', 'certifications']);
        return view('resumes.preview', compact('resume'));
    }
}
