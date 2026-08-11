<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resume - Muhammad Yousaf</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        /* DomPDF does not like Flexbox. We use Table and Inline-block for stability. */
        @page {
            size: A4;
            margin: 0;
        }

        .zeecv_pdf_outer {
            width: 100%;
            margin: 0;
            padding: 0;
            background-color: #ffffff !important;
            font-family: sans-serif; /* Standard font is safer for DomPDF array errors */
            color: #333333;
        }

        .zeecv_pdf_outer table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        /* --- HEADER AREA --- */
        .zeecv_pdf_outer .header-area {
            background-color: #fdf2f4; /* Light blush */
            padding: 30px 40px;
            text-align: center;
        }

        .zeecv_pdf_outer .name-title {
            font-size: 26pt;
            font-weight: bold;
            color: #000000;
            margin: 0;
            padding-bottom: 5px;
        }

        .zeecv_pdf_outer .job-subtitle {
            font-size: 12pt;
            color: #b85c74;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* Circular Contact Icons */
        .zeecv_pdf_outer .contact-table td {
            padding: 8px 10px;
            font-size: 9pt;
            vertical-align: middle;
            text-align: left;
        }

        .zeecv_pdf_outer .icon-circle {
            background-color: #ffffff;
            color: #b85c74;
            border: 1px solid #eecad3;
            border-radius: 28px;
            width: 28px;
            height: 28px;
            line-height: 28px;
            display: inline-block;
            text-align: center;
            margin-right: 10px;
            font-size: 10pt;
            padding-top:6px; 
        }

        /* --- CONTENT BODY --- */
        .zeecv_pdf_outer .content-padding {
            padding: 20px 45px;
        }

        /* Full Width Maroon Banner */
        .zeecv_pdf_outer .section-banner {
            background-color: #b85c74;
            color: #ffffff;
            padding: 8px 20px;
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 20px 0 15px 0;
        }

        .zeecv_pdf_outer .summary-box {
            font-size: 9.5pt;
            line-height: 1.6;
            color: #333;
            text-align: justify;
        }

        /* --- ENTRIES (Experience/Education) --- */
        .zeecv_pdf_outer .entry-table td {
            vertical-align: top;
            padding-bottom: 4px;
        }

        .zeecv_pdf_outer .entry-title {
            font-size: 10.5pt;
            font-weight: bold;
            color: #000;
        }

        .zeecv_pdf_outer .entry-date {
            text-align: right;
            font-size: 9pt;
            color: #444;
            font-weight: bold;
        }

        .zeecv_pdf_outer .entry-company {
            font-size: 9.5pt;
            color: #718096;
            margin-bottom: 8px;
        }

        .zeecv_pdf_outer .bullet-list {
            margin: 0 0 15px 0;
            padding-left: 20px;
        }

        .zeecv_pdf_outer .bullet-list li {
            font-size: 9pt;
            line-height: 1.5;
            color: #4a5568;
            margin-bottom: 5px;
        }

        /* --- SKILLS (Grid using Tables for DomPDF stability) --- */
        .zeecv_pdf_outer .skill-item {
            display: inline-block;
            background-color: #f7fafc;
            border: 1px solid #e2e8f0;
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 8.5pt;
            margin-right: 5px;
            margin-bottom: 8px;
            font-weight: 500;
        }

        /* --- LANGUAGES --- */
        .zeecv_pdf_outer .lang-table td {
            padding: 5px 0;
            font-size: 9pt;
        }
        
        .zeecv_pdf_outer .progress-bg {
            background-color: #edf2f7;
            height: 6px;
            width: 100%;
            border-radius: 3px;
        }

        .zeecv_pdf_outer .progress-fill {
            background-color: #b85c74;
            height: 6px;
            border-radius: 3px;
        }

    </style>
</head>
<body>

<div class="zeecv_pdf_outer">
    
    <!-- HEADER -->
    <div class="header-area">
        <div class="name-title">{{ $cv->contact->first_name }} {{ $cv->contact->last_name }}</div>
        <div class="job-subtitle">{{ $cv->contact->desired_job_title }}</div>

        <table class="contact-table">
            <tr>
                <td width="50%">
                    <span class="icon-circle"><i class="fa fa-envelope"></i></span>
                    {{ $cv->contact->email }}
                </td>
                <td width="50%">
                    <span class="icon-circle" ><i class="fa fa-map-marker-alt"></i></span>
                    {{ $cv->contact->location }}, {{ $cv->contact->country }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="icon-circle"><i class="fa fa-phone"></i></span>
                    {{ $cv->contact->phone }}
                </td>
                <td>
                    <span class="icon-circle"><i class="fab fa-linkedin-in"></i></span>
                    {{ str_replace(['https://','www.'], '', $cv->contact->profile_link) }}
                </td>
            </tr>
        </table>
    </div>

    <div class="content-padding">
        
        <!-- SUMMARY -->
        @if(!empty($cv->summary->summary))
            <div class="section-banner">Summary</div>
            <div class="summary-box">
                {{ $cv->summary->summary }}
            </div>
        @endif

        <!-- EXPERIENCE -->
        @if(!empty($cv->experiences))
            <div class="section-banner">Work Experience</div>
            @foreach($cv->experiences as $exp)
                <table class="entry-table">
                    <tr>
                        <td width="70%"><div class="entry-title">{{ $exp->job_title }}</div></td>
                        <td width="30%" class="entry-date">
                            {{ $exp->start_month }}/{{ $exp->start_year }} – {{ $exp->is_present ? 'Present' : $exp->end_month.'/'.$exp->end_year }}
                        </td>
                    </tr>
                </table>
                <div class="entry-company">{{ $exp->company }} • {{ $exp->location }}</div>
                
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
            <div class="section-banner">Education</div>
            @foreach($cv->educations as $edu)
                <table class="entry-table">
                    <tr>
                        <td width="75%">
                            <div class="entry-title">{{ $edu->degree }}</div>
                            <div class="entry-company" style="margin-bottom:0;">{{ $edu->institution }} • {{ $edu->location }}</div>
                        </td>
                        <td width="25%" class="entry-date">{{ $edu->start_year }} – {{ $edu->end_year }}</td>
                    </tr>
                </table>
                <div style="height: 10px;"></div>
            @endforeach
        @endif

        <!-- SKILLS -->
        @if(!empty($cv->skills))
            <div class="section-banner">Skills</div>
            <div style="padding-top: 5px;">
                @foreach($cv->skills as $skill)
                    <div class="skill-item">{{ is_object($skill) ? $skill->skill : $skill }}</div>
                @endforeach
            </div>
        @endif

        <!-- LANGUAGES -->
        @if(!empty($cv->languages))
            <div class="section-banner">Languages</div>
            <table>
                <tr>
                @foreach($cv->languages as $lang)
                    <td width="48%" style="padding-right: 20px;">
                        <table class="lang-table">
                            <tr>
                                <td><strong>{{ $lang->language }}</strong></td>
                                <td style="text-align: right; color: #718096;">{{ $lang->proficiency }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="progress-bg">
                                        <div class="progress-fill" style="width: {{ str_contains(strtolower($lang->proficiency), 'native') ? '100%' : '70%' }};"></div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                @endforeach
                </tr>
            </table>
        @endif

    </div>
</div>

</body>
</html>