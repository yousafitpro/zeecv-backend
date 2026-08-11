<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resume - Muhammad Yousaf</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        @page {
            size: A4;
            margin: 0;
        }

        /* Root Container */
        .zeecv_pdf_outer {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background-color: #ffffff !important;
            font-family: 'Inter', sans-serif;
            color: #333333;
            padding: 0;
            box-sizing: border-box;
        }

        .zeecv_pdf_outer table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        /* Header Style - Blush Background */
        .zeecv_pdf_outer .header-area {
            background-color: #fdf2f4;
            padding: 30px 40px;
            text-align: center;
        }

        .zeecv_pdf_outer .name-title {
            font-size: 24pt;
            font-weight: 700;
            color: #000000;
            margin: 0 0 5px 0;
            letter-spacing: -0.5px;
        }

        .zeecv_pdf_outer .job-subtitle {
            font-size: 11pt;
            color: #b85c74;
            font-weight: 500;
            margin-bottom: 25px;
        }

        /* Contact Grid */
        .zeecv_pdf_outer .contact-grid td {
            padding: 5px 10px;
            font-size: 9pt;
            color: #444;
            vertical-align: middle;
        }

        .zeecv_pdf_outer .contact-icon {
            color: #b85c74;
            width: 25px;
            height: 25px;
            background: #fff;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
            font-size: 8pt;
            border: 1px solid #f2d7dd;
        }

        /* Section Banner */
        .zeecv_pdf_outer .section-banner {
            background-color: #b85c74;
            color: #ffffff;
            padding: 6px 20px;
            font-size: 11pt;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 25px 0 15px 0;
            width: fit-content;
            min-width: 180px;
        }

        .zeecv_pdf_outer .content-padding {
            padding: 0 40px 30px 40px;
        }

        /* Experience/Education Tables */
        .zeecv_pdf_outer .entry-table td {
            vertical-align: top;
            padding-bottom: 15px;
        }

        .zeecv_pdf_outer .entry-title {
            font-size: 10pt;
            font-weight: 700;
            color: #000;
        }

        .zeecv_pdf_outer .entry-company {
            font-size: 9.5pt;
            color: #718096;
            margin: 2px 0;
        }

        .zeecv_pdf_outer .entry-date {
            text-align: right;
            font-size: 9pt;
            color: #333;
            font-weight: 500;
        }

        /* Bullet Points */
        .zeecv_pdf_outer .bullet-list {
            margin: 5px 0 0 0;
            padding-left: 18px;
            list-style-type: disc;
        }

        .zeecv_pdf_outer .bullet-list li {
            font-size: 9pt;
            line-height: 1.5;
            color: #4a5568;
            margin-bottom: 4px;
        }

        /* Summary Text */
        .zeecv_pdf_outer .summary-box {
            font-size: 9.5pt;
            line-height: 1.6;
            color: #333;
            text-align: justify;
        }

        /* Skills - Pill Style */
        .zeecv_pdf_outer .skills-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 5px;
        }

        .zeecv_pdf_outer .skill-pill {
            background-color: #f7fafc;
            border: 1px solid #e2e8f0;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 8.5pt;
            color: #2d3748;
            font-weight: 500;
        }

        /* Languages - Progress Bar Style */
        .zeecv_pdf_outer .lang-item {
            width: 48%;
            margin-bottom: 15px;
        }

        .zeecv_pdf_outer .lang-name {
            font-size: 9pt;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }

        .zeecv_pdf_outer .lang-bar {
            height: 6px;
            background: #edf2f7;
            border-radius: 3px;
            overflow: hidden;
        }

        .zeecv_pdf_outer .lang-progress {
            height: 100%;
            background: #b85c74;
            border-radius: 3px;
        }
    </style>
</head>
<body>

