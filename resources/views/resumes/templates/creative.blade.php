@php
    $pi    = $resume->personalInfo;
    $color = $resume->accent_color ?? '#7c3aed';
    $initial = strtoupper(substr($pi?->full_name ?? 'Y', 0, 1));
@endphp

<div style="font-family: Arial, Helvetica, sans-serif; display: flex; min-height: 1123px; color: #1e293b;">

    {{-- Left Sidebar --}}
    <div style="width: 280px; min-width: 280px; background: linear-gradient(180deg, {{ $color }} 0%, {{ $color }}cc 100%); color: white; padding: 36px 24px;">

        {{-- Avatar + Name --}}
        <div style="text-align: center; margin-bottom: 28px; padding-bottom: 24px; border-bottom: 1px solid rgba(255,255,255,0.2);">
            <div style="width: 90px; height: 90px; background: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 14px; display: flex; align-items: center; justify-content: center; font-size: 36px; font-weight: 800; border: 3px solid rgba(255,255,255,0.4);">{{ $initial }}</div>
            <h1 style="font-size: 18px; font-weight: 800; margin: 0 0 5px; line-height: 1.3;">{{ $pi?->full_name ?? 'Your Name' }}</h1>
            @if($pi?->job_title)
            <p style="font-size: 11.5px; opacity: 0.85; margin: 0; letter-spacing: 0.5px;">{{ $pi->job_title }}</p>
            @endif
        </div>

        {{-- Contact --}}
        <div style="margin-bottom: 24px;">
            <h3 style="font-size: 9px; letter-spacing: 2.5px; text-transform: uppercase; opacity: 0.65; margin: 0 0 12px; font-weight: 700;">Contact</h3>
            @if($pi?->email)
            <div style="display: flex; align-items: flex-start; gap: 8px; margin-bottom: 8px;">
                <span style="opacity: 0.75; font-size: 11px; flex-shrink: 0; margin-top: 1px;">✉</span>
                <p style="font-size: 11px; margin: 0; word-break: break-all; opacity: 0.9;">{{ $pi->email }}</p>
            </div>
            @endif
            @if($pi?->phone)
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                <span style="opacity: 0.75; font-size: 11px; flex-shrink: 0;">✆</span>
                <p style="font-size: 11px; margin: 0; opacity: 0.9;">{{ $pi->phone }}</p>
            </div>
            @endif
            @if($pi?->city || $pi?->country)
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                <span style="opacity: 0.75; font-size: 11px; flex-shrink: 0;">📍</span>
                <p style="font-size: 11px; margin: 0; opacity: 0.9;">{{ collect([$pi?->city, $pi?->country])->filter()->join(', ') }}</p>
            </div>
            @endif
            @if($pi?->linkedin)
            <div style="display: flex; align-items: flex-start; gap: 8px; margin-bottom: 8px;">
                <span style="opacity: 0.75; font-size: 11px; flex-shrink: 0; margin-top: 1px;">in</span>
                <p style="font-size: 11px; margin: 0; word-break: break-all; opacity: 0.9;">{{ $pi->linkedin }}</p>
            </div>
            @endif
            @if($pi?->github)
            <div style="display: flex; align-items: flex-start; gap: 8px;">
                <span style="opacity: 0.75; font-size: 11px; flex-shrink: 0; margin-top: 1px;">⌥</span>
                <p style="font-size: 11px; margin: 0; word-break: break-all; opacity: 0.9;">{{ $pi->github }}</p>
            </div>
            @endif
        </div>

        {{-- Skills --}}
        @if($resume->skills->isNotEmpty())
        <div style="margin-bottom: 24px;">
            <h3 style="font-size: 9px; letter-spacing: 2.5px; text-transform: uppercase; opacity: 0.65; margin: 0 0 14px; font-weight: 700;">Skills</h3>
            @foreach($resume->skills as $skill)
            <div style="margin-bottom: 11px;">
                <div style="display: flex; justify-content: space-between; font-size: 11px; margin-bottom: 4px;">
                    <span style="font-weight: 500;">{{ $skill->name }}</span>
                    <span style="opacity: 0.65; text-transform: capitalize; font-size: 10px;">{{ $skill->level }}</span>
                </div>
                <div style="background: rgba(255,255,255,0.2); border-radius: 3px; height: 3px;">
                    <div style="background: rgba(255,255,255,0.9); height: 100%; border-radius: 3px; width: {{ $skill->levelPercent() }}%;"></div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Certifications --}}
        @if($resume->certifications->isNotEmpty())
        <div>
            <h3 style="font-size: 9px; letter-spacing: 2.5px; text-transform: uppercase; opacity: 0.65; margin: 0 0 14px; font-weight: 700;">Certifications</h3>
            @foreach($resume->certifications as $cert)
            <div style="margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid rgba(255,255,255,0.1);">
                <p style="font-size: 11px; font-weight: 600; margin: 0 0 2px;">{{ $cert->name }}</p>
                @if($cert->issuer) <p style="font-size: 10px; opacity: 0.7; margin: 0;">{{ $cert->issuer }}</p> @endif
                @if($cert->issue_date) <p style="font-size: 10px; opacity: 0.55; margin: 2px 0 0;">{{ $cert->issue_date }}</p> @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Right Main Content --}}
    <div style="flex: 1; padding: 40px 36px; background: white;">

        {{-- Summary --}}
        @if($pi?->summary)
        <div style="margin-bottom: 28px; padding-bottom: 24px; border-bottom: 2px solid #f1f5f9;">
            <p style="font-size: 13px; color: #64748b; line-height: 1.8; border-left: 3px solid {{ $color }}; padding-left: 14px; margin: 0;">{{ $pi->summary }}</p>
        </div>
        @endif

        {{-- Experience --}}
        @if($resume->experiences->isNotEmpty())
        <div style="margin-bottom: 26px;">
            <h2 style="font-size: 13px; font-weight: 800; color: {{ $color }}; text-transform: uppercase; letter-spacing: 2px; margin: 0 0 16px; border-bottom: 2px solid {{ $color }}20; padding-bottom: 6px;">Experience</h2>
            @foreach($resume->experiences as $exp)
            <div style="margin-bottom: 16px; padding-left: 14px; border-left: 2px solid {{ $color }}30;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 3px;">
                    <strong style="font-size: 14px; color: #0f172a;">{{ $exp->position }}</strong>
                    <span style="font-size: 11px; color: #94a3b8; white-space: nowrap; margin-left: 8px;">{{ $exp->start_date }} – {{ $exp->is_current ? 'Present' : $exp->end_date }}</span>
                </div>
                <p style="font-size: 12.5px; color: {{ $color }}; font-weight: 600; margin: 0 0 6px;">{{ $exp->company }}{{ $exp->location ? ' · ' . $exp->location : '' }}</p>
                @if($exp->description)
                <p style="font-size: 12px; color: #64748b; margin: 0; white-space: pre-line; line-height: 1.65;">{{ $exp->description }}</p>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        {{-- Education --}}
        @if($resume->educations->isNotEmpty())
        <div style="margin-bottom: 26px;">
            <h2 style="font-size: 13px; font-weight: 800; color: {{ $color }}; text-transform: uppercase; letter-spacing: 2px; margin: 0 0 16px; border-bottom: 2px solid {{ $color }}20; padding-bottom: 6px;">Education</h2>
            @foreach($resume->educations as $edu)
            <div style="margin-bottom: 14px; padding-left: 14px; border-left: 2px solid {{ $color }}30;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <strong style="font-size: 14px;">{{ $edu->degree }}@if($edu->field_of_study) in {{ $edu->field_of_study }}@endif</strong>
                        <p style="color: {{ $color }}; font-size: 12.5px; margin: 3px 0 0;">{{ $edu->institution }}</p>
                        @if($edu->gpa) <span style="font-size: 11px; color: #64748b;">GPA: {{ $edu->gpa }}</span> @endif
                    </div>
                    <span style="font-size: 11px; color: #94a3b8; white-space: nowrap; margin-left: 8px;">{{ $edu->start_date }} – {{ $edu->is_current ? 'Present' : $edu->end_date }}</span>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Projects --}}
        @if($resume->projects->isNotEmpty())
        <div>
            <h2 style="font-size: 13px; font-weight: 800; color: {{ $color }}; text-transform: uppercase; letter-spacing: 2px; margin: 0 0 16px; border-bottom: 2px solid {{ $color }}20; padding-bottom: 6px;">Projects</h2>
            @foreach($resume->projects as $project)
            <div style="margin-bottom: 14px; padding: 12px 14px; background: #f8fafc; border-radius: 8px;">
                <strong style="font-size: 13px;">{{ $project->title }}</strong>
                @if($project->technologies) <span style="font-size: 11px; color: {{ $color }}; background: {{ $color }}15; padding: 1px 8px; border-radius: 10px; margin-left: 8px;">{{ $project->technologies }}</span> @endif
                @if($project->description) <p style="font-size: 12px; color: #64748b; margin: 6px 0 0;">{{ $project->description }}</p> @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
