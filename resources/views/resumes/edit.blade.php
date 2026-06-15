@extends('layouts.app')
@section('title', 'Edit: ' . $resume->title . ' – ResumeForge')

@push('styles')
<style>
    .tab-btn.active { @apply bg-blue-50 text-blue-700 font-semibold; }
    .form-input { @apply w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white; }
    .form-label { @apply block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5; }
    .section-card { @apply bg-white rounded-2xl border border-slate-200 p-5 shadow-sm; }
</style>
@endpush

@section('content')
<div class="h-[calc(100vh-64px)] flex overflow-hidden"
     x-data="resumeEditor()"
     x-init="init()">

    {{-- LEFT PANEL: Editor --}}
    <div class="w-full lg:w-1/2 xl:w-2/5 flex flex-col bg-slate-50 border-r border-slate-200 overflow-hidden">

        {{-- Editor Top Bar --}}
        <div class="bg-white border-b border-slate-200 px-4 py-3 flex items-center gap-3 shrink-0">
            <a href="{{ route('dashboard') }}" class="p-2 rounded-lg hover:bg-slate-100 text-slate-500 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div class="flex-1 min-w-0">
                <h1 class="font-bold text-slate-800 truncate text-sm">{{ $resume->title }}</h1>
                <p class="text-xs text-slate-400 capitalize">{{ $resume->template }} template</p>
            </div>
            <button @click="saveResume()" :disabled="saving"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition disabled:opacity-60">
                <svg x-show="!saving" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <svg x-show="saving" class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                <span x-text="saving ? 'Saving…' : 'Save'"></span>
            </button>
            <a href="{{ route('resumes.download', $resume) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-800 text-white text-sm font-semibold hover:bg-slate-900 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                PDF
            </a>
        </div>

        {{-- Section Tabs --}}
        <div class="bg-white border-b border-slate-200 px-4 flex gap-1 overflow-x-auto shrink-0 py-2 scrollbar-hide">
            @foreach(['personal' => 'Personal', 'experience' => 'Experience', 'education' => 'Education', 'skills' => 'Skills', 'projects' => 'Projects', 'certifications' => 'Certifications', 'settings' => 'Settings'] as $tab => $label)
            <button @click="activeTab = '{{ $tab }}'"
                    :class="activeTab === '{{ $tab }}' ? 'bg-blue-600 text-white' : 'text-slate-600 hover:bg-slate-100'"
                    class="px-3 py-1.5 rounded-lg text-xs font-semibold whitespace-nowrap transition shrink-0">
                {{ $label }}
            </button>
            @endforeach
        </div>

        {{-- Tab Content (scrollable) --}}
        <div class="flex-1 overflow-y-auto p-4 space-y-4">

            {{-- ═══ PERSONAL INFO ═══ --}}
            <div x-show="activeTab === 'personal'" x-transition>
                <div class="section-card">
                    <h3 class="font-bold text-slate-700 mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center"><svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></span>
                        Personal Information
                    </h3>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="col-span-2">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-input" x-model="form.full_name" placeholder="John Doe">
                        </div>
                        <div class="col-span-2">
                            <label class="form-label">Job Title</label>
                            <input type="text" class="form-input" x-model="form.job_title" placeholder="Senior Software Engineer">
                        </div>
                        <div>
                            <label class="form-label">Email</label>
                            <input type="email" class="form-input" x-model="form.email" placeholder="john@example.com">
                        </div>
                        <div>
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-input" x-model="form.phone" placeholder="+1 (555) 000-0000">
                        </div>
                        <div>
                            <label class="form-label">City</label>
                            <input type="text" class="form-input" x-model="form.city" placeholder="New York">
                        </div>
                        <div>
                            <label class="form-label">Country</label>
                            <input type="text" class="form-input" x-model="form.country" placeholder="USA">
                        </div>
                        <div>
                            <label class="form-label">LinkedIn</label>
                            <input type="text" class="form-input" x-model="form.linkedin" placeholder="linkedin.com/in/username">
                        </div>
                        <div>
                            <label class="form-label">GitHub</label>
                            <input type="text" class="form-input" x-model="form.github" placeholder="github.com/username">
                        </div>
                        <div class="col-span-2">
                            <label class="form-label">Website</label>
                            <input type="text" class="form-input" x-model="form.website" placeholder="https://yourportfolio.com">
                        </div>
                        <div class="col-span-2">
                            <label class="form-label">Professional Summary</label>
                            <textarea class="form-input resize-none" x-model="form.summary" rows="5"
                                      placeholder="Brief overview of your professional background, key skills, and career goals..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══ EXPERIENCE ═══ --}}
            <div x-show="activeTab === 'experience'" x-transition>
                <template x-for="(exp, index) in form.experiences" :key="index">
                    <div class="section-card mb-3">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-semibold text-slate-700 text-sm" x-text="exp.company || 'New Experience'"></h4>
                            <button @click="removeItem(form.experiences, index)" class="p-1.5 rounded-lg text-red-400 hover:bg-red-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="form-label">Company</label>
                                <input type="text" class="form-input" x-model="exp.company" placeholder="Acme Corp">
                            </div>
                            <div>
                                <label class="form-label">Position</label>
                                <input type="text" class="form-input" x-model="exp.position" placeholder="Senior Developer">
                            </div>
                            <div>
                                <label class="form-label">Location</label>
                                <input type="text" class="form-input" x-model="exp.location" placeholder="New York, NY">
                            </div>
                            <div>
                                <label class="form-label">Start Date</label>
                                <input type="text" class="form-input" x-model="exp.start_date" placeholder="Jan 2020">
                            </div>
                            <div>
                                <label class="form-label">End Date</label>
                                <input type="text" class="form-input" x-model="exp.end_date" :placeholder="exp.is_current ? 'Present' : 'Dec 2023'" :disabled="exp.is_current">
                            </div>
                            <div class="flex items-center gap-2 pt-5">
                                <input type="checkbox" :id="'current-exp-' + index" x-model="exp.is_current" class="w-4 h-4 rounded text-blue-600">
                                <label :for="'current-exp-' + index" class="text-sm text-slate-600 cursor-pointer">Currently working here</label>
                            </div>
                            <div class="col-span-2">
                                <label class="form-label">Description</label>
                                <textarea class="form-input resize-none" x-model="exp.description" rows="4"
                                          placeholder="• Led team of 5 engineers to deliver key features&#10;• Improved system performance by 40%&#10;• Implemented CI/CD pipeline"></textarea>
                            </div>
                        </div>
                    </div>
                </template>
                <button @click="addItem(form.experiences, {company:'',position:'',location:'',start_date:'',end_date:'',is_current:false,description:''})"
                        class="w-full py-3 border-2 border-dashed border-slate-300 hover:border-blue-400 text-slate-500 hover:text-blue-600 rounded-xl text-sm font-medium transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Work Experience
                </button>
            </div>

            {{-- ═══ EDUCATION ═══ --}}
            <div x-show="activeTab === 'education'" x-transition>
                <template x-for="(edu, index) in form.educations" :key="index">
                    <div class="section-card mb-3">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-semibold text-slate-700 text-sm" x-text="edu.institution || 'New Education'"></h4>
                            <button @click="removeItem(form.educations, index)" class="p-1.5 rounded-lg text-red-400 hover:bg-red-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="col-span-2">
                                <label class="form-label">Institution</label>
                                <input type="text" class="form-input" x-model="edu.institution" placeholder="MIT">
                            </div>
                            <div>
                                <label class="form-label">Degree</label>
                                <input type="text" class="form-input" x-model="edu.degree" placeholder="Bachelor's">
                            </div>
                            <div>
                                <label class="form-label">Field of Study</label>
                                <input type="text" class="form-input" x-model="edu.field_of_study" placeholder="Computer Science">
                            </div>
                            <div>
                                <label class="form-label">Start Date</label>
                                <input type="text" class="form-input" x-model="edu.start_date" placeholder="Sep 2018">
                            </div>
                            <div>
                                <label class="form-label">End Date</label>
                                <input type="text" class="form-input" x-model="edu.end_date" :placeholder="edu.is_current ? 'Present' : 'May 2022'" :disabled="edu.is_current">
                            </div>
                            <div>
                                <label class="form-label">GPA</label>
                                <input type="text" class="form-input" x-model="edu.gpa" placeholder="3.8 / 4.0">
                            </div>
                            <div class="flex items-center gap-2 pt-5">
                                <input type="checkbox" :id="'current-edu-' + index" x-model="edu.is_current" class="w-4 h-4 rounded text-blue-600">
                                <label :for="'current-edu-' + index" class="text-sm text-slate-600 cursor-pointer">Currently studying</label>
                            </div>
                            <div class="col-span-2">
                                <label class="form-label">Description (Optional)</label>
                                <textarea class="form-input resize-none" x-model="edu.description" rows="2" placeholder="Relevant coursework, honors, activities..."></textarea>
                            </div>
                        </div>
                    </div>
                </template>
                <button @click="addItem(form.educations, {institution:'',degree:'',field_of_study:'',start_date:'',end_date:'',is_current:false,gpa:'',description:''})"
                        class="w-full py-3 border-2 border-dashed border-slate-300 hover:border-blue-400 text-slate-500 hover:text-blue-600 rounded-xl text-sm font-medium transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Education
                </button>
            </div>

            {{-- ═══ SKILLS ═══ --}}
            <div x-show="activeTab === 'skills'" x-transition>
                <div class="section-card mb-3">
                    <div class="space-y-2">
                        <template x-for="(skill, index) in form.skills" :key="index">
                            <div class="flex items-center gap-2">
                                <input type="text" class="form-input flex-1" x-model="skill.name" placeholder="e.g. JavaScript, Python, Figma">
                                <select class="form-input w-36" x-model="skill.level">
                                    <option value="beginner">Beginner</option>
                                    <option value="elementary">Elementary</option>
                                    <option value="intermediate">Intermediate</option>
                                    <option value="advanced">Advanced</option>
                                    <option value="expert">Expert</option>
                                </select>
                                <input type="text" class="form-input w-28" x-model="skill.category" placeholder="Category">
                                <button @click="removeItem(form.skills, index)" class="p-2 rounded-lg text-red-400 hover:bg-red-50 transition shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
                <button @click="addItem(form.skills, {name:'',level:'intermediate',category:''})"
                        class="w-full py-3 border-2 border-dashed border-slate-300 hover:border-blue-400 text-slate-500 hover:text-blue-600 rounded-xl text-sm font-medium transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Skill
                </button>
            </div>

            {{-- ═══ PROJECTS ═══ --}}
            <div x-show="activeTab === 'projects'" x-transition>
                <template x-for="(proj, index) in form.projects" :key="index">
                    <div class="section-card mb-3">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-semibold text-slate-700 text-sm" x-text="proj.title || 'New Project'"></h4>
                            <button @click="removeItem(form.projects, index)" class="p-1.5 rounded-lg text-red-400 hover:bg-red-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="col-span-2">
                                <label class="form-label">Project Title</label>
                                <input type="text" class="form-input" x-model="proj.title" placeholder="E-commerce Platform">
                            </div>
                            <div>
                                <label class="form-label">Technologies</label>
                                <input type="text" class="form-input" x-model="proj.technologies" placeholder="React, Node.js, MongoDB">
                            </div>
                            <div>
                                <label class="form-label">Project URL</label>
                                <input type="text" class="form-input" x-model="proj.url" placeholder="github.com/...">
                            </div>
                            <div>
                                <label class="form-label">Start Date</label>
                                <input type="text" class="form-input" x-model="proj.start_date" placeholder="Jan 2023">
                            </div>
                            <div>
                                <label class="form-label">End Date</label>
                                <input type="text" class="form-input" x-model="proj.end_date" placeholder="Mar 2023">
                            </div>
                            <div class="col-span-2">
                                <label class="form-label">Description</label>
                                <textarea class="form-input resize-none" x-model="proj.description" rows="3" placeholder="What this project does and your role..."></textarea>
                            </div>
                        </div>
                    </div>
                </template>
                <button @click="addItem(form.projects, {title:'',description:'',url:'',technologies:'',start_date:'',end_date:''})"
                        class="w-full py-3 border-2 border-dashed border-slate-300 hover:border-blue-400 text-slate-500 hover:text-blue-600 rounded-xl text-sm font-medium transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Project
                </button>
            </div>

            {{-- ═══ CERTIFICATIONS ═══ --}}
            <div x-show="activeTab === 'certifications'" x-transition>
                <template x-for="(cert, index) in form.certifications" :key="index">
                    <div class="section-card mb-3">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-semibold text-slate-700 text-sm" x-text="cert.name || 'New Certification'"></h4>
                            <button @click="removeItem(form.certifications, index)" class="p-1.5 rounded-lg text-red-400 hover:bg-red-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="col-span-2">
                                <label class="form-label">Certification Name</label>
                                <input type="text" class="form-input" x-model="cert.name" placeholder="AWS Solutions Architect">
                            </div>
                            <div>
                                <label class="form-label">Issuing Organization</label>
                                <input type="text" class="form-input" x-model="cert.issuer" placeholder="Amazon Web Services">
                            </div>
                            <div>
                                <label class="form-label">Credential ID</label>
                                <input type="text" class="form-input" x-model="cert.credential_id" placeholder="ABC-12345">
                            </div>
                            <div>
                                <label class="form-label">Issue Date</label>
                                <input type="text" class="form-input" x-model="cert.issue_date" placeholder="Jan 2023">
                            </div>
                            <div>
                                <label class="form-label">Expiry Date</label>
                                <input type="text" class="form-input" x-model="cert.expiry_date" placeholder="Jan 2026">
                            </div>
                            <div class="col-span-2">
                                <label class="form-label">Credential URL</label>
                                <input type="text" class="form-input" x-model="cert.url" placeholder="https://verify.example.com/...">
                            </div>
                        </div>
                    </div>
                </template>
                <button @click="addItem(form.certifications, {name:'',issuer:'',issue_date:'',expiry_date:'',credential_id:'',url:''})"
                        class="w-full py-3 border-2 border-dashed border-slate-300 hover:border-blue-400 text-slate-500 hover:text-blue-600 rounded-xl text-sm font-medium transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Certification
                </button>
            </div>

            {{-- ═══ SETTINGS ═══ --}}
            <div x-show="activeTab === 'settings'" x-transition>
                <div class="section-card">
                    <h3 class="font-bold text-slate-700 mb-4">Resume Settings</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="form-label">Resume Title</label>
                            <input type="text" class="form-input" x-model="form.title" placeholder="My Resume">
                        </div>
                        <div>
                            <label class="form-label">Template</label>
                            <select class="form-input" x-model="form.template">
                                @foreach($templates as $key => $tmpl)
                                <option value="{{ $key }}">{{ $tmpl['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Accent Color</label>
                            <div class="flex items-center gap-3">
                                <input type="color" x-model="form.accent_color" class="w-12 h-10 rounded-lg border border-slate-200 cursor-pointer p-1">
                                <input type="text" class="form-input flex-1" x-model="form.accent_color" placeholder="#2563eb">
                                <div class="flex gap-2">
                                    @foreach(['#2563eb', '#dc2626', '#16a34a', '#9333ea', '#ea580c', '#0891b2', '#1e293b', '#b45309'] as $color)
                                    <button type="button" @click="form.accent_color = '{{ $color }}'"
                                            class="w-7 h-7 rounded-full border-2 transition hover:scale-110"
                                            :class="form.accent_color === '{{ $color }}' ? 'border-slate-600 scale-110' : 'border-transparent'"
                                            style="background: {{ $color }}"></button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>{{-- end tab content --}}
    </div>

    {{-- RIGHT PANEL: Live Preview --}}
    <div class="hidden lg:flex flex-col flex-1 bg-slate-300 overflow-hidden">
        <div class="bg-slate-800 px-4 py-2 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                <div class="w-3 h-3 rounded-full bg-green-500"></div>
            </div>
            <span class="text-slate-400 text-xs font-medium">Live Preview</span>
            <a href="{{ route('resumes.preview', $resume) }}" target="_blank"
               class="text-slate-400 hover:text-white text-xs flex items-center gap-1 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Open Full
            </a>
        </div>
        <div class="flex-1 overflow-y-auto p-6 flex justify-center">
            <div class="w-full max-w-[794px] shadow-2xl" style="min-height: 1123px;">
                {{-- Live Preview rendered via JS template --}}
                <div id="preview-container" class="bg-white w-full" style="min-height: 1123px;">
                    <div x-html="renderPreview()" class="w-full h-full"></div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Hidden form for submission --}}
<form id="resumeForm" method="POST" action="{{ route('resumes.update', $resume) }}" class="hidden">
    @csrf @method('PUT')
</form>
@endsection

@push('scripts')
<script>
function resumeEditor() {
    return {
        activeTab: 'personal',
        saving: false,
        form: {
            title: @json($resume->title),
            template: @json($resume->template),
            accent_color: @json($resume->accent_color),
            full_name: @json($resume->personalInfo?->full_name ?? ''),
            job_title: @json($resume->personalInfo?->job_title ?? ''),
            email: @json($resume->personalInfo?->email ?? ''),
            phone: @json($resume->personalInfo?->phone ?? ''),
            city: @json($resume->personalInfo?->city ?? ''),
            state: @json($resume->personalInfo?->state ?? ''),
            country: @json($resume->personalInfo?->country ?? ''),
            address: @json($resume->personalInfo?->address ?? ''),
            zip: @json($resume->personalInfo?->zip ?? ''),
            linkedin: @json($resume->personalInfo?->linkedin ?? ''),
            github: @json($resume->personalInfo?->github ?? ''),
            website: @json($resume->personalInfo?->website ?? ''),
            summary: @json($resume->personalInfo?->summary ?? ''),
            experiences: @json($resume->experiences->map(fn($e) => $e->toArray())),
            educations: @json($resume->educations->map(fn($e) => $e->toArray())),
            skills: @json($resume->skills->map(fn($s) => $s->toArray())),
            projects: @json($resume->projects->map(fn($p) => $p->toArray())),
            certifications: @json($resume->certifications->map(fn($c) => $c->toArray())),
        },

        init() {
            // auto-save every 60s
            setInterval(() => this.autoSave(), 60000);
        },

        addItem(arr, template) {
            arr.push({...template});
        },

        removeItem(arr, index) {
            arr.splice(index, 1);
        },

        async saveResume() {
            this.saving = true;
            try {
                const form = document.getElementById('resumeForm');
                const data = new FormData(form);

                // Append all form fields
                const fields = ['title', 'template', 'accent_color', 'full_name', 'job_title',
                    'email', 'phone', 'city', 'state', 'country', 'address', 'zip',
                    'linkedin', 'github', 'website', 'summary'];

                fields.forEach(field => {
                    if (this.form[field] !== null && this.form[field] !== undefined) {
                        data.append(field, this.form[field]);
                    }
                });

                ['experiences', 'educations', 'skills', 'projects', 'certifications'].forEach(section => {
                    this.form[section].forEach((item, i) => {
                        Object.keys(item).forEach(key => {
                            if (!['id', 'resume_id', 'created_at', 'updated_at', 'sort_order'].includes(key)) {
                                data.append(`${section}[${i}][${key}]`, item[key] ?? '');
                            }
                        });
                    });
                });

                const response = await fetch(form.action, {
                    method: 'POST',
                    body: data,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                if (response.ok || response.redirected) {
                    this.showToast('Resume saved!', 'success');
                } else {
                    this.showToast('Save failed. Please try again.', 'error');
                }
            } catch (e) {
                this.showToast('Network error.', 'error');
            }
            this.saving = false;
        },

        autoSave() {
            if (!this.saving) this.saveResume();
        },

        showToast(msg, type) {
            const toast = document.createElement('div');
            toast.className = `fixed bottom-6 right-6 z-50 px-5 py-3 rounded-xl shadow-lg text-white text-sm font-medium flex items-center gap-2 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
            toast.innerHTML = msg;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        },

        skillPercent(level) {
            const map = {beginner:20, elementary:40, intermediate:60, advanced:80, expert:100};
            return map[level] || 60;
        },

        esc(str) {
            if (!str) return '';
            return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
        },

        renderPreview() {
            const f = this.form;
            const color = f.accent_color || '#2563eb';
            const template = f.template || 'classic';
            const name = this.esc(f.full_name) || 'Your Name';
            const title = this.esc(f.job_title) || '';

            if (template === 'modern') return this.renderModern(f, color);
            if (template === 'minimal') return this.renderMinimal(f, color);
            if (template === 'creative') return this.renderCreative(f, color);
            if (template === 'executive') return this.renderExecutive(f, color);
            return this.renderClassic(f, color);
        },

        renderClassic(f, color) {
            const e = this.esc.bind(this);
            return `
            <div style="font-family: 'DejaVu Sans', Arial, sans-serif; padding: 40px; color: #1e293b; line-height: 1.5;">
                <div style="border-bottom: 3px solid ${color}; padding-bottom: 20px; margin-bottom: 24px;">
                    <h1 style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0 0 4px;">${e(f.full_name) || 'Your Name'}</h1>
                    <p style="font-size: 16px; color: ${color}; font-weight: 600; margin: 0 0 8px;">${e(f.job_title) || ''}</p>
                    <div style="display: flex; flex-wrap: wrap; gap: 16px; font-size: 12px; color: #64748b;">
                        ${f.email ? `<span>✉ ${e(f.email)}</span>` : ''}
                        ${f.phone ? `<span>✆ ${e(f.phone)}</span>` : ''}
                        ${(f.city || f.country) ? `<span>📍 ${[e(f.city), e(f.country)].filter(Boolean).join(', ')}</span>` : ''}
                        ${f.linkedin ? `<span>in ${e(f.linkedin)}</span>` : ''}
                        ${f.github ? `<span>⌥ ${e(f.github)}</span>` : ''}
                    </div>
                </div>
                ${f.summary ? `<div style="margin-bottom: 20px;"><h2 style="font-size: 13px; font-weight: 700; color: ${color}; text-transform: uppercase; letter-spacing: 1.5px; margin: 0 0 8px; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px;">Summary</h2><p style="font-size: 13px; color: #475569;">${e(f.summary)}</p></div>` : ''}
                ${f.experiences.length ? `<div style="margin-bottom: 20px;"><h2 style="font-size: 13px; font-weight: 700; color: ${color}; text-transform: uppercase; letter-spacing: 1.5px; margin: 0 0 12px; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px;">Experience</h2>${f.experiences.map(exp => `<div style="margin-bottom: 14px;"><div style="display: flex; justify-content: space-between; align-items: flex-start;"><div><strong style="font-size: 14px;">${e(exp.position)}</strong> <span style="color: #64748b;">at</span> <span style="color: ${color}; font-weight: 600;">${e(exp.company)}</span></div><span style="font-size: 12px; color: #94a3b8;">${e(exp.start_date)} – ${exp.is_current ? 'Present' : e(exp.end_date)}</span></div>${exp.location ? `<p style="font-size: 12px; color: #94a3b8; margin: 2px 0;">${e(exp.location)}</p>` : ''}${exp.description ? `<p style="font-size: 13px; color: #475569; margin: 6px 0 0; white-space: pre-line;">${e(exp.description)}</p>` : ''}</div>`).join('')}</div>` : ''}
                ${f.educations.length ? `<div style="margin-bottom: 20px;"><h2 style="font-size: 13px; font-weight: 700; color: ${color}; text-transform: uppercase; letter-spacing: 1.5px; margin: 0 0 12px; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px;">Education</h2>${f.educations.map(edu => `<div style="margin-bottom: 10px;"><div style="display: flex; justify-content: space-between;"><div><strong>${e(edu.degree)} in ${e(edu.field_of_study)}</strong><br><span style="color: ${color};">${e(edu.institution)}</span></div><span style="font-size: 12px; color: #94a3b8;">${e(edu.start_date)} – ${edu.is_current ? 'Present' : e(edu.end_date)}</span></div>${edu.gpa ? `<span style="font-size: 12px; color: #64748b;">GPA: ${e(edu.gpa)}</span>` : ''}</div>`).join('')}</div>` : ''}
                ${f.skills.length ? `<div style="margin-bottom: 20px;"><h2 style="font-size: 13px; font-weight: 700; color: ${color}; text-transform: uppercase; letter-spacing: 1.5px; margin: 0 0 12px; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px;">Skills</h2><div style="display: flex; flex-wrap: wrap; gap: 8px;">${f.skills.map(s => `<span style="background: ${color}18; color: ${color}; padding: 3px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">${e(s.name)}</span>`).join('')}</div></div>` : ''}
                ${f.projects.length ? `<div style="margin-bottom: 20px;"><h2 style="font-size: 13px; font-weight: 700; color: ${color}; text-transform: uppercase; letter-spacing: 1.5px; margin: 0 0 12px; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px;">Projects</h2>${f.projects.map(p => `<div style="margin-bottom: 10px;"><strong style="font-size: 14px;">${e(p.title)}</strong>${p.technologies ? `<span style="font-size: 12px; color: #64748b; margin-left: 8px;">[${e(p.technologies)}]</span>` : ''}${p.description ? `<p style="font-size: 13px; color: #475569; margin: 4px 0 0;">${e(p.description)}</p>` : ''}</div>`).join('')}</div>` : ''}
                ${f.certifications.length ? `<div><h2 style="font-size: 13px; font-weight: 700; color: ${color}; text-transform: uppercase; letter-spacing: 1.5px; margin: 0 0 12px; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px;">Certifications</h2>${f.certifications.map(c => `<div style="margin-bottom: 8px;"><strong>${e(c.name)}</strong> <span style="color: #64748b; font-size: 12px;">– ${e(c.issuer)}</span>${c.issue_date ? `<span style="font-size: 12px; color: #94a3b8; margin-left: 8px;">${e(c.issue_date)}</span>` : ''}</div>`).join('')}</div>` : ''}
            </div>`;
        },

        renderModern(f, color) {
            const e = this.esc.bind(this);
            return `
            <div style="font-family: Arial, sans-serif; color: #1e293b;">
                <div style="background: linear-gradient(135deg, ${color}, ${color}dd); padding: 36px 40px; color: white;">
                    <h1 style="font-size: 32px; font-weight: 900; margin: 0 0 6px; letter-spacing: -0.5px;">${e(f.full_name) || 'Your Name'}</h1>
                    <p style="font-size: 16px; opacity: 0.9; margin: 0 0 16px; font-weight: 500;">${e(f.job_title) || ''}</p>
                    <div style="display: flex; flex-wrap: wrap; gap: 16px; font-size: 12px; opacity: 0.85;">
                        ${f.email ? `<span>✉ ${e(f.email)}</span>` : ''}
                        ${f.phone ? `<span>✆ ${e(f.phone)}</span>` : ''}
                        ${(f.city || f.country) ? `<span>📍 ${[e(f.city), e(f.country)].filter(Boolean).join(', ')}</span>` : ''}
                        ${f.linkedin ? `<span>🔗 ${e(f.linkedin)}</span>` : ''}
                    </div>
                </div>
                <div style="padding: 32px 40px;">
                    ${f.summary ? `<div style="background: ${color}0d; border-left: 4px solid ${color}; padding: 16px; border-radius: 0 8px 8px 0; margin-bottom: 24px;"><p style="font-size: 13px; color: #475569; margin: 0; line-height: 1.6;">${e(f.summary)}</p></div>` : ''}
                    ${f.experiences.length ? `<div style="margin-bottom: 24px;"><h2 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0 0 16px; display: flex; align-items: center; gap: 8px;"><span style="width: 28px; height: 28px; background: ${color}; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; color: white; font-size: 14px;">W</span>Experience</h2>${f.experiences.map(exp => `<div style="margin-bottom: 16px; padding-left: 36px; position: relative;"><div style="position: absolute; left: 10px; top: 6px; width: 8px; height: 8px; border-radius: 50%; background: ${color};"></div><div style="display: flex; justify-content: space-between; margin-bottom: 2px;"><strong style="font-size: 14px; color: #0f172a;">${e(exp.position)}</strong><span style="font-size: 11px; background: ${color}15; color: ${color}; padding: 2px 8px; border-radius: 12px;">${e(exp.start_date)} – ${exp.is_current ? 'Present' : e(exp.end_date)}</span></div><p style="font-size: 13px; color: ${color}; font-weight: 600; margin: 0 0 4px;">${e(exp.company)}</p>${exp.description ? `<p style="font-size: 12px; color: #64748b; margin: 4px 0 0; white-space: pre-line;">${e(exp.description)}</p>` : ''}</div>`).join('')}</div>` : ''}
                    ${f.educations.length ? `<div style="margin-bottom: 24px;"><h2 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0 0 16px; display: flex; align-items: center; gap: 8px;"><span style="width: 28px; height: 28px; background: ${color}; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; color: white; font-size: 14px;">E</span>Education</h2>${f.educations.map(edu => `<div style="margin-bottom: 10px; padding-left: 36px; position: relative;"><div style="position: absolute; left: 10px; top: 6px; width: 8px; height: 8px; border-radius: 50%; background: ${color};"></div><strong>${e(edu.degree)} in ${e(edu.field_of_study)}</strong><p style="color: ${color}; font-size: 13px; margin: 2px 0;">${e(edu.institution)}</p><span style="font-size: 11px; color: #94a3b8;">${e(edu.start_date)} – ${edu.is_current ? 'Present' : e(edu.end_date)}</span></div>`).join('')}</div>` : ''}
                    ${f.skills.length ? `<div><h2 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0 0 16px; display: flex; align-items: center; gap: 8px;"><span style="width: 28px; height: 28px; background: ${color}; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; color: white; font-size: 14px;">S</span>Skills</h2><div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">${f.skills.map(s => `<div><div style="display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 3px;"><span style="font-weight: 500;">${e(s.name)}</span><span style="color: #94a3b8; text-transform: capitalize;">${e(s.level)}</span></div><div style="background: #e2e8f0; border-radius: 4px; height: 4px;"><div style="background: ${color}; height: 100%; border-radius: 4px; width: ${this.skillPercent(s.level)}%;"></div></div></div>`).join('')}</div></div>` : ''}
                </div>
            </div>`;
        },

        renderMinimal(f, color) {
            const e = this.esc.bind(this);
            return `
            <div style="font-family: 'Georgia', serif; padding: 50px; color: #1e293b; max-width: 100%;">
                <div style="text-align: center; margin-bottom: 36px; border-bottom: 1px solid #e2e8f0; padding-bottom: 28px;">
                    <h1 style="font-size: 36px; font-weight: 400; letter-spacing: 4px; text-transform: uppercase; color: #0f172a; margin: 0 0 8px;">${e(f.full_name) || 'Your Name'}</h1>
                    <p style="font-size: 14px; letter-spacing: 2px; text-transform: uppercase; color: ${color}; margin: 0 0 16px;">${e(f.job_title) || ''}</p>
                    <div style="display: flex; justify-content: center; flex-wrap: wrap; gap: 16px; font-size: 12px; color: #94a3b8;">
                        ${f.email ? `<span>${e(f.email)}</span>` : ''}
                        ${f.phone ? `<span>${e(f.phone)}</span>` : ''}
                        ${(f.city || f.country) ? `<span>${[e(f.city), e(f.country)].filter(Boolean).join(', ')}</span>` : ''}
                    </div>
                </div>
                ${f.summary ? `<div style="margin-bottom: 28px; text-align: center;"><p style="font-size: 13px; color: #64748b; line-height: 1.8; font-style: italic; max-width: 600px; margin: 0 auto;">${e(f.summary)}</p></div>` : ''}
                ${f.experiences.length ? `<div style="margin-bottom: 28px;"><h2 style="font-size: 11px; letter-spacing: 3px; text-transform: uppercase; color: #94a3b8; margin: 0 0 16px; text-align: center;">Experience</h2>${f.experiences.map(exp => `<div style="display: grid; grid-template-columns: 120px 1fr; gap: 16px; margin-bottom: 16px;"><div style="text-align: right; font-size: 11px; color: #94a3b8; padding-top: 2px;">${e(exp.start_date)}<br>${exp.is_current ? 'Present' : e(exp.end_date)}</div><div><strong style="font-size: 14px;">${e(exp.position)}</strong>, <span style="color: ${color};">${e(exp.company)}</span>${exp.description ? `<p style="font-size: 12px; color: #64748b; margin: 6px 0 0; line-height: 1.6;">${e(exp.description)}</p>` : ''}</div></div>`).join('')}</div>` : ''}
                ${f.educations.length ? `<div style="margin-bottom: 28px;"><h2 style="font-size: 11px; letter-spacing: 3px; text-transform: uppercase; color: #94a3b8; margin: 0 0 16px; text-align: center;">Education</h2>${f.educations.map(edu => `<div style="display: grid; grid-template-columns: 120px 1fr; gap: 16px; margin-bottom: 12px;"><div style="text-align: right; font-size: 11px; color: #94a3b8;">${e(edu.start_date)}<br>${edu.is_current ? 'Present' : e(edu.end_date)}</div><div><strong>${e(edu.degree)}</strong> in ${e(edu.field_of_study)}<br><span style="color: ${color}; font-size: 13px;">${e(edu.institution)}</span></div></div>`).join('')}</div>` : ''}
                ${f.skills.length ? `<div><h2 style="font-size: 11px; letter-spacing: 3px; text-transform: uppercase; color: #94a3b8; margin: 0 0 16px; text-align: center;">Skills</h2><div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 8px;">${f.skills.map(s => `<span style="border: 1px solid ${color}; color: ${color}; padding: 3px 14px; border-radius: 20px; font-size: 12px;">${e(s.name)}</span>`).join('')}</div></div>` : ''}
            </div>`;
        },

        renderCreative(f, color) {
            const e = this.esc.bind(this);
            return `
            <div style="font-family: Arial, sans-serif; display: flex; min-height: 1123px;">
                <div style="width: 35%; background: linear-gradient(180deg, ${color} 0%, ${color}cc 100%); color: white; padding: 32px 24px;">
                    <div style="text-align: center; margin-bottom: 28px; padding-bottom: 24px; border-bottom: 1px solid rgba(255,255,255,0.2);">
                        <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 12px; display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 800;">${(f.full_name || 'Y').charAt(0).toUpperCase()}</div>
                        <h1 style="font-size: 18px; font-weight: 800; margin: 0 0 4px; line-height: 1.2;">${e(f.full_name) || 'Your Name'}</h1>
                        <p style="font-size: 12px; opacity: 0.85; margin: 0;">${e(f.job_title) || ''}</p>
                    </div>
                    <div style="margin-bottom: 24px;">
                        <h3 style="font-size: 10px; letter-spacing: 2px; text-transform: uppercase; opacity: 0.7; margin: 0 0 12px;">Contact</h3>
                        ${f.email ? `<p style="font-size: 11px; margin: 0 0 6px; word-break: break-all;">✉ ${e(f.email)}</p>` : ''}
                        ${f.phone ? `<p style="font-size: 11px; margin: 0 0 6px;">✆ ${e(f.phone)}</p>` : ''}
                        ${(f.city || f.country) ? `<p style="font-size: 11px; margin: 0 0 6px;">📍 ${[e(f.city), e(f.country)].filter(Boolean).join(', ')}</p>` : ''}
                        ${f.linkedin ? `<p style="font-size: 11px; margin: 0 0 6px; word-break: break-all;">🔗 ${e(f.linkedin)}</p>` : ''}
                        ${f.github ? `<p style="font-size: 11px; margin: 0; word-break: break-all;">⌥ ${e(f.github)}</p>` : ''}
                    </div>
                    ${f.skills.length ? `<div><h3 style="font-size: 10px; letter-spacing: 2px; text-transform: uppercase; opacity: 0.7; margin: 0 0 12px;">Skills</h3>${f.skills.map(s => `<div style="margin-bottom: 10px;"><div style="display: flex; justify-content: space-between; font-size: 11px; margin-bottom: 4px;"><span>${e(s.name)}</span><span style="opacity: 0.75;">${e(s.level)}</span></div><div style="background: rgba(255,255,255,0.2); border-radius: 3px; height: 3px;"><div style="background: white; height: 100%; border-radius: 3px; width: ${this.skillPercent(s.level)}%;"></div></div></div>`).join('')}</div>` : ''}
                    ${f.certifications.length ? `<div style="margin-top: 20px;"><h3 style="font-size: 10px; letter-spacing: 2px; text-transform: uppercase; opacity: 0.7; margin: 0 0 12px;">Certifications</h3>${f.certifications.map(c => `<div style="margin-bottom: 8px;"><p style="font-size: 11px; font-weight: 600; margin: 0 0 2px;">${e(c.name)}</p><p style="font-size: 10px; opacity: 0.75; margin: 0;">${e(c.issuer)}</p></div>`).join('')}</div>` : ''}
                </div>
                <div style="flex: 1; padding: 36px 32px; background: white;">
                    ${f.summary ? `<div style="margin-bottom: 24px;"><p style="font-size: 13px; color: #64748b; line-height: 1.7; border-left: 3px solid ${color}; padding-left: 12px;">${e(f.summary)}</p></div>` : ''}
                    ${f.experiences.length ? `<div style="margin-bottom: 24px;"><h2 style="font-size: 14px; font-weight: 800; color: ${color}; text-transform: uppercase; letter-spacing: 1px; margin: 0 0 14px; border-bottom: 2px solid ${color}20; padding-bottom: 6px;">Experience</h2>${f.experiences.map(exp => `<div style="margin-bottom: 14px;"><div style="display: flex; justify-content: space-between; margin-bottom: 2px;"><strong style="font-size: 13px;">${e(exp.position)}</strong><span style="font-size: 11px; color: #94a3b8;">${e(exp.start_date)} – ${exp.is_current ? 'Present' : e(exp.end_date)}</span></div><p style="color: ${color}; font-size: 12px; font-weight: 600; margin: 2px 0 4px;">${e(exp.company)}</p>${exp.description ? `<p style="font-size: 12px; color: #64748b; white-space: pre-line;">${e(exp.description)}</p>` : ''}</div>`).join('')}</div>` : ''}
                    ${f.educations.length ? `<div style="margin-bottom: 24px;"><h2 style="font-size: 14px; font-weight: 800; color: ${color}; text-transform: uppercase; letter-spacing: 1px; margin: 0 0 14px; border-bottom: 2px solid ${color}20; padding-bottom: 6px;">Education</h2>${f.educations.map(edu => `<div style="margin-bottom: 10px;"><div style="display: flex; justify-content: space-between;"><strong style="font-size: 13px;">${e(edu.degree)} in ${e(edu.field_of_study)}</strong><span style="font-size: 11px; color: #94a3b8;">${e(edu.start_date)} – ${edu.is_current ? 'Present' : e(edu.end_date)}</span></div><p style="color: ${color}; font-size: 12px; margin: 2px 0;">${e(edu.institution)}</p></div>`).join('')}</div>` : ''}
                    ${f.projects.length ? `<div><h2 style="font-size: 14px; font-weight: 800; color: ${color}; text-transform: uppercase; letter-spacing: 1px; margin: 0 0 14px; border-bottom: 2px solid ${color}20; padding-bottom: 6px;">Projects</h2>${f.projects.map(p => `<div style="margin-bottom: 10px;"><strong style="font-size: 13px;">${e(p.title)}</strong>${p.technologies ? `<span style="font-size: 11px; color: ${color}; margin-left: 8px;">${e(p.technologies)}</span>` : ''}${p.description ? `<p style="font-size: 12px; color: #64748b; margin: 4px 0 0;">${e(p.description)}</p>` : ''}</div>`).join('')}</div>` : ''}
                </div>
            </div>`;
        },

        renderExecutive(f, color) {
            const e = this.esc.bind(this);
            return `
            <div style="font-family: 'Georgia', serif; color: #1e293b;">
                <div style="background: #1e293b; padding: 40px; color: white;">
                    <h1 style="font-size: 34px; font-weight: 400; letter-spacing: 2px; text-transform: uppercase; margin: 0 0 8px;">${e(f.full_name) || 'Your Name'}</h1>
                    <div style="width: 48px; height: 3px; background: ${color}; margin-bottom: 10px;"></div>
                    <p style="font-size: 14px; letter-spacing: 1px; color: ${color}; font-weight: 400; margin: 0 0 20px;">${e(f.job_title) || ''}</p>
                    <div style="display: flex; flex-wrap: wrap; gap: 20px; font-size: 12px; color: rgba(255,255,255,0.7);">
                        ${f.email ? `<span>${e(f.email)}</span>` : ''}
                        ${f.phone ? `<span>${e(f.phone)}</span>` : ''}
                        ${(f.city || f.country) ? `<span>${[e(f.city), e(f.country)].filter(Boolean).join(', ')}</span>` : ''}
                        ${f.linkedin ? `<span>${e(f.linkedin)}</span>` : ''}
                    </div>
                </div>
                <div style="padding: 36px 40px;">
                    ${f.summary ? `<div style="margin-bottom: 28px; padding-bottom: 24px; border-bottom: 1px solid #e2e8f0;"><p style="font-size: 14px; color: #475569; line-height: 1.8; font-style: italic;">${e(f.summary)}</p></div>` : ''}
                    ${f.experiences.length ? `<div style="margin-bottom: 28px;"><h2 style="font-size: 11px; letter-spacing: 3px; text-transform: uppercase; color: ${color}; font-family: Arial; font-weight: 700; margin: 0 0 18px;">Professional Experience</h2>${f.experiences.map(exp => `<div style="margin-bottom: 18px; padding-left: 16px; border-left: 2px solid ${color}30;"><div style="display: flex; justify-content: space-between; align-items: baseline;"><div><strong style="font-size: 15px; font-weight: 700;">${e(exp.position)}</strong><p style="font-size: 13px; color: ${color}; margin: 2px 0; font-style: italic;">${e(exp.company)}${exp.location ? ` · ${e(exp.location)}` : ''}</p></div><span style="font-size: 12px; color: #94a3b8; white-space: nowrap;">${e(exp.start_date)} – ${exp.is_current ? 'Present' : e(exp.end_date)}</span></div>${exp.description ? `<p style="font-size: 13px; color: #475569; margin: 8px 0 0; line-height: 1.7; white-space: pre-line;">${e(exp.description)}</p>` : ''}</div>`).join('')}</div>` : ''}
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px;">
                        ${f.educations.length ? `<div><h2 style="font-size: 11px; letter-spacing: 3px; text-transform: uppercase; color: ${color}; font-family: Arial; font-weight: 700; margin: 0 0 14px;">Education</h2>${f.educations.map(edu => `<div style="margin-bottom: 10px;"><strong style="font-size: 13px;">${e(edu.degree)}</strong><p style="font-size: 12px; color: ${color}; margin: 2px 0; font-style: italic;">${e(edu.institution)}</p><span style="font-size: 11px; color: #94a3b8;">${e(edu.field_of_study)} · ${e(edu.start_date)} – ${edu.is_current ? 'Present' : e(edu.end_date)}</span></div>`).join('')}</div>` : ''}
                        ${f.skills.length ? `<div><h2 style="font-size: 11px; letter-spacing: 3px; text-transform: uppercase; color: ${color}; font-family: Arial; font-weight: 700; margin: 0 0 14px;">Core Competencies</h2><div style="display: flex; flex-wrap: wrap; gap: 6px;">${f.skills.map(s => `<span style="font-size: 12px; background: #f1f5f9; color: #334155; padding: 3px 10px; border-radius: 4px;">${e(s.name)}</span>`).join('')}</div></div>` : ''}
                    </div>
                    ${f.certifications.length ? `<div style="margin-top: 24px;"><h2 style="font-size: 11px; letter-spacing: 3px; text-transform: uppercase; color: ${color}; font-family: Arial; font-weight: 700; margin: 0 0 14px;">Certifications</h2>${f.certifications.map(c => `<div style="margin-bottom: 6px;"><strong style="font-size: 13px;">${e(c.name)}</strong> <span style="color: #64748b; font-size: 12px;">— ${e(c.issuer)}</span>${c.issue_date ? `<span style="font-size: 11px; color: #94a3b8; margin-left: 6px;">${e(c.issue_date)}</span>` : ''}</div>`).join('')}</div>` : ''}
                </div>
            </div>`;
        },
    };
}
</script>
@endpush
