@php
    $pi    = $resume->personalInfo;
    $color = $resume->accent_color ?? '#2563eb';
@endphp

<div style="font-family: Georgia, 'Times New Roman', serif; padding: 56px 52px; color: #1e293b; line-height: 1.6; max-width: 100%;">

    {{-- Centered Header --}}
    <div style="text-align: center; margin-bottom: 40px; padding-bottom: 32px; border-bottom: 1px solid #e2e8f0;">
        <h1 style="font-size: 38px; font-weight: 400; letter-spacing: 5px; text-transform: uppercase; color: #0f172a; margin: 0 0 10px; font-family: Arial, sans-serif;">{{ $pi?->full_name ?? 'Your Name' }}</h1>
        @if($pi?->job_title)
        <p style="font-size: 13px; letter-spacing: 3px; text-transform: uppercase; color: {{ $color }}; font-family: Arial, sans-serif; margin: 0 0 18px; font-weight: 600;">{{ $pi->job_title }}</p>
        @endif
        <div style="display: flex; justify-content: center; flex-wrap: wrap; gap: 20px; font-size: 12px; color: #94a3b8; font-family: Arial, sans-serif;">
            @if($pi?->email) <span>{{ $pi->email }}</span> @endif
            @if($pi?->phone) <span>{{ $pi->phone }}</span> @endif
            @if($pi?->city || $pi?->country) <span>{{ collect([$pi?->city, $pi?->country])->filter()->join(', ') }}</span> @endif
            @if($pi?->linkedin) <span>{{ $pi->linkedin }}</span> @endif
            @if($pi?->website) <span>{{ $pi->website }}</span> @endif
        </div>
    </div>

    {{-- Summary --}}
    @if($pi?->summary)
    <div style="margin-bottom: 32px; text-align: center;">
        <p style="font-size: 13.5px; color: #64748b; font-style: italic; line-height: 1.9; max-width: 580px; margin: 0 auto;">{{ $pi->summary }}</p>
    </div>
    @endif

    {{-- Experience --}}
    @if($resume->experiences->isNotEmpty())
    <div style="margin-bottom: 32px;">
        <h2 style="font-size: 10px; letter-spacing: 4px; text-transform: uppercase; color: #94a3b8; font-family: Arial, sans-serif; font-weight: 600; text-align: center; margin: 0 0 22px;">Experience</h2>
        @foreach($resume->experiences as $exp)
        <div style="display: grid; grid-template-columns: 130px 1fr; gap: 20px; margin-bottom: 20px;">
            <div style="text-align: right; font-size: 11px; color: #94a3b8; font-family: Arial, sans-serif; padding-top: 2px; line-height: 1.6;">
                {{ $exp->start_date }}<br>{{ $exp->is_current ? 'Present' : $exp->end_date }}
                @if($exp->location) <br><em>{{ $exp->location }}</em> @endif
            </div>
            <div>
                <strong style="font-size: 14px; font-family: Arial, sans-serif;">{{ $exp->position }}</strong>,
                <span style="color: {{ $color }}; font-family: Arial, sans-serif; font-size: 14px;">{{ $exp->company }}</span>
                @if($exp->description)
                <p style="font-size: 12.5px; color: #64748b; margin: 8px 0 0; line-height: 1.7; white-space: pre-line;">{{ $exp->description }}</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Education --}}
    @if($resume->educations->isNotEmpty())
    <div style="margin-bottom: 32px;">
        <h2 style="font-size: 10px; letter-spacing: 4px; text-transform: uppercase; color: #94a3b8; font-family: Arial, sans-serif; font-weight: 600; text-align: center; margin: 0 0 22px;">Education</h2>
        @foreach($resume->educations as $edu)
        <div style="display: grid; grid-template-columns: 130px 1fr; gap: 20px; margin-bottom: 16px;">
            <div style="text-align: right; font-size: 11px; color: #94a3b8; font-family: Arial, sans-serif; padding-top: 2px; line-height: 1.6;">
                {{ $edu->start_date }}<br>{{ $edu->is_current ? 'Present' : $edu->end_date }}
            </div>
            <div>
                <strong style="font-size: 14px; font-family: Arial, sans-serif;">{{ $edu->degree }}@if($edu->field_of_study) in {{ $edu->field_of_study }}@endif</strong>
                <br>
                <span style="color: {{ $color }}; font-family: Arial, sans-serif; font-size: 13px;">{{ $edu->institution }}</span>
                @if($edu->gpa) <span style="font-size: 12px; color: #64748b; font-family: Arial, sans-serif;"> · GPA: {{ $edu->gpa }}</span> @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Skills --}}
    @if($resume->skills->isNotEmpty())
    <div style="margin-bottom: 32px;">
        <h2 style="font-size: 10px; letter-spacing: 4px; text-transform: uppercase; color: #94a3b8; font-family: Arial, sans-serif; font-weight: 600; text-align: center; margin: 0 0 18px;">Skills</h2>
        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 10px;">
            @foreach($resume->skills as $skill)
            <span style="border: 1px solid {{ $color }}; color: {{ $color }}; padding: 4px 16px; border-radius: 24px; font-size: 12px; font-family: Arial, sans-serif;">{{ $skill->name }}</span>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Projects --}}
    @if($resume->projects->isNotEmpty())
    <div style="margin-bottom: 32px;">
        <h2 style="font-size: 10px; letter-spacing: 4px; text-transform: uppercase; color: #94a3b8; font-family: Arial, sans-serif; font-weight: 600; text-align: center; margin: 0 0 22px;">Projects</h2>
        @foreach($resume->projects as $project)
        <div style="display: grid; grid-template-columns: 130px 1fr; gap: 20px; margin-bottom: 14px;">
            <div style="text-align: right; font-size: 11px; color: #94a3b8; font-family: Arial, sans-serif; padding-top: 2px;">
                {{ $project->start_date }}
                @if($project->end_date) <br>{{ $project->end_date }} @endif
            </div>
            <div>
                <strong style="font-size: 13px; font-family: Arial, sans-serif;">{{ $project->title }}</strong>
                @if($project->technologies) <span style="font-size: 11px; color: #64748b; font-family: Arial, sans-serif;"> [{{ $project->technologies }}]</span> @endif
                @if($project->description) <p style="font-size: 12.5px; color: #64748b; margin: 4px 0 0;">{{ $project->description }}</p> @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Certifications --}}
    @if($resume->certifications->isNotEmpty())
    <div>
        <h2 style="font-size: 10px; letter-spacing: 4px; text-transform: uppercase; color: #94a3b8; font-family: Arial, sans-serif; font-weight: 600; text-align: center; margin: 0 0 18px;">Certifications</h2>
        @foreach($resume->certifications as $cert)
        <div style="text-align: center; margin-bottom: 8px;">
            <strong style="font-size: 13px; font-family: Arial, sans-serif;">{{ $cert->name }}</strong>
            @if($cert->issuer) <span style="color: #64748b; font-size: 12px; font-family: Arial, sans-serif;"> — {{ $cert->issuer }}</span> @endif
            @if($cert->issue_date) <span style="color: #94a3b8; font-size: 11px; font-family: Arial, sans-serif;"> · {{ $cert->issue_date }}</span> @endif
        </div>
        @endforeach
    </div>
    @endif
</div>
