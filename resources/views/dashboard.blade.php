@extends('layouts.app')
@section('title', 'Dashboard – ResumeForge')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">My Resumes</h1>
            <p class="text-slate-500 mt-1">Manage and download your professional resumes</p>
        </div>
        <a href="{{ route('resumes.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold px-5 py-2.5 rounded-xl hover:opacity-90 transition shadow-md shadow-blue-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Resume
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        @php
            $total    = $resumes->count();
            $templates = $resumes->groupBy('template');
        @endphp
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
            <p class="text-sm text-slate-500 mb-1">Total Resumes</p>
            <p class="text-3xl font-bold text-slate-900">{{ $total }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
            <p class="text-sm text-slate-500 mb-1">Templates Used</p>
            <p class="text-3xl font-bold text-slate-900">{{ $templates->count() }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
            <p class="text-sm text-slate-500 mb-1">Last Updated</p>
            <p class="text-base font-semibold text-slate-700">{{ $resumes->first()?->updated_at?->diffForHumans() ?? '—' }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
            <p class="text-sm text-slate-500 mb-1">Member Since</p>
            <p class="text-base font-semibold text-slate-700">{{ auth()->user()->created_at->format('M Y') }}</p>
        </div>
    </div>

    {{-- Resume Grid --}}
    @if($resumes->isEmpty())
        <div class="text-center py-24">
            <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-700 mb-2">No resumes yet</h3>
            <p class="text-slate-500 mb-6">Create your first professional resume in minutes</p>
            <a href="{{ route('resumes.create') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white font-semibold px-6 py-3 rounded-xl hover:bg-blue-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Create Your First Resume
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($resumes as $resume)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow overflow-hidden group">
                {{-- Template color bar --}}
                <div class="h-2" style="background: {{ $resume->accent_color }}"></div>

                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-slate-800 text-lg truncate">{{ $resume->title }}</h3>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600 capitalize">
                                    {{ $resume->template }}
                                </span>
                                <span class="text-xs text-slate-400">{{ $resume->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 ml-3" style="background: {{ $resume->accent_color }}20">
                            <svg class="w-5 h-5" style="color: {{ $resume->accent_color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                    </div>

                    {{-- Sections filled indicator --}}
                    @php
                        $resume->loadCount(['educations', 'experiences', 'skills', 'projects', 'certifications']);
                        $totalItems = $resume->educations_count + $resume->experiences_count + $resume->skills_count;
                    @endphp
                    <div class="flex items-center gap-1 mb-5">
                        <div class="flex-1 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all" style="background: {{ $resume->accent_color }}; width: {{ min(100, ($totalItems / 10) * 100) }}%"></div>
                        </div>
                        <span class="text-xs text-slate-400 ml-2">{{ $totalItems }} items</span>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2">
                        <a href="{{ route('resumes.edit', $resume) }}" class="flex-1 text-center py-2 rounded-lg text-sm font-semibold text-white transition hover:opacity-90" style="background: {{ $resume->accent_color }}">
                            Edit
                        </a>
                        <a href="{{ route('resumes.preview', $resume) }}" target="_blank" class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 transition" title="Preview">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        <a href="{{ route('resumes.download', $resume) }}" class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 transition" title="Download PDF">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </a>
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01"/></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 bottom-10 w-44 bg-white rounded-xl shadow-lg border border-slate-200 py-1 z-20">
                                <form action="{{ route('resumes.duplicate', $resume) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-2 w-full px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                        Duplicate
                                    </button>
                                </form>
                                <form action="{{ route('resumes.destroy', $resume) }}" method="POST"
                                      onsubmit="return confirm('Delete this resume? This cannot be undone.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Add new card --}}
            <a href="{{ route('resumes.create') }}" class="bg-white rounded-2xl border-2 border-dashed border-slate-200 hover:border-blue-400 hover:bg-blue-50/50 transition-all p-6 flex flex-col items-center justify-center gap-3 text-center min-h-[200px] group">
                <div class="w-12 h-12 bg-slate-100 group-hover:bg-blue-100 rounded-full flex items-center justify-center transition-colors">
                    <svg class="w-6 h-6 text-slate-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </div>
                <div>
                    <p class="font-semibold text-slate-600 group-hover:text-blue-600 transition-colors">New Resume</p>
                    <p class="text-sm text-slate-400">Start from a template</p>
                </div>
            </a>
        </div>
    @endif
</div>
@endsection
