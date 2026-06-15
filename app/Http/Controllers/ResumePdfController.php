<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class ResumePdfController extends Controller
{
    public function download(Resume $resume)
    {
        $this->authorize('view', $resume);
        $resume->load(['personalInfo', 'educations', 'experiences', 'skills', 'projects', 'certifications']);

        $pdf = Pdf::loadView('resumes.pdf.' . $resume->template, compact('resume'))
            ->setPaper('a4', 'portrait')
            ->setOption('dpi', 150)
            ->setOption('defaultFont', 'DejaVu Sans');

        $filename = Str::slug($resume->title) . '-resume.pdf';

        return $pdf->download($filename);
    }
}
