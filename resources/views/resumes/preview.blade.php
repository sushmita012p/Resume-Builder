<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $resume->personalInfo?->full_name ?? $resume->title }} – Resume</title>
    @vite(['resources/css/app.css'])
    <style>
        @media print { .no-print { display: none !important; } body { background: white !important; } }
    </style>
</head>
<body class="bg-slate-200 min-h-screen">

    {{-- Preview Toolbar --}}
    <div class="no-print sticky top-0 z-10 bg-slate-800 text-white px-6 py-3 flex items-center justify-between shadow-lg">
        <div class="flex items-center gap-3">
            <a href="{{ route('resumes.edit', $resume) }}" class="p-2 rounded-lg hover:bg-slate-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <p class="font-semibold text-sm">{{ $resume->title }}</p>
                <p class="text-slate-400 text-xs capitalize">{{ $resume->template }} template</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('resumes.edit', $resume) }}" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-700 hover:bg-slate-600 text-sm font-medium transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
            <a href="{{ route('resumes.download', $resume) }}" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-500 text-sm font-semibold transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Download PDF
            </a>
        </div>
    </div>

    {{-- A4 Resume --}}
    <div class="flex justify-center py-8 px-4">
        <div class="bg-white shadow-2xl w-full max-w-[794px]" style="min-height: 1123px;">
            @include('resumes.templates.' . $resume->template, ['resume' => $resume])
        </div>
    </div>
</body>
</html>
