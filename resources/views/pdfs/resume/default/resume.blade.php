<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resume PDF</title>
    @include('pdfs.resume.default.style')
    <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>

    <div id="resumePrintDive">

        <!-- HEADER SECTION TABLE -->
        <table width="100%" style="margin-bottom: 15px;">
            <tr>
                <!-- Name & Desired Job Title -->
                <td width="60%" style="vertical-align: middle;">
                    <h1 class="resume-name">{{ $cv->contact->first_name . ' ' . $cv->contact->last_name }}</h1>
                    <p class="resume-subtitle">{{ $cv->contact->desired_job_title }}</p>
                </td>

                <!-- Contact Details -->
                <td width="40%" class="contact-text" style="vertical-align: middle;">
                    @if (!empty($cv->contact->email))
                        <div>{{ $cv->contact->email }} <i class="fa-solid fa-envelope"></i></div>
                    @endif
                    @if (!empty($cv->contact->phone))
                        <div>{{ $cv->contact->phone }} <i class="fa-solid fa-phone"></i></div>
                    @endif
                    @if (!empty($cv->contact->location) || !empty($cv->contact->country))
                        <div>{{ implode(', ', array_filter([$cv->contact->location, $cv->contact->country])) }} <i class="fa-solid fa-map"></i></div>
                    @endif
                    @if (!empty($cv->contact->profile_link))
                        <div>{{ $cv->contact->profile_link }} <i class="fa-solid fa-link"></i></div>
                    @endif
                </td>
            </tr>
        </table>

        <!-- SUMMARY SECTION -->
        @if (!empty($cv->summary->summary))
            <div class="summary-text">
                {{ $cv->summary->summary }}
            </div>
        @endif

        <!-- WORK EXPERIENCE SECTION -->
        @if (!empty($cv->experiences) && count($cv->experiences) > 0)
            <div class="section-heading">WORK EXPERIENCE</div>

            <table width="100%">
                @foreach ($cv->experiences as $index => $exp)
                    <tr>
                        <!-- Timeline Bullet & Line Column -->
                        <td class="timeline-bullet-cell" style="">
                            <span class="timeline-bullet"></span>
                        </td>

                        <!-- Details Column -->
                        <td style="padding-left: 8px; padding-bottom: 8px;">
                            <div class="entry-title">{{ $exp->job_title }}</div>
                            <div class="entry-subtitle">{{ $exp->company }}</div>
                            <div class="entry-location">
                                {{ implode(', ', array_filter([$exp->location, $exp->country])) }}
                            </div>
                            <div class="entry-description">
                                {{ $exp->description}}
                            </div>
                        </td>

                        <!-- Date Column -->
                        <td class="entry-date" width="160" style="padding-bottom: 8px;">
                            {{ $exp->start_month }} / {{ $exp->start_year }} 
                            @if ($exp->is_present==1)
                              - Present
                             @else
                             
                             – {{ $exp->end_month }} / {{ $exp->end_year }}
                            @endif
                            
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif

        <!-- EDUCATION SECTION -->
        @if (!empty($cv->educations) && count($cv->educations) > 0)
            <div class="section-heading">EDUCATION</div>

            <table width="100%">
                @foreach ($cv->educations as $edu)
                    <tr>
                        <!-- Timeline Bullet & Line Column -->
                        <td class="timeline-bullet-cell" style="{{ !$loop->last ? 'border-right: 1px dotted #a38c73;' : '' }}">
                            <span class="timeline-bullet"></span>
                        </td>

                        <!-- Details Column -->
                        <td style="padding-left: 8px; padding-bottom: 8px;">
                            <div class="entry-title">{{ $edu->degree }}</div>
                            <div class="entry-subtitle">{{ $edu->institution }}</div>
                            <div class="entry-location">
                                {{ implode(', ', array_filter([$edu->location ?? '', $edu->country ?? ''])) }}
                            </div>
                        </td>

                        <!-- Date Column -->
                        <td class="entry-date" width="160" style="padding-bottom: 8px;">
                            {{ $edu->start_month }}/{{ $edu->start_year }} – {{ $edu->end_month }}/{{ $edu->end_year }}
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif
                <!-- Languages SECTION -->
        @if (!empty($cv->languages) && count($cv->languages) > 0)
            <div class="section-heading">Languages</div>
            <div style="padding-top: 4px;">
                @foreach ($cv->languages as $lang)
                    <span class="skill-pill">{{ $lang->language }}</span>
                @endforeach
            </div>
        @endif
        <!-- Certificates SECTION -->
        @if (!empty($cv->certificates) && count($cv->certificates) > 0)
            <div class="section-heading">Certificates</div>

            <table width="100%">
                @foreach ($cv->certificates as $edu)
                    <tr>
                        <!-- Timeline Bullet & Line Column -->
                        <td class="timeline-bullet-cell" style="{{ !$loop->last ? 'border-right: 1px dotted #a38c73;' : '' }}">
                            <span class="timeline-bullet"></span>
                        </td>

                        <!-- Details Column -->
                        <td style="padding-left: 8px; padding-bottom: 8px;">
                            <div class="entry-title">{{ $edu->name }}</div>
                            <div class="entry-subtitle">{{ $edu->organization }}</div>
                        </td>

                        <!-- Date Column -->
                        <td class="entry-date" width="160" style="padding-bottom: 8px;">
                            {{ $edu->start_month }}/{{ $edu->start_year }}
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif

        <!-- SKILLS SECTION -->
        @if (!empty($cv->skills) && count($cv->skills) > 0)
            <div class="section-heading">SKILLS</div>
            <div style="padding-top: 4px;">
                @foreach ($cv->skills as $skill)
                    <span class="skill-pill">{{ $skill->skill }}</span>
                @endforeach
            </div>
        @endif

    </div>

</body>
</html>