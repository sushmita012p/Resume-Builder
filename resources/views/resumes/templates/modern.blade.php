@php
    $pi    = $resume->personalInfo;
    $color = $resume->accent_color ?? '#2563eb';
@endphp

<div style="font-family: Arial, Helvetica, sans-serif; color: #1e293b;">

    {{-- Hero Header --}}
    <div style="background: linear-gradient(135deg, {{ $color }}, {{ $color }}bb); padding: 40px 44px; color: white;">
        <h1 style="font-size: 34px; font-weight: 900; margin: 0 0 6px; letter-spacing: -0.5px;">{{ $pi?->full_name ?? 'Your Name' }}</h1>
        @if($pi?->job_title)
        <p style="font-size: 16px; opacity: 0.9; margin: 0 0 18px; font-weight: 500;">{{ $pi->job_title }}</p>
        @endif
        <div style="display: flex; flex-wrap: wrap; gap: 18px; font-size: 12px; opacity: 0.88;">
            @if($pi?->email) <span>✉ {{ $pi->email }}</span> @endif
            @if($pi?->phone) <span>✆ {{ $pi->phone }}</span> @endif
            @if($pi?->city || $pi?->country) <span>📍 {{ collect([$pi?->city, $pi?->country])->filter()->join(', ') }}</span> @endif
            @if($pi?->linkedin) <span>🔗 {{ $pi->linkedin }}</span> @endif
            @if($pi?->github) <span>⌥ {{ $pi->github }}</span> @endif
        </div>
    </div>

    <div style="padding: 36px 44px;">
        {{-- Summary --}}
        @if($pi?->summary)
        <div style="background: {{ $color }}0d; border-left: 4px solid {{ $color }}; padding: 16px 20px; border-radius: 0 10px 10px 0; margin-bottom: 28px;">
            <p style="font-size: 13px; color: #475569; margin: 0; line-height: 1.7;">{{ $pi->summary }}</p>
        </div>
        @endif

        {{-- Experience --}}
        @if($resume->experiences->isNotEmpty())
        <div style="margin-bottom: 28px;">
            <h2 style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 0 0 18px; border-bottom: 2px solid {{ $color }}; padding-bottom: 8px;">Work Experience</h2>
            @foreach($resume->experiences as $exp)
            <div style="margin-bottom: 18px; padding-left: 20px; border-left: 3px solid {{ $color }}30; position: relative;">
                <div style="position: absolute; left: -6px; top: 5px; width: 9px; height: 9px; border-radius: 50%; background: {{ $color }};"></div>
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 4px;">
                    <div>
                        <strong style="font-size: 15px; color: #0f172a;">{{ $exp->position }}</strong>
                        <p style="font-size: 13px; color: {{ $color }}; font-weight: 600; margin: 3px 0 0;">{{ $exp->company }}{{ $exp->location ? ' · ' . $exp->location : '' }}</p>
                    </div>
                    <span style="font-size: 11px; background: {{ $color }}18; color: {{ $color }}; padding: 3px 10px; border-radius: 14px; white-space: nowrap;">
                        {{ $exp->start_date }} – {{ $exp->is_current ? 'Present' : $exp->end_date }}
                    </span>
                </div>
                @if($exp->description)
                <p style="font-size: 12.5px; color: #475569; margin: 8px 0 0; white-space: pre-line; line-height: 1.6;">{{ $exp->description }}</p>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        {{-- Education --}}
        @if($resume->educations->isNotEmpty())
        <div style="margin-bottom: 28px;">
            <h2 style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 0 0 18px; border-bottom: 2px solid {{ $color }}; padding-bottom: 8px;">Education</h2>
            @foreach($resume->educations as $edu)
            <div style="margin-bottom: 14px; padding-left: 20px; border-left: 3px solid {{ $color }}30; position: relative;">
                <div style="position: absolute; left: -6px; top: 5px; width: 9px; height: 9px; border-radius: 50%; background: {{ $color }};"></div>
                <div style="display: flex; justify-content: space-between;">
                    <div>
                        <strong style="font-size: 14px;">{{ $edu->degree }}@if($edu->field_of_study) in {{ $edu->field_of_study }}@endif</strong>
                        <p style="color: {{ $color }}; font-size: 13px; margin: 3px 0;">{{ $edu->institution }}</p>
                        @if($edu->gpa) <span style="font-size: 12px; color: #64748b;">GPA: {{ $edu->gpa }}</span> @endif
                    </div>
                    <span style="font-size: 11px; color: #94a3b8; white-space: nowrap;">{{ $edu->start_date }} – {{ $edu->is_current ? 'Present' : $edu->end_date }}</span>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Skills with Progress Bars --}}
        @if($resume->skills->isNotEmpty())
        <div style="margin-bottom: 28px;">
            <h2 style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 0 0 18px; border-bottom: 2px solid {{ $color }}; padding-bottom: 8px;">Skills</h2>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                @foreach($resume->skills as $skill)
                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 4px;">
                        <span style="font-weight: 600;">{{ $skill->name }}</span>
                        <span style="color: #94a3b8; text-transform: capitalize;">{{ $skill->level }}</span>
                    </div>
                    <div style="background: #e2e8f0; border-radius: 4px; height: 5px;">
                        <div style="background: {{ $color }}; height: 100%; border-radius: 4px; width: {{ $skill->levelPercent() }}%;"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Projects --}}
        @if($resume->projects->isNotEmpty())
        <div style="margin-bottom: 28px;">
            <h2 style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 0 0 18px; border-bottom: 2px solid {{ $color }}; padding-bottom: 8px;">Projects</h2>
            @foreach($resume->projects as $project)
            <div style="margin-bottom: 14px; padding: 12px 16px; background: #f8fafc; border-radius: 8px; border-left: 3px solid {{ $color }};">
                <strong style="font-size: 14px;">{{ $project->title }}</strong>
                @if($project->technologies) <span style="font-size: 11px; background: {{ $color }}18; color: {{ $color }}; padding: 1px 8px; border-radius: 10px; margin-left: 8px;">{{ $project->technologies }}</span> @endif
                @if($project->description) <p style="font-size: 12.5px; color: #475569; margin: 6px 0 0;">{{ $project->description }}</p> @endif
            </div>
            @endforeach
        </div>
        @endif

        {{-- Certifications --}}
        @if($resume->certifications->isNotEmpty())
        <div>
            <h2 style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 0 0 18px; border-bottom: 2px solid {{ $color }}; padding-bottom: 8px;">Certifications</h2>
            @foreach($resume->certifications as $cert)
            <div style="margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <strong style="font-size: 13px;">{{ $cert->name }}</strong>
                    @if($cert->issuer) <span style="color: #64748b; font-size: 12px;"> — {{ $cert->issuer }}</span> @endif
                </div>
                @if($cert->issue_date) <span style="font-size: 11px; color: #94a3b8;">{{ $cert->issue_date }}</span> @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