<div class="zeecv_pdf_outer">
    <!-- HEADER -->
    <div class="header-area">
        <h1 class="name-title">{{ $cv->contact->first_name }} {{ $cv->contact->last_name }}</h1>
        <div class="job-subtitle">{{ $cv->contact->desired_job_title }}</div>

        <table class="contact-grid">
            <tr>
                <td width="50%">
                    <span class="contact-icon"><i class="fa fa-envelope"></i></span> 
                    {{ $cv->contact->email }}
                </td>
                <td width="50%">
                    <span class="contact-icon"><i class="fa fa-map-marker-alt"></i></span> 
                    {{ $cv->contact->location }}, {{ $cv->contact->country }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="contact-icon"><i class="fa fa-phone"></i></span> 
                    {{ $cv->contact->phone }}
                </td>
                <td>
                    <span class="contact-icon"><i class="fab fa-linkedin-in"></i></span> 
                    {{ str_replace(['https://', 'www.'], '', $cv->contact->profile_link) }}
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

        <!-- WORK EXPERIENCE -->
        @if(!empty($cv->experiences))
            <div class="section-banner">Work Experience</div>
            @foreach($cv->experiences as $exp)
                <table class="entry-table">
                    <tr>
                        <td>
                            <div class="entry-title">{{ $exp->job_title }}</div>
                            <div class="entry-company">{{ $exp->company }} • {{ $exp->location }}</div>
                        </td>
                        <td class="entry-date" width="160px">
                            {{ $exp->start_month }}/{{ $exp->start_year }} – {{ $exp->is_present ? 'Present' : $exp->end_month.'/'.$exp->end_year }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <ul class="bullet-list">
                                @foreach(explode("\n", str_replace('•', '', $exp->description)) as $bullet)
                                    @if(trim($bullet) !== '')
                                        <li>{{ trim($bullet) }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                </table>
            @endforeach
        @endif

        <!-- EDUCATION -->
        @if(!empty($cv->educations))
            <div class="section-banner">Education</div>
            @foreach($cv->educations as $edu)
                <table class="entry-table">
                    <tr>
                        <td>
                            <div class="entry-title">{{ $edu->degree }}</div>
                            <div class="entry-company">{{ $edu->institution }} • {{ $edu->location }}</div>
                        </td>
                        <td class="entry-date" width="160px">
                            {{ $edu->start_month }}/{{ $edu->start_year }} – {{ $edu->end_month }}/{{ $edu->end_year }}
                        </td>
                    </tr>
                </table>
            @endforeach
        @endif

        <!-- SKILLS -->
        @if(!empty($cv->skills))
            <div class="section-banner">Skills</div>
            <div class="skills-container">
                @foreach($cv->skills as $skill)
                    <div class="skill-pill">{{ is_object($skill) ? $skill->skill : $skill }}</div>
                @endforeach
            </div>
        @endif

        <!-- LANGUAGES -->
        @if(!empty($cv->languages))
            <div class="section-banner">Languages</div>
            <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                @foreach($cv->languages as $lang)
                    <div class="lang-item">
                        <div class="lang-name">
                            <span>{{ $lang->language }}</span>
                            <span style="color: #718096; font-weight: 400;">{{ $lang->proficiency }}</span>
                        </div>
                        <div class="lang-bar">
                            <div class="lang-progress" style="width: {{ str_contains(strtolower($lang->proficiency), 'native') ? '100%' : '75%' }}"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- CERTIFICATES -->
        @if(!empty($cv->certificates))
            <div class="section-banner">Certificates</div>
            @foreach($cv->certificates as $cert)
                <table class="entry-table" style="margin-bottom: 5px;">
                    <tr>
                        <td>
                            <div class="entry-title">{{ $cert->name }}</div>
                            <div class="entry-company">{{ $cert->organization }}</div>
                        </td>
                        <td class="entry-date" width="100px">
                            {{ $cert->start_month }}/{{ $cert->start_year }}
                        </td>
                    </tr>
                </table>
            @endforeach
        @endif
    </div>
</div>

</body>
</html>