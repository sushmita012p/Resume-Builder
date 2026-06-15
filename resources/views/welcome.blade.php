<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ResumeForge – Build Your Professional Resume</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">

    {{-- Navbar --}}
    <nav class="fixed w-full top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <span class="font-bold text-xl text-slate-800">ResumeForge</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 px-4 py-2 rounded-lg hover:bg-slate-100 transition">Sign In</a>
                <a href="{{ route('register') }}" class="text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-2.5 rounded-xl hover:opacity-90 transition shadow-md shadow-blue-200">Get Started Free</a>
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 flex items-center pt-20">
        <div class="max-w-7xl mx-auto px-6 py-24 text-center">
            <div class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-4 py-1.5 rounded-full text-sm font-medium mb-8">
                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                Professional Resume Builder
            </div>
            <h1 class="text-5xl md:text-7xl font-black text-slate-900 mb-6 leading-tight">
                Build Your Dream<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Resume in Minutes</span>
            </h1>
            <p class="text-xl text-slate-500 max-w-2xl mx-auto mb-10">
                Choose from 5 professional templates, fill in your details with our live editor, and download a perfectly formatted PDF resume.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-16">
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold px-8 py-4 rounded-xl hover:opacity-90 transition shadow-lg shadow-blue-200 text-lg">
                    Create Your Resume Free
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-white text-slate-700 font-semibold px-8 py-4 rounded-xl hover:bg-slate-50 transition border border-slate-200 text-lg">
                    Sign In
                </a>
            </div>

            {{-- Features --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                @foreach([
                    ['icon' => 'M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z', 'title' => '5 Pro Templates', 'desc' => 'Classic, Modern, Minimal, Creative & Executive designs'],
                    ['icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z', 'title' => 'Live Preview', 'desc' => 'See your resume update in real-time as you type'],
                    ['icon' => 'M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'title' => 'PDF Export', 'desc' => 'Download a print-ready A4 PDF instantly'],
                ] as $feature)
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 text-left">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feature['icon'] }}"/></svg>
                    </div>
                    <h3 class="font-bold text-slate-800 mb-1">{{ $feature['title'] }}</h3>
                    <p class="text-sm text-slate-500">{{ $feature['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

</body>
</html>
