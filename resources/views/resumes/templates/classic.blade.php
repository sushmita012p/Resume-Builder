@php
    $pi    = $resume->personalInfo;
    $color = $resume->accent_color ?? '#2563eb';
@endphp

<div style="font-family: 'DejaVu Sans', Arial, sans-serif; padding: 44px; color: #1e293b; line-height: 1.55;">

    {{-- Header --}}
    <div style="border-bottom: 3px solid {{ $color }}; padding-bottom: 20px; margin-bottom: 24px;">
        <h1 style="font-size: 30px; font-weight: 800; color: #0f172a; margin: 0 0 5px;">{{ $pi?->full_name ?? 'Your Name' }}</h1>
        @if($pi?->job_title)
        <p style="font-size: 16px; color: {{ $color }}; font-weight: 600; margin: 0 0 10px;">{{ $pi->job_title }}</p>
        @endif
        <div style="display: flex; flex-wrap: wrap; gap: 18px; font-size: 12px; color: #64748b;">
            @if($pi?->email) <span>✉ {{ $pi->email }}</span> @endif
            @if($pi?->phone) <span>✆ {{ $pi->phone }}</span> @endif
            @if($pi?->city || $pi?->country) <span>📍 {{ collect([$pi?->city, $pi?->country])->filter()->join(', ') }}</span> @endif
            @if($pi?->linkedin) <span>in {{ $pi->linkedin }}</span> @endif
            @if($pi?->github) <span>⌥ {{ $pi->github }}</span> @endif
            @if($pi?->website) <span>🌐 {{ $pi->website }}</span> @endif
        </div>
    </div>

    {{-- Summary --}}
    @if($pi?->summary)
    <div style="margin-bottom: 22px;">
        <h2 style="font-size: 12px; font-weight: 700; color: {{ $color }}; text-transform: uppercase; letter-spacing: 1.5px; margin: 0 0 8px; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px;">Summary</h2>
        <p style="font-size: 13px; color: #475569; line-height: 1.7;">{{ $pi->summary }}</p>
    </div>
    @endif

    {{-- Experience --}}
    @if($resume->experiences->isNotEmpty())
    <div style="margin-bottom: 22px;">
        <h2 style="font-size: 12px; font-weight: 700; color: {{ $color }}; text-transform: uppercase; letter-spacing: 1.5px; margin: 0 0 12px; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px;">Work Experience</h2>
        @foreach($resume->experiences as $exp)
        <div style="margin-bottom: 16px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <strong style="font-size: 14px; color: #0f172a;">{{ $exp->position }}</strong>
                    <span style="color: #64748b; font-size: 13px;"> at </span>
                    <span style="color: {{ $color }}; font-weight: 600; font-size: 13px;">{{ $exp->company }}</span>
                    @if($exp->location) <span style="color: #94a3b8; font-size: 12px;"> · {{ $exp->location }}</span> @endif
                </div>
                <span style="font-size: 12px; color: #94a3b8; white-space: nowrap;">
                    {{ $exp->start_date }} – {{ $exp->is_current ? 'Present' : $exp->end_date }}
                </span>
            </div>
            @if($exp->description)
            <p style="font-size: 12.5px; color: #475569; margin: 6px 0 0; white-space: pre-line;">{{ $exp->description }}</p>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    {{-- Education --}}
    @if($resume->educations->isNotEmpty())
    <div style="margin-bottom: 22px;">
        <h2 style="font-size: 12px; font-weight: 700; color: {{ $color }}; text-transform: uppercase; letter-spacing: 1.5px; margin: 0 0 12px; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px;">Education</h2>
        @foreach($resume->educations as $edu)
        <div style="margin-bottom: 12px; display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <strong style="font-size: 14px;">{{ $edu->degree }}@if($edu->field_of_study) in {{ $edu->field_of_study }}@endif</strong>
                <br>
                <span style="color: {{ $color }}; font-size: 13px;">{{ $edu->institution }}</span>
                @if($edu->gpa) <span style="color: #64748b; font-size: 12px;"> · GPA: {{ $edu->gpa }}</span> @endif
            </div>
            <span style="font-size: 12px; color: #94a3b8;">{{ $edu->start_date }} – {{ $edu->is_current ? 'Present' : $edu->end_date }}</span>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Skills --}}
    @if($resume->skills->isNotEmpty())
    <div style="margin-bottom: 22px;">
        <h2 style="font-size: 12px; font-weight: 700; color: {{ $color }}; text-transform: uppercase; letter-spacing: 1.5px; margin: 0 0 12px; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px;">Skills</h2>
        <div style="display: flex; flex-wrap: wrap; gap: 8px;">
            @foreach($resume->skills as $skill)
            <span style="background: {{ $color }}18; color: {{ $color }}; padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: 500;">{{ $skill->name }}</span>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Projects --}}
    @if($resume->projects->isNotEmpty())
    <div style="margin-bottom: 22px;">
        <h2 style="font-size: 12px; font-weight: 700; color: {{ $color }}; text-transform: uppercase; letter-spacing: 1.5px; margin: 0 0 12px; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px;">Projects</h2>
        @foreach($resume->projects as $project)
        <div style="margin-bottom: 12px;">
            <strong style="font-size: 14px;">{{ $project->title }}</strong>
            @if($project->technologies) <span style="font-size: 12px; color: #64748b; margin-left: 6px;">[{{ $project->technologies }}]</span> @endif
            @if($project->url) <a href="{{ $project->url }}" style="font-size: 12px; color: {{ $color }}; margin-left: 6px;">🔗 Link</a> @endif
            @if($project->description) <p style="font-size: 12.5px; color: #475569; margin: 4px 0 0;">{{ $project->description }}</p> @endif
        </div>
        @endforeach
    </div>
    @endif

    {{-- Certifications --}}
    @if($resume->certifications->isNotEmpty())
    <div>
        <h2 style="font-size: 12px; font-weight: 700; color: {{ $color }}; text-transform: uppercase; letter-spacing: 1.5px; margin: 0 0 12px; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px;">Certifications</h2>
        @foreach($resume->certifications as $cert)
        <div style="margin-bottom: 8px; display: flex; justify-content: space-between;">
            <div>
                <strong style="font-size: 13px;">{{ $cert->name }}</strong>
                @if($cert->issuer) <span style="color: #64748b; font-size: 12px;"> – {{ $cert->issuer }}</span> @endif
                @if($cert->credential_id) <span style="color: #94a3b8; font-size: 11px;"> · ID: {{ $cert->credential_id }}</span> @endif
            </div>
            @if($cert->issue_date) <span style="font-size: 11px; color: #94a3b8;">{{ $cert->issue_date }}</span> @endif
        </div>
        @endforeach
    </div>
    @endif
</div>
