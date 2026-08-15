@extends('pdfs.resume.layout')
@section('resume_content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resume PDF - Game Developer Theme</title>
    <style>
        @page {
            size: A4;
            margin: 10mm 12mm;
            background-color: #ffffff;
        }

        /* Root Container & Reset */
        .zeecv_pdf_outer {
            width: 100%;
            background-color: #ffffff !important;
            box-sizing: border-box;
            color: #1e293b;
            font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, Helvetica, Arial, sans-serif;
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

        /* Header Accent Banner & Typography */
        .zeecv_pdf_outer .header-table {
            border-bottom: 2px solid #0f172a;
            padding-bottom: 10px;
            margin-bottom: 12px;
        }

        .zeecv_pdf_outer .resume-name {
            margin: 0 0 2px 0;
            font-size: 20pt;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
            text-transform: uppercase;
            line-height: 1.1;
        }

        .zeecv_pdf_outer .resume-subtitle {
            margin: 0;
            font-size: 10pt;
            font-weight: 700;
            color: #2563eb; /* Cyber/Tech Accent Blue */
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .zeecv_pdf_outer .contact-text {
            font-size: 8pt;
            color: #475569;
            text-align: right;
            line-height: 1.5;
            font-weight: 500;
        }

        .zeecv_pdf_outer .contact-badge {
            display: inline-block;
            background-color: #f1f5f9;
            color: #0f172a;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: 600;
            font-size: 7.5pt;
            border-left: 3px solid #2563eb;
            margin-bottom: 3px;
        }

        /* Game Dev Styled Section Headings */
        .zeecv_pdf_outer .section-heading {
            font-size: 10.5pt;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 4px 8px;
            margin-top: 10px;
            margin-bottom: 8px;
            background-color: #f8fafc;
            border-left: 4px solid #2563eb;
            border-right: 1px solid #e2e8f0;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
            page-break-after: avoid;
        }

        /* Summary Section */
        .zeecv_pdf_outer .summary-container {
            margin-bottom: 10px;
        }

        .zeecv_pdf_outer .summary-text {
            font-size: 8.5pt;
            color: #334155;
            line-height: 1.5;
            text-align: justify;
            padding: 2px 4px;
        }

        /* Experience & Entry Styling */
        .zeecv_pdf_outer .entry-table {
            margin-bottom: 8px;
        }

        .zeecv_pdf_outer .entry-title {
            font-size: 9.5pt;
            font-weight: 700;
            color: #0f172a;
        }

        .zeecv_pdf_outer .entry-subtitle {
            font-size: 9pt;
            font-weight: 600;
            color: #2563eb;
        }

        .zeecv_pdf_outer .entry-location {
            font-size: 8pt;
            color: #64748b;
            font-style: italic;
        }

        .zeecv_pdf_outer .entry-date {
            font-size: 8pt;
            font-weight: 700;
            color: #475569;
            text-align: right;
            white-space: nowrap;
            background: #f1f5f9;
            padding: 2px 6px;
            border-radius: 3px;
            border: 1px solid #e2e8f0;
        }

        .zeecv_pdf_outer .entry-description {
            font-size: 8.5pt;
            color: #334155;
            margin-top: 4px;
            line-height: 1.4;
        }

        /* Custom Bullet List */
        .zeecv_pdf_outer .bullet-list {
            margin: 4px 0 0 0;
            padding-left: 14px;
            list-style-type: square;
        }

        .zeecv_pdf_outer .bullet-list li {
            margin-bottom: 3px;
            font-size: 8.5pt;
            color: #334155;
            line-height: 1.4;
        }

        .zeecv_pdf_outer .bullet-list li::marker {
            color: #2563eb;
        }

        /* Game Engine & Tech Skill Tag Grid Layout */
        .zeecv_pdf_outer .skills-table {
            margin-top: 2px;
        }

        .zeecv_pdf_outer .skill-tag {
            display: inline-block;
            background-color: #f1f5f9;
            color: #1e293b;
            border: 1px solid #cbd5e1;
            border-left: 3px solid #0284c7;
            padding: 3px 7px;
            margin: 2px 3px 4px 0;
            font-size: 8pt;
            font-weight: 600;
            border-radius: 2px;
        }

        /* Language Badges */
        .zeecv_pdf_outer .language-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 8.5pt;
        }

        .zeecv_pdf_outer .language-name {
            font-weight: 700;
            color: #0f172a;
        }

        .zeecv_pdf_outer .language-prof {
            color: #64748b;
            font-size: 8pt;
        }

        /* Certifications Table */
        .zeecv_pdf_outer .cert-row {
            padding-bottom: 6px;
        }
    </style>
</head>
<body class="zeecv_pdf_outer" style="">
    <div class="zeecv_pdf_outer" style="padding: 10mm 5mm;
            width: 180mm;">
        <div id="resumePrintDive" class="zeecv_pdf_outer resumePrintDiveInner">

            <!-- HEADER SECTION -->
            <table class="zeecv_pdf_outer header-table">
                <tr>
                    <td width="62%">
                        <h1 class="zeecv_pdf_outer resume-name">{{ $cv->contact->first_name . ' ' . $cv->contact->last_name }}</h1>
                        <p class="zeecv_pdf_outer resume-subtitle"> {{ $cv->contact->desired_job_title }}</p>
                    </td>
                    <td width="38%" class="zeecv_pdf_outer contact-text">
                        @if (!empty($cv->contact->email))
                            <div><span class="zeecv_pdf_outer contact-badge">EMAIL</span> {{ $cv->contact->email }}</div>
                        @endif
                        @if (!empty($cv->contact->phone) || !empty($cv->contact->location))
                            <div>
                                <span class="zeecv_pdf_outer contact-badge">LOC / TEL</span>
                                {{ implode(' | ', array_filter([
                                    $cv->contact->location ?? '',
                                    $cv->contact->country ?? '',
                                    $cv->contact->phone ?? ''
                                ])) }}
                            </div>
                        @endif
                        @if (!empty($cv->contact->profile_link))
                            <div><span class="zeecv_pdf_outer contact-badge">PORTFOLIO</span> {{ $cv->contact->profile_link }}</div>
                        @endif
                    </td>
                </tr>
            </table>

            <!-- SUMMARY SECTION -->
            @if (!empty($cv->summary->summary))
                <div class="zeecv_pdf_outer summary-container">
                    <div class="zeecv_pdf_outer section-heading">// Dev Overview</div>
                    <div class="zeecv_pdf_outer summary-text">
                        {{ $cv->summary->summary }}
                    </div>
                </div>
            @endif

            <!-- WORK EXPERIENCE SECTION -->
            @if (!empty($cv->experiences) && count($cv->experiences) > 0)
                <div class="zeecv_pdf_outer section-heading">// Professional Experience</div>

                <table class="zeecv_pdf_outer entry-table">
                    @foreach ($cv->experiences as $exp)
                        <tr>
                            <td style="padding-bottom: 10px;">
                                <table class="zeecv_pdf_outer">
                                    <tr>
                                        <td>
                                            <span class="zeecv_pdf_outer entry-title">{{ $exp->job_title }}</span>
                                            @if (!empty($exp->company))
                                                <span class="zeecv_pdf_outer entry-subtitle"> @ {{ $exp->company }}</span>
                                            @endif
                                            @if (!empty($exp->location) || !empty($exp->country))
                                                <span class="zeecv_pdf_outer entry-location">({{ implode(', ', array_filter([$exp->location, $exp->country])) }})</span>
                                            @endif
                                        </td>
                                        <td width="120" style="text-align: right;">
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
                <div class="zeecv_pdf_outer section-heading">// Core Tech & Skill Matrix</div>
                <div class="zeecv_pdf_outer skills-table" style="padding-bottom: 6px;">
                    @foreach ($cv->skills as $skill)
                        <span class="zeecv_pdf_outer skill-tag">{{ is_object($skill) ? $skill->skill : $skill }}</span>
                    @endforeach
                </div>
            @endif

            <!-- EDUCATION SECTION -->
            @if (!empty($cv->educations) && count($cv->educations) > 0)
                <div class="zeecv_pdf_outer section-heading">// Education & Background</div>

                <table class="zeecv_pdf_outer entry-table">
                    @foreach ($cv->educations as $edu)
                        <tr>
                            <td style="padding-bottom: 6px;">
                                <table class="zeecv_pdf_outer">
                                    <tr>
                                        <td>
                                            <div class="zeecv_pdf_outer entry-title">{{ $edu->degree }}</div>
                                            <div class="zeecv_pdf_outer entry-subtitle" style="color: #475569; font-weight: 600;">
                                                {{ $edu->institution }}
                                                @if(!empty($edu->location) || !empty($edu->country))
                                                    <span class="zeecv_pdf_outer entry-location">, {{ implode(', ', array_filter([$edu->location ?? '', $edu->country ?? ''])) }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td width="120" style="text-align: right;">
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
                <div class="zeecv_pdf_outer section-heading">// Languages</div>
                <div style="padding-bottom: 6px;">
                    <table class="zeecv_pdf_outer">
                        <tr>
                            @foreach ($cv->languages as $lang)
                                <td style="padding-right: 10px; width: 33%;">
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
                <div class="zeecv_pdf_outer section-heading">// Certifications & Credits</div>

                <table class="zeecv_pdf_outer entry-table">
                    @foreach ($cv->certificates as $cert)
                        <tr>
                            <td class="zeecv_pdf_outer cert-row" style="padding-bottom: 4px;">
                                <table class="zeecv_pdf_outer">
                                    <tr>
                                        <td>
                                            <span class="zeecv_pdf_outer entry-title">{{ $cert->name }}</span>
                                            <span class="zeecv_pdf_outer entry-subtitle" style="color:#64748b;"> — {{ $cert->organization }}</span>
                                        </td>
                                        <td width="120" style="text-align: right;">
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
@endsection