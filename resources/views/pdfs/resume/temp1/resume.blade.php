@extends('pdfs.resume.layout')
@section('resume_content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resume - Muhammad Yousaf</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        /* Use DejaVu Sans - it is built into DomPDF and much more stable than Google Fonts */
        @page {
            size: A4;
            margin: 0;
        }

        .zeecv_pdf_outer {
            width: 100%;
            margin: 0;
            padding: 0;
            background-color: #ffffff !important;
            font-family: "DejaVu Sans", sans-serif;
            color: #2d3748;
            line-height: 1.4;
        }

        .zeecv_pdf_outer table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        /* --- HEADER SECTION (Stable Table Layout) --- */
        .zeecv_pdf_outer .header-dark {
            background-color: #1a202c;
            padding: 35px 45px;
            color: #ffffff;
        }

        .zeecv_pdf_outer .header-name {
            font-size: 24pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            color: #ffffff;
        }

        .zeecv_pdf_outer .header-subtitle {
            font-size: 10pt;
            color: #63b3ed;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 5px;
            margin-bottom: 15px;
        }

        .zeecv_pdf_outer .header-line {
            border: 0;
            border-top: 1px solid #4a5568;
            margin: 15px 0;
        }

        .zeecv_pdf_outer .contact-table td {
            font-size: 8pt;
            color: #cbd5e0;
            padding: 3px 0;
            vertical-align: middle;
        }

        .zeecv_pdf_outer .icon-color {
            color: #63b3ed;
        }

        /* --- CONTENT BODY --- */
        .zeecv_pdf_outer .body-content {
            padding: 25px 45px;
        }

        .zeecv_pdf_outer .section-title {
            font-size: 11pt;
            font-weight: bold;
            color: #1a202c;
            text-transform: uppercase;
            border-bottom: 2px solid #edf2f7;
            padding-bottom: 3px;
            margin-bottom: 12px;
            margin-top: 20px;
        }

        .zeecv_pdf_outer .summary-text {
            font-size: 9pt;
            color: #4a5568;
            text-align: justify;
        }

        /* --- EXPERIENCE / EDUCATION --- */
        .zeecv_pdf_outer .entry-header-text {
            font-size: 10pt;
            font-weight: bold;
            color: #1a202c;
        }

        .zeecv_pdf_outer .entry-sub-text {
            font-size: 9pt;
            color: #3182ce;
            font-weight: bold;
            margin: 2px 0;
        }

        .zeecv_pdf_outer .entry-date {
            font-size: 8.5pt;
            color: #718096;
            text-align: right;
        }

        .zeecv_pdf_outer .bullet-list {
            margin: 5px 0 15px 15px;
            padding: 0;
            list-style-type: disc;
        }

        .zeecv_pdf_outer .bullet-list li {
            font-size: 8.5pt;
            color: #4a5568;
            margin-bottom: 3px;
        }

        /* --- SKILLS (Avoid Flexbox) --- */
        .zeecv_pdf_outer .skills-wrapper {
            margin-top: 5px;
        }

        .zeecv_pdf_outer .skill-item {
            display: inline-block;
            background-color: #f7fafc;
            border: 1px solid #e2e8f0;
            color: #2d3748;
            padding: 3px 8px;
            font-size: 8pt;
            font-weight: bold;
            border-radius: 3px;
            margin-right: 4px;
            margin-bottom: 6px;
        }

        /* --- LANGUAGES --- */
        .zeecv_pdf_outer .lang-table td {
            padding: 5px 10px 5px 0;
            font-size: 9pt;
        }

        .zeecv_pdf_outer .lang-label {
            font-weight: bold;
        }

    </style>
</head>
<body>

<div class="zeecv_pdf_outer">
    
    <!-- HEADER -->
    <div class="header-dark">
        <div class="header-name">{{ $cv->contact->first_name }} {{ $cv->contact->last_name }}</div>
        <div class="header-subtitle">{{ $cv->contact->desired_job_title }}</div>
        
        <div class="header-line"></div>

        <table class="contact-table">
            <tr>
                <td width="35%">
                    <span class="icon-color">✉</span> {{ $cv->contact->email }}
                </td>
                <td width="30%">
                    <span class="icon-color">☎</span> {{ $cv->contact->phone }}
                </td>
                <td width="35%">
                    <span class="icon-color">📍</span> {{ $cv->contact->location }}, {{ $cv->contact->country }}
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <span class="icon-color">🔗</span> {{ str_replace(['https://','www.'], '', $cv->contact->profile_link) }}
                </td>
            </tr>
        </table>
    </div>

    <!-- BODY -->
    <div class="body-content">
        
        <!-- SUMMARY -->
        @if(!empty($cv->summary->summary))
            <div class="section-title">Professional Summary</div>
            <div class="summary-text">{{ $cv->summary->summary }}</div>
        @endif

        <!-- WORK EXPERIENCE -->
        @if(!empty($cv->experiences))
            <div class="section-title">Work Experience</div>
            @foreach($cv->experiences as $exp)
                <table style="margin-bottom: 5px;">
                    <tr>
                        <td width="75%">
                            <div class="entry-header-text">{{ $exp->job_title }}</div>
                            <div class="entry-sub-text">{{ $exp->company }} | {{ $exp->location }}</div>
                        </td>
                        <td class="entry-date">
                            {{ $exp->start_month }}/{{ $exp->start_year }} — {{ $exp->is_present ? 'Present' : $exp->end_month.'/'.$exp->end_year }}
                        </td>
                    </tr>
                </table>
                <ul class="bullet-list">
                    @foreach(explode("\n", str_replace('•', '', $exp->description)) as $bullet)
                        @if(trim($bullet) !== '')
                            <li>{{ trim($bullet) }}</li>
                        @endif
                    @endforeach
                </ul>
            @endforeach
        @endif

        <!-- EDUCATION -->
        @if(!empty($cv->educations))
            <div class="section-title">Education</div>
            @foreach($cv->educations as $edu)
                <table style="margin-bottom: 10px;">
                    <tr>
                        <td width="75%">
                            <div class="entry-header-text">{{ $edu->degree }}</div>
                            <div class="entry-sub-text" style="color: #4a5568;">{{ $edu->institution }}</div>
                        </td>
                        <td class="entry-date">
                            {{ $edu->start_year }} — {{ $edu->end_year }}
                        </td>
                    </tr>
                </table>
            @endforeach
        @endif

        <!-- SKILLS -->
        @if(!empty($cv->skills))
            <div class="section-title">Technical Skills</div>
            <div class="skills-wrapper">
                @foreach($cv->skills as $skill)
                    <div class="skill-item">{{ is_object($skill) ? $skill->skill : $skill }}</div>
                @endforeach
            </div>
        @endif

        <!-- LANGUAGES & CERTIFICATES -->
        <table style="margin-top: 15px;">
            <tr>
                @if(!empty($cv->languages))
                <td width="50%" style="padding-right: 20px;">
                    <div class="section-title">Languages</div>
                    <table class="lang-table">
                        @foreach($cv->languages as $lang)
                        <tr>
                            <td class="lang-label">{{ $lang->language }}</td>
                            <td style="color: #718096;">{{ $lang->proficiency }}</td>
                        </tr>
                        @endforeach
                    </table>
                </td>
                @endif

                @if(!empty($cv->certificates))
                <td width="50%">
                    <div class="section-title">Certifications</div>
                    @foreach($cv->certificates as $cert)
                        <div style="margin-bottom: 5px;">
                            <div style="font-size: 8.5pt; font-weight: bold;">{{ $cert->name }}</div>
                            <div style="font-size: 8pt; color: #718096;">{{ $cert->organization }} ({{ $cert->start_year }})</div>
                        </div>
                    @endforeach
                </td>
                @endif
            </tr>
        </table>

    </div>
</div>

</body>
</html>
@endsection