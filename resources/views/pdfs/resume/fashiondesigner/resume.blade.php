<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resume PDF - Fashion Designer Theme</title>
    <style>
        @page {
            size: A4;
            margin: 12mm 15mm;
            background-color: #ffffff;
        }

        /* Root Container & Reset */
        .zeecv_pdf_outer {
            width: 100%;
            background-color: #ffffff !important;
            box-sizing: border-box;
            color: #2b2b2b;
            font-family: 'Didot', 'Bodoni MT', 'Cinzel', 'Georgia', serif;
            font-size: 8.5pt;
            line-height: 1.45;
        }

        .zeecv_pdf_outer *,
        .zeecv_pdf_outer *::before,
        .zeecv_pdf_outer *::after {
            box-sizing: border-box;
        }

        .zeecv_pdf_outer body {
            margin: 0;
            padding: 0;
            background-color: #ffffff !important;
        }

        /* Layout Tables */
        .zeecv_pdf_outer table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .zeecv_pdf_outer td {
            padding: 0;
            vertical-align: top;
        }

        /* Fashion Editorial Header */
        .zeecv_pdf_outer .header-table {
            border-bottom: 1px solid #111111;
            padding-bottom: 12px;
            margin-bottom: 14px;
        }

        .zeecv_pdf_outer .resume-name {
            margin: 0 0 4px 0;
            font-size: 22pt;
            font-weight: 400;
            color: #111111;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            line-height: 1.0;
        }

        .zeecv_pdf_outer .resume-subtitle {
            margin: 0;
            font-size: 9.5pt;
            font-weight: 300;
            color: #705c53; /* Warm Rose-Taupe Accent */
            text-transform: uppercase;
            letter-spacing: 3px;
            font-family: 'Segoe UI', -apple-system, sans-serif;
        }

        .zeecv_pdf_outer .contact-text {
            font-size: 8pt;
            color: #4a4a4a;
            text-align: right;
            line-height: 1.6;
            font-family: 'Segoe UI', -apple-system, sans-serif;
            font-weight: 400;
            letter-spacing: 0.5px;
        }

        .zeecv_pdf_outer .contact-item {
            display: inline-block;
            margin-bottom: 2px;
        }

        /* Elegant Editorial Section Headings */
        .zeecv_pdf_outer .section-heading {
            font-size: 10pt;
            font-weight: 600;
            color: #111111;
            text-transform: uppercase;
            letter-spacing: 2px;
            padding-bottom: 3px;
            margin-top: 12px;
            margin-bottom: 10px;
            border-bottom: 1px solid #dcd6cd;
            font-family: 'Segoe UI', -apple-system, sans-serif;
            page-break-after: avoid;
        }

        /* Summary Section */
        .zeecv_pdf_outer .summary-container {
            margin-bottom: 12px;
        }

        .zeecv_pdf_outer .summary-text {
            font-size: 8.5pt;
            color: #3b3b3b;
            line-height: 1.55;
            text-align: justify;
            font-family: 'Georgia', serif;
            font-style: italic;
        }

        /* Experience & Entry Styling */
        .zeecv_pdf_outer .entry-table {
            margin-bottom: 10px;
        }

        .zeecv_pdf_outer .entry-title {
            font-size: 9.5pt;
            font-weight: 600;
            color: #111111;
            font-family: 'Segoe UI', -apple-system, sans-serif;
            letter-spacing: 0.3px;
        }

        .zeecv_pdf_outer .entry-subtitle {
            font-size: 9pt;
            font-weight: 400;
            color: #705c53;
            font-style: italic;
            font-family: 'Georgia', serif;
        }

        .zeecv_pdf_outer .entry-location {
            font-size: 8pt;
            color: #777777;
            font-family: 'Segoe UI', -apple-system, sans-serif;
        }

        .zeecv_pdf_outer .entry-date {
            font-size: 8pt;
            font-weight: 500;
            color: #666666;
            text-align: right;
            white-space: nowrap;
            letter-spacing: 0.5px;
            font-family: 'Segoe UI', -apple-system, sans-serif;
        }

        .zeecv_pdf_outer .entry-description {
            font-size: 8.5pt;
            color: #3a3a3a;
            margin-top: 4px;
            line-height: 1.45;
            font-family: 'Georgia', serif;
        }

        /* Custom Bullet List */
        .zeecv_pdf_outer .bullet-list {
            margin: 4px 0 0 0;
            padding-left: 14px;
            list-style-type: circle;
        }

        .zeecv_pdf_outer .bullet-list li {
            margin-bottom: 3px;
            font-size: 8.5pt;
            color: #3a3a3a;
            line-height: 1.4;
            font-family: 'Georgia', serif;
        }

        /* Fashion Pill Badges for Skills */
        .zeecv_pdf_outer .skills-container {
            margin-top: 4px;
            padding-bottom: 4px;
        }

        .zeecv_pdf_outer .skill-badge {
            display: inline-block;
            background-color: #f7f5f2;
            color: #2b2b2b;
            border: 1px solid #e5e0d8;
            padding: 3px 9px;
            margin: 2px 4px 4px 0;
            font-size: 7.8pt;
            font-weight: 500;
            letter-spacing: 0.5px;
            border-radius: 12px;
            font-family: 'Segoe UI', -apple-system, sans-serif;
        }

        /* Language Cards */
        .zeecv_pdf_outer .language-card {
            border-left: 2px solid #705c53;
            padding-left: 6px;
            font-size: 8.5pt;
            font-family: 'Segoe UI', -apple-system, sans-serif;
        }

        .zeecv_pdf_outer .language-name {
            font-weight: 600;
            color: #111111;
        }

        .zeecv_pdf_outer .language-prof {
            color: #777777;
            font-size: 8pt;
        }

        /* Certifications Table */
        .zeecv_pdf_outer .cert-row {
            padding-bottom: 6px;
        }
    </style>
