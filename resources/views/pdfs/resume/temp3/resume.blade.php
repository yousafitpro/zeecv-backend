@extends('pdfs.resume.layout')
@section('resume_content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resume PDF</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
                /* Import Google Font so PDF renderers can fetch it */
            /* Import Google Font so PDF renderers can fetch it */
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

            @page {
                size: A4;
                margin: 0;
                background-color: #ffffff;
                
            }


                /* Adjusted max-width and margins for proper PDF edge clearance */
        .zeecv_pdf_outer {
            
            
            margin: 0 auto;
            background-color: transparent !important;
            box-sizing: border-box;
            color: #1a202c;
            font-size: 8.5pt;
            line-height: 1.45;
            padding: 10mm 5mm;
            width: 200mm;
        }
        .zeecv_pdf_outer::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 210mm;
            height: 297mm;

            background-image: url('{{ asset('resume/backgrounds/resume-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

            z-index: -1;
        }

        .zeecv_pdf_outer *,
        .zeecv_pdf_outer *::before,
        .zeecv_pdf_outer *::after {
            box-sizing: border-box;
        }

        .zeecv_pdf_outer table {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed; /* Ensures tight column bounds */
        }

        /* --- Header Section --- */
        .zeecv_pdf_outer .header-table {
            border-bottom: 2px solid #0f2b48;
            padding-bottom: 12px;
            margin-bottom: 10px;
        }

        .zeecv_pdf_outer .resume-name {
            margin: 0 0 3px 0;
            font-size: 21pt;
            font-weight: 800;
            color: #0f2b48;
            line-height: 1.1;
            letter-spacing: -0.3px;
            text-transform: uppercase;
        }

        .zeecv_pdf_outer .resume-subtitle {
            margin: 0;
            font-size: 9.5pt;
            font-weight: 700;
            color: #3182ce;
            line-height: 1.2;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .zeecv_pdf_outer .contact-text {
            font-size: 8pt;
            color: #4a5568;
            text-align: right;
            line-height: 1.65;
            font-weight: 500;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .zeecv_pdf_outer .contact-text i {
            color: #0f2b48;
            width: 13px;
            text-align: center;
            margin-right: 3px;
            font-size: 8pt;
        }

        /* --- Section Headings --- */
        .zeecv_pdf_outer .section-heading {
            font-size: 9.5pt;
            font-weight: 800;
            color: #0f2b48;
            border-bottom: 1px solid #cbd5e0;
            padding-bottom: 3px;
            margin-top: 11px;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
        }

        .zeecv_pdf_outer .section-heading::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 30px;
            height: 2px;
            background-color: #3182ce;
        }

        /* --- Executive Summary --- */
        .zeecv_pdf_outer .summary-text {
            font-size: 8.5pt;
            color: #2d3748;
            line-height: 1.45;
            text-align: justify;
        }

        /* --- Experience & Education --- */
        .zeecv_pdf_outer .entry-title {
            font-size: 9pt;
            font-weight: 700;
            color: #0f2b48;
            letter-spacing: -0.1px;
            word-wrap: break-word;
        }

        .zeecv_pdf_outer .entry-subtitle {
            font-size: 8.5pt;
            font-weight: 600;
            color: #2b6cb0;
        }

        .zeecv_pdf_outer .entry-location {
            font-size: 8pt;
            color: #718096;
            font-style: italic;
            font-weight: 400;
        }

        .zeecv_pdf_outer .entry-date {
            font-size: 8pt;
            font-weight: 700;
            color: #4a5568;
            text-align: right;
            vertical-align: top;
            white-space: nowrap;
            letter-spacing: 0.1px;
        }

        .zeecv_pdf_outer .entry-description {
            font-size: 8.5pt;
            color: #2d3748;
            margin-top: 3px;
            line-height: 1.4;
        }

        .zeecv_pdf_outer .bullet-list {
            margin: 3px 0 0 0;
            padding-left: 14px;
        }

        .zeecv_pdf_outer .bullet-list li {
            margin-bottom: 2.5px;
            font-size: 8.5pt;
            line-height: 1.35;
            color: #2d3748;
        }

        /* --- Clean Grid Skills Section --- */
        .zeecv_pdf_outer .skills-wrapper {
            padding-top: 2px;
            padding-bottom: 2px;
        }

        .zeecv_pdf_outer .skills-pill-container {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
        }

        .zeecv_pdf_outer .skill-pill {
            background-color: #f7fafc;
            color: #2d3748;
            border: 1px solid #e2e8f0;
            border-left: 3px solid #3182ce;
            padding: 2px 7px;
            font-weight: 600;
            font-size: 8pt;
            border-radius: 2px;
        }

        /* --- Languages & Certifications --- */
        .zeecv_pdf_outer .lang-table td {
            font-size: 8.5pt;
            padding-bottom: 4px;
        }

        .zeecv_pdf_outer .lang-title {
            font-weight: 700;
            color: #0f2b48;
        }

        .zeecv_pdf_outer .lang-prof {
            color: #718096;
            font-size: 8pt;
        }
    </style>
</head>
<body>
    <div class="zeecv_pdf_outer" >
        <div id="resumePrintDive" class="resumePrintDiveInner">

            <!-- HEADER SECTION -->
            <table class="header-table" cell-spacing="0" cell-padding="0">
                <tr>
                    <td width="55%" style="vertical-align: middle;">
                        <h1 class="resume-name">{{ $cv->contact->first_name . ' ' . $cv->contact->last_name }}</h1>
                        <p class="resume-subtitle">{{ $cv->contact->desired_job_title }}</p>
                    </td>
                    <td width="45%" class="contact-text" style="vertical-align: middle;">
                        @if (!empty($cv->contact->email))
                            <div><i class="fa-solid fa-envelope"></i> {{ $cv->contact->email }}</div>
                        @endif
                        @if (!empty($cv->contact->phone) || !empty($cv->contact->location))
                            <div>
                                <i class="fa-solid fa-location-dot"></i> 
                                {{ implode(', ', array_filter([
                                    $cv->contact->location ?? '',
                                    $cv->contact->country ?? ''
                                ])) }}
                                @if(!empty($cv->contact->phone))
                                    &nbsp;|&nbsp; <i class="fa-solid fa-phone"></i> {{ $cv->contact->phone }}
                                @endif
                            </div>
                        @endif
                        @if (!empty($cv->contact->profile_link))
                            <div><i class="fa-solid fa-arrow-up-right-from-square"></i> {{ $cv->contact->profile_link }}</div>
                        @endif
                    </td>
                </tr>
            </table>

            <!-- SUMMARY SECTION -->
            @if (!empty($cv->summary->summary))
                <div class="section-heading">Professional Profile</div>
                <div class="summary-text">
                    {{ $cv->summary->summary }}
                </div>
            @endif

            <!-- WORK EXPERIENCE SECTION -->
            @if (!empty($cv->experiences) && count($cv->experiences) > 0)
                <div class="section-heading">Professional Experience</div>

                <table width="100%" cell-spacing="0" cell-padding="0">
                    @foreach ($cv->experiences as $exp)
                        <tr>
                            <td width="72%" style="padding-bottom: 9px; vertical-align: top;">
                                <div class="entry-title">
                                    {{ $exp->job_title }}
                                    @if (!empty($exp->company))
                                        <span class="entry-subtitle"> | {{ $exp->company }}</span>
                                    @endif
                                    @if (!empty($exp->location) || !empty($exp->country))
                                        <span class="entry-location">({{ implode(', ', array_filter([$exp->location, $exp->country])) }})</span>
                                    @endif
                                </div>
                                <div class="entry-description">
                                    @if(str_contains($exp->description, "\n") || str_contains($exp->description, "•"))
                                        <ul class="bullet-list">
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
                            <td class="entry-date" width="28%" style="padding-bottom: 9px;">
                                {{ $exp->start_month }}/{{ $exp->start_year }} – 
                                @if ($exp->is_present == 1)
                                    Present
                                @else
                                    {{ $exp->end_month }}/{{ $exp->end_year }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif

            <!-- EDUCATION SECTION -->
            @if (!empty($cv->educations) && count($cv->educations) > 0)
                <div class="section-heading">Education</div>

                <table width="100%" cell-spacing="0" cell-padding="0">
                    @foreach ($cv->educations as $edu)
                        <tr>
                            <td width="72%" style="padding-bottom: 7px; vertical-align: top;">
                                <div class="entry-title">{{ $edu->degree }}</div>
                                <div class="entry-subtitle">
                                    {{ $edu->institution }}
                                    @if(!empty($edu->location) || !empty($edu->country))
                                        <span class="entry-location">, {{ implode(', ', array_filter([$edu->location ?? '', $edu->country ?? ''])) }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="entry-date" width="28%" style="padding-bottom: 7px;">
                                {{ $edu->start_month }}/{{ $edu->start_year }} – {{ $edu->end_month }}/{{ $edu->end_year }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif

            <!-- SKILLS SECTION -->
            @if (!empty($cv->skills) && count($cv->skills) > 0)
                <div class="section-heading">Core Competencies</div>
                <div class="skills-wrapper">
                    <div class="skills-pill-container">
                        @foreach ($cv->skills as $skillItem)
                            <div class="skill-pill">{{ is_object($skillItem) ? $skillItem->skill : $skillItem }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- LANGUAGES SECTION -->
            @if (!empty($cv->languages) && count($cv->languages) > 0)
                <div class="section-heading">Languages</div>
                <table class="lang-table" width="100%" cell-spacing="0" cell-padding="0">
                    <tr>
                        <td style="padding-top: 2px;">
                            @foreach ($cv->languages as $lang)
                                <span style="margin-right: 20px; display: inline-block;">
                                    <span class="lang-title">{{ $lang->language }}</span>
                                    @if(!empty($lang->proficiency))
                                        <span class="lang-prof">({{ $lang->proficiency }})</span>
                                    @endif
                                </span>
                            @endforeach
                        </td>
                    </tr>
                </table>
            @endif

            <!-- CERTIFICATIONS SECTION -->
            @if (!empty($cv->certificates) && count($cv->certificates) > 0)
                <div class="section-heading">Certifications & Training</div>

                <table width="100%" cell-spacing="0" cell-padding="0">
                    @foreach ($cv->certificates as $cert)
                        <tr>
                            <td width="72%" style="padding-bottom: 5px; vertical-align: top;">
                                <div class="entry-title">{{ $cert->name }} <span class="entry-subtitle">| {{ $cert->organization }}</span></div>
                            </td>
                            <td class="entry-date" width="28%" style="padding-bottom: 5px;">
                                {{ $cert->start_month }}/{{ $cert->start_year }}
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