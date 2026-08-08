<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resume PDF</title>
    <style>
        /* PDF Page Setup */
        @page {
            margin: 25px 30px;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333333;
            font-size: 11px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        /* Table Resets */
        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        td {
            padding: 0;
            vertical-align: top;
        }

        /* Typography */
        .resume-name {
            font-size: 20px;
            font-weight: bold;
            color: #111111;
            margin: 0 0 3px 0;
        }

        .resume-subtitle {
            font-size: 10px;
            color: #666666;
            margin: 0;
        }

        .contact-text {
            font-size: 9.5px;
            color: #555555;
            text-align: right;
            line-height: 1.5;
        }

        .section-heading {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #222222;
            border-bottom: 1px solid #dcdcdc;
            padding-bottom: 4px;
            margin-top: 15px;
            margin-bottom: 12px;
        }

        .summary-text {
            font-size: 10px;
            color: #444444;
            line-height: 1.5;
            margin-bottom: 12px;
        }

        /* Timeline Table Structure */
        .timeline-bullet-cell {
            width: 16px;
            text-align: center;
        }

        .timeline-bullet {
            display: inline-block;
            width: 6px;
            height: 6px;
            border: 2px solid #a38c73;
            border-radius: 50%;
            background-color: #ffffff;
            margin-top: 2px;
        }

        .timeline-line-cell {
            width: 16px;
            background: url('data:image/png;base64,iVBORw0KGgoAAAANSUheader...') repeat-y center;
            border-right: 1px dotted #a38c73;
        }

        .entry-title {
            font-size: 11px;
            font-weight: bold;
            color: #111111;
            margin: 0;
        }

        .entry-subtitle {
            font-size: 10px;
            font-style: italic;
            color: #666666;
            margin: 2px 0;
        }

        .entry-location {
            font-size: 9.5px;
            color: #777777;
            margin: 0 0 10px 0;
        }

        .entry-date {
            font-size: 10px;
            font-style: italic;
            color: #666666;
            text-align: right;
            white-space: nowrap;
        }

        /* Skills Pill Layout */
        .skill-pill {
            background-color: #b0a18f;
            color: #ffffff;
            font-size: 9px;
            padding: 3px 8px;
            border-radius: 3px;
            display: inline-block;
            margin-right: 4px;
            margin-bottom: 5px;
        }
#resumePrintDive{
    background: white;
    padding: 20px 30px;
}
    </style>
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
                        <div>{{ $cv->contact->email }} &#9993;</div>
                    @endif
                    @if (!empty($cv->contact->phone))
                        <div>{{ $cv->contact->phone }} &#128222;</div>
                    @endif
                    @if (!empty($cv->contact->location) || !empty($cv->contact->country))
                        <div>{{ implode(', ', array_filter([$cv->contact->location, $cv->contact->country])) }} &#128205;</div>
                    @endif
                    @if (!empty($cv->contact->profile_link))
                        <div>{{ $cv->contact->profile_link }} &#128279;</div>
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
                        <td class="timeline-bullet-cell" style="{{ !$loop->last ? 'border-right: 1px dotted #a38c73;' : '' }}">
                            <span class="timeline-bullet"></span>
                        </td>

                        <!-- Details Column -->
                        <td style="padding-left: 8px; padding-bottom: 8px;">
                            <div class="entry-title">{{ $exp->job_title }}</div>
                            <div class="entry-subtitle">{{ $exp->company }}</div>
                            <div class="entry-location">
                                {{ implode(', ', array_filter([$exp->location, $exp->country])) }}
                            </div>
                        </td>

                        <!-- Date Column -->
                        <td class="entry-date" width="160" style="padding-bottom: 8px;">
                            {{ $exp->start_month }}/{{ $exp->start_year }} – {{ $exp->end_month }}/{{ $exp->end_year }}
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