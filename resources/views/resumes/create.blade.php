@extends('layouts.app')
@section('title', 'Create Resume – ResumeForge')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 py-10">

    <div class="mb-8">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-slate-700 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Dashboard
        </a>
        <h1 class="text-3xl font-bold text-slate-900">Create New Resume</h1>
        <p class="text-slate-500 mt-1">Choose a template to get started</p>
    </div>

    <form action="{{ route('resumes.store') }}" method="POST" x-data="{ selectedTemplate: 'classic' }">
        @csrf

        {{-- Resume Title --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-6 shadow-sm">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Resume Title</label>
            <input type="text" name="title" value="{{ old('title', 'My Resume') }}"
                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                   placeholder="e.g. Software Engineer Resume, Product Manager CV...">
            @error('title')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>

        {{-- Template Selection --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-8 shadow-sm">
            <h2 class="text-lg font-bold text-slate-800 mb-5">Choose a Template</h2>

            <input type="hidden" name="template" :value="selectedTemplate">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($templates as $key => $template)
                <label class="cursor-pointer" @click="selectedTemplate = '{{ $key }}'">
                    <div class="rounded-xl border-2 transition-all overflow-hidden"
                         :class="selectedTemplate === '{{ $key }}' ? 'border-blue-500 shadow-lg shadow-blue-100' : 'border-slate-200 hover:border-slate-300'">

                        {{-- Template Preview Thumbnail --}}
                        <div class="h-48 bg-gradient-to-br relative overflow-hidden
                            @if($key === 'classic') from-slate-100 to-slate-200
                            @elseif($key === 'modern') from-blue-600 to-blue-800
                            @elseif($key === 'minimal') from-white to-slate-50
                            @elseif($key === 'creative') from-purple-600 to-indigo-700
                            @elseif($key === 'executive') from-slate-800 to-slate-900
                            @endif
                        ">
                            {{-- Mini resume mockup --}}
                            @if($key === 'classic')
                            <div class="absolute inset-3 bg-white rounded shadow-sm p-3 flex flex-col gap-1.5">
                                <div class="w-16 h-2.5 bg-slate-700 rounded"></div>
                                <div class="w-24 h-1.5 bg-slate-400 rounded"></div>
                                <div class="border-t border-slate-200 pt-1.5 mt-1">
                                    <div class="w-12 h-1.5 bg-slate-600 rounded mb-1"></div>
                                    <div class="w-full h-1 bg-slate-200 rounded mb-0.5"></div>
                                    <div class="w-5/6 h-1 bg-slate-200 rounded"></div>
                                </div>
                            </div>
                            @elseif($key === 'modern')
                            <div class="absolute inset-3 flex flex-col gap-1.5">
                                <div class="bg-white/20 rounded p-2 backdrop-blur-sm">
                                    <div class="w-16 h-2.5 bg-white rounded mb-1"></div>
                                    <div class="w-24 h-1.5 bg-white/60 rounded"></div>
                                </div>
                                <div class="bg-white rounded shadow p-2 flex-1">
                                    <div class="w-12 h-1.5 bg-blue-600 rounded mb-1.5"></div>
                                    <div class="w-full h-1 bg-slate-200 rounded mb-0.5"></div>
                                    <div class="w-5/6 h-1 bg-slate-200 rounded"></div>
                                </div>
                            </div>
                            @elseif($key === 'minimal')
                            <div class="absolute inset-3 bg-white rounded shadow-sm p-3">
                                <div class="border-b border-slate-100 pb-2 mb-2">
                                    <div class="w-20 h-3 bg-slate-900 rounded mb-1"></div>
                                    <div class="w-28 h-1.5 bg-slate-300 rounded"></div>
                                </div>
                                <div class="w-10 h-1.5 bg-slate-800 rounded mb-1.5"></div>
                                <div class="w-full h-1 bg-slate-100 rounded mb-0.5"></div>
                                <div class="w-4/5 h-1 bg-slate-100 rounded"></div>
                            </div>
                            @elseif($key === 'creative')
                            <div class="absolute inset-3 flex gap-2">
                                <div class="w-1/3 bg-white/10 rounded p-2">
                                    <div class="w-8 h-8 bg-white/30 rounded-full mx-auto mb-1.5"></div>
                                    <div class="w-full h-1 bg-white/40 rounded mb-0.5"></div>
                                    <div class="w-full h-1 bg-white/40 rounded"></div>
                                </div>
                                <div class="flex-1 bg-white rounded shadow p-2">
                                    <div class="w-16 h-2 bg-slate-700 rounded mb-1.5"></div>
                                    <div class="w-full h-1 bg-slate-200 rounded mb-0.5"></div>
                                    <div class="w-5/6 h-1 bg-slate-200 rounded"></div>
                                </div>
                            </div>
                            @elseif($key === 'executive')
                            <div class="absolute inset-3 flex flex-col gap-1.5">
                                <div class="bg-white/10 rounded p-2">
                                    <div class="w-20 h-2.5 bg-white rounded mb-1"></div>
                                    <div class="w-16 h-1.5 bg-amber-400 rounded"></div>
                                </div>
                                <div class="bg-white rounded flex-1 p-2">
                                    <div class="w-10 h-1.5 bg-slate-800 rounded mb-1.5"></div>
                                    <div class="w-full h-1 bg-slate-200 rounded mb-0.5"></div>
                                    <div class="w-3/4 h-1 bg-slate-200 rounded"></div>
                                </div>
                            </div>
                            @endif

                            {{-- Selected badge --}}
                            <div x-show="selectedTemplate === '{{ $key }}'" class="absolute top-2 right-2 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                        </div>

                        <div class="p-3">
                            <p class="font-semibold text-slate-800 text-sm">{{ $template['name'] }}</p>
                            <p class="text-xs text-slate-500">{{ $template['description'] }}</p>
                        </div>
                    </div>
                </label>
                @endforeach
            </div>

            @error('template')<p class="mt-2 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('dashboard') }}" class="px-6 py-3 rounded-xl border border-slate-200 text-slate-700 font-medium hover:bg-slate-50 transition">Cancel</a>
            <button type="submit" class="px-8 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold hover:opacity-90 transition shadow-md shadow-blue-200">
                Create Resume & Start Editing
            </button>
        </div>
    </form>
</div>
@endsection