</head>
<body class="zeecv_pdf_outer">
    <div class="zeecv_pdf_outer">
        <div id="resumePrintDive" class="zeecv_pdf_outer resumePrintDiveInner">

            <!-- HEADER SECTION -->
            <table class="zeecv_pdf_outer header-table">
                <tr>
                    <td width="60%">
                        <h1 class="zeecv_pdf_outer resume-name">{{ $cv->contact->first_name . ' ' . $cv->contact->last_name }}</h1>
                        <p class="zeecv_pdf_outer resume-subtitle">{{ $cv->contact->desired_job_title }}</p>
                    </td>
                    <td width="40%" class="zeecv_pdf_outer contact-text">
                        @if (!empty($cv->contact->email))
                            <div class="zeecv_pdf_outer contact-item">{{ $cv->contact->email }}</div>
                        @endif
                        @if (!empty($cv->contact->phone) || !empty($cv->contact->location))
                            <div>
                                {{ implode(' &bull; ', array_filter([
                                    $cv->contact->location ?? '',
                                    $cv->contact->country ?? '',
                                    $cv->contact->phone ?? ''
                                ])) }}
                            </div>
                        @endif
                        @if (!empty($cv->contact->profile_link))
                            <div>{{ $cv->contact->profile_link }}</div>
                        @endif
                    </td>
                </tr>
            </table>

            <!-- SUMMARY SECTION -->
            @if (!empty($cv->summary->summary))
                <div class="zeecv_pdf_outer summary-container">
                    <div class="zeecv_pdf_outer section-heading">Design Philosophy</div>
                    <div class="zeecv_pdf_outer summary-text">
                        "{{ $cv->summary->summary }}"
                    </div>
                </div>
            @endif

            <!-- WORK EXPERIENCE SECTION -->
            @if (!empty($cv->experiences) && count($cv->experiences) > 0)
                <div class="zeecv_pdf_outer section-heading">Collection & Industry Experience</div>

                <table class="zeecv_pdf_outer entry-table">
                    @foreach ($cv->experiences as $exp)
                        <tr>
                            <td style="padding-bottom: 10px;">
                                <table class="zeecv_pdf_outer">
                                    <tr>
                                        <td>
                                            <span class="zeecv_pdf_outer entry-title">{{ $exp->job_title }}</span>
                                            @if (!empty($exp->company))
                                                <span class="zeecv_pdf_outer entry-subtitle"> — {{ $exp->company }}</span>
                                            @endif
                                            @if (!empty($exp->location) || !empty($exp->country))
                                                <span class="zeecv_pdf_outer entry-location">({{ implode(', ', array_filter([$exp->location, $exp->country])) }})</span>
                                            @endif
                                        </td>
                                        <td width="130" style="text-align: right;">
                                            <span class="zeecv_pdf_outer entry-date">
                                                {{ $exp->start_month }}/{{ $exp->start_year }} – 
                                                @if ($exp->is_present == 1)
                                                    Present
                                                @else
                                                    {{ $exp->end_month }}/{{ $exp->end_year }}
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                                <div class="zeecv_pdf_outer entry-description">
                                    @if(str_contains($exp->description, "\n") || str_contains($exp->description, "•"))
                                        <ul class="zeecv_pdf_outer bullet-list">
                                            @foreach(explode("\n", str_replace('•', '', $exp->description)) as $bullet)
                                                @if(trim($bullet) !== '')
                                                    <li>{{ trim($bullet) }}</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @else
                                        {{ $exp->description }}
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif

            <!-- SKILLS SECTION -->
            @if (!empty($cv->skills) && count($cv->skills) > 0)
                <div class="zeecv_pdf_outer section-heading">Technical & Creative Expertise</div>
                <div class="zeecv_pdf_outer skills-container">
                    @foreach ($cv->skills as $skill)
                        <span class="zeecv_pdf_outer skill-badge">{{ is_object($skill) ? $skill->skill : $skill }}</span>
                    @endforeach
                </div>
            @endif

            <!-- EDUCATION SECTION -->
            @if (!empty($cv->educations) && count($cv->educations) > 0)
                <div class="zeecv_pdf_outer section-heading">Education & Training</div>

                <table class="zeecv_pdf_outer entry-table">
                    @foreach ($cv->educations as $edu)
                        <tr>
                            <td style="padding-bottom: 6px;">
                                <table class="zeecv_pdf_outer">
                                    <tr>
                                        <td>
                                            <div class="zeecv_pdf_outer entry-title">{{ $edu->degree }}</div>
                                            <div class="zeecv_pdf_outer entry-subtitle" style="color: #666666; font-style: normal;">
                                                {{ $edu->institution }}
                                                @if(!empty($edu->location) || !empty($edu->country))
                                                    <span class="zeecv_pdf_outer entry-location">, {{ implode(', ', array_filter([$edu->location ?? '', $edu->country ?? ''])) }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td width="130" style="text-align: right;">
                                            <span class="zeecv_pdf_outer entry-date">
                                                {{ $edu->start_month }}/{{ $edu->start_year }} – {{ $edu->end_month }}/{{ $edu->end_year }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif

            <!-- LANGUAGES SECTION -->
            @if (!empty($cv->languages) && count($cv->languages) > 0)
                <div class="zeecv_pdf_outer section-heading">Languages</div>
                <div style="padding-bottom: 6px;">
                    <table class="zeecv_pdf_outer">
                        <tr>
                            @foreach ($cv->languages as $lang)
                                <td style="padding-right: 12px; width: 33%;">
                                    <div class="zeecv_pdf_outer language-card">
                                        <span class="zeecv_pdf_outer language-name">{{ $lang->language }}</span>
                                        @if(!empty($lang->proficiency))
                                            <span class="zeecv_pdf_outer language-prof">({{ $lang->proficiency }})</span>
                                        @endif
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    </table>
                </div>
            @endif

            <!-- CERTIFICATES SECTION -->
            @if (!empty($cv->certificates) && count($cv->certificates) > 0)
                <div class="zeecv_pdf_outer section-heading">Accreditations & Awards</div>

                <table class="zeecv_pdf_outer entry-table">
                    @foreach ($cv->certificates as $cert)
                        <tr>
                            <td class="zeecv_pdf_outer cert-row" style="padding-bottom: 4px;">
                                <table class="zeecv_pdf_outer">
                                    <tr>
                                        <td>
                                            <span class="zeecv_pdf_outer entry-title">{{ $cert->name }}</span>
                                            <span class="zeecv_pdf_outer entry-subtitle"> — {{ $cert->organization }}</span>
                                        </td>
                                        <td width="130" style="text-align: right;">
                                            <span class="zeecv_pdf_outer entry-date">
                                                {{ $cert->start_month }}/{{ $cert->start_year }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif

        </div>
    </div>
</body>
</html>