@php
    $pi    = $resume->personalInfo;
    $color = $resume->accent_color ?? '#b45309';
@endphp

<div style="font-family: Georgia, 'Times New Roman', serif; color: #1e293b;">

    {{-- Dark Executive Header --}}
    <div style="background: #1e293b; padding: 44px 48px; color: white;">
        <h1 style="font-size: 36px; font-weight: 400; letter-spacing: 3px; text-transform: uppercase; color: white; margin: 0 0 10px; font-family: Arial, Helvetica, sans-serif;">{{ $pi?->full_name ?? 'Your Name' }}</h1>
        <div style="width: 56px; height: 3px; background: {{ $color }}; margin-bottom: 12px;"></div>
        @if($pi?->job_title)
        <p style="font-size: 14px; letter-spacing: 1.5px; color: {{ $color }}; font-family: Arial, sans-serif; font-weight: 600; margin: 0 0 22px; text-transform: uppercase;">{{ $pi->job_title }}</p>
        @endif
        <div style="display: flex; flex-wrap: wrap; gap: 24px; font-size: 12px; color: rgba(255,255,255,0.68); font-family: Arial, sans-serif;">
            @if($pi?->email) <span>{{ $pi->email }}</span> @endif
            @if($pi?->phone) <span>{{ $pi->phone }}</span> @endif
            @if($pi?->city || $pi?->country) <span>{{ collect([$pi?->city, $pi?->country])->filter()->join(', ') }}</span> @endif
            @if($pi?->linkedin) <span>{{ $pi->linkedin }}</span> @endif
            @if($pi?->website) <span>{{ $pi->website }}</span> @endif
        </div>
    </div>

    <div style="padding: 40px 48px;">
        {{-- Summary --}}
        @if($pi?->summary)
        <div style="margin-bottom: 32px; padding-bottom: 28px; border-bottom: 1px solid #e2e8f0;">
            <p style="font-size: 14px; color: #475569; line-height: 1.9; font-style: italic; margin: 0;">{{ $pi->summary }}</p>
        </div>
        @endif

        {{-- Experience --}}
        @if($resume->experiences->isNotEmpty())
        <div style="margin-bottom: 32px; padding-bottom: 28px; border-bottom: 1px solid #f1f5f9;">
            <h2 style="font-size: 10px; letter-spacing: 4px; text-transform: uppercase; color: {{ $color }}; font-family: Arial, sans-serif; font-weight: 700; margin: 0 0 22px;">Professional Experience</h2>
            @foreach($resume->experiences as $exp)
            <div style="margin-bottom: 22px; padding-left: 20px; border-left: 2px solid {{ $color }}40;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
                    <div>
                        <strong style="font-size: 16px; font-family: Arial, sans-serif; font-weight: 700; color: #0f172a;">{{ $exp->position }}</strong>
                        <p style="font-size: 13px; color: {{ $color }}; font-style: italic; margin: 4px 0 0;">{{ $exp->company }}{{ $exp->location ? ' · ' . $exp->location : '' }}</p>
                    </div>
                    <span style="font-size: 11.5px; color: #94a3b8; white-space: nowrap; margin-left: 16px; font-family: Arial, sans-serif;">{{ $exp->start_date }} – {{ $exp->is_current ? 'Present' : $exp->end_date }}</span>
                </div>
                @if($exp->description)
                <p style="font-size: 13px; color: #475569; margin: 10px 0 0; line-height: 1.75; white-space: pre-line;">{{ $exp->description }}</p>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        {{-- Two Column Section --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 36px; margin-bottom: 32px;">
            {{-- Education --}}
            @if($resume->educations->isNotEmpty())
            <div>
                <h2 style="font-size: 10px; letter-spacing: 4px; text-transform: uppercase; color: {{ $color }}; font-family: Arial, sans-serif; font-weight: 700; margin: 0 0 18px;">Education</h2>
                @foreach($resume->educations as $edu)
                <div style="margin-bottom: 14px;">
                    <strong style="font-size: 14px; font-family: Arial, sans-serif; color: #0f172a;">{{ $edu->degree }}</strong>
                    @if($edu->field_of_study) <p style="font-size: 13px; font-style: italic; color: #475569; margin: 2px 0;">{{ $edu->field_of_study }}</p> @endif
                    <p style="font-size: 13px; color: {{ $color }}; font-style: italic; margin: 2px 0;">{{ $edu->institution }}</p>
                    <div style="font-size: 11px; color: #94a3b8; font-family: Arial, sans-serif;">{{ $edu->start_date }} – {{ $edu->is_current ? 'Present' : $edu->end_date }}{{ $edu->gpa ? ' · GPA: ' . $edu->gpa : '' }}</div>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Skills --}}
            @if($resume->skills->isNotEmpty())
            <div>
                <h2 style="font-size: 10px; letter-spacing: 4px; text-transform: uppercase; color: {{ $color }}; font-family: Arial, sans-serif; font-weight: 700; margin: 0 0 18px;">Core Competencies</h2>
                <div style="display: flex; flex-wrap: wrap; gap: 7px;">
                    @foreach($resume->skills as $skill)
                    <span style="font-size: 12px; background: #f1f5f9; color: #334155; padding: 4px 12px; border-radius: 4px; font-family: Arial, sans-serif;">{{ $skill->name }}</span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Projects --}}
        @if($resume->projects->isNotEmpty())
        <div style="margin-bottom: 28px; padding-bottom: 24px; border-bottom: 1px solid #f1f5f9;">
            <h2 style="font-size: 10px; letter-spacing: 4px; text-transform: uppercase; color: {{ $color }}; font-family: Arial, sans-serif; font-weight: 700; margin: 0 0 18px;">Notable Projects</h2>
            @foreach($resume->projects as $project)
            <div style="margin-bottom: 14px;">
                <strong style="font-size: 14px; font-family: Arial, sans-serif;">{{ $project->title }}</strong>
                @if($project->technologies) <span style="font-size: 12px; color: #64748b; font-family: Arial, sans-serif; margin-left: 8px;">[{{ $project->technologies }}]</span> @endif
                @if($project->description) <p style="font-size: 13px; color: #475569; margin: 6px 0 0; line-height: 1.7;">{{ $project->description }}</p> @endif
            </div>
            @endforeach
        </div>
        @endif

        {{-- Certifications --}}
        @if($resume->certifications->isNotEmpty())
        <div>
            <h2 style="font-size: 10px; letter-spacing: 4px; text-transform: uppercase; color: {{ $color }}; font-family: Arial, sans-serif; font-weight: 700; margin: 0 0 16px;">Certifications & Awards</h2>
            @foreach($resume->certifications as $cert)
            <div style="margin-bottom: 10px; display: flex; justify-content: space-between; align-items: baseline;">
                <div>
                    <strong style="font-size: 13px; font-family: Arial, sans-serif;">{{ $cert->name }}</strong>
                    @if($cert->issuer) <span style="color: #64748b; font-size: 12px; font-family: Arial, sans-serif;"> — {{ $cert->issuer }}</span> @endif
                </div>
                @if($cert->issue_date) <span style="font-size: 11px; color: #94a3b8; font-family: Arial, sans-serif; white-space: nowrap; margin-left: 12px;">{{ $cert->issue_date }}</span> @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
