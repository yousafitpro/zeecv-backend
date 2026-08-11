<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Professional Resume - Muhammad Yousaf</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        /* PDF specific resets */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        @page {
            size: A4;
            margin: 0;
        }

        /* Namespace everything under .zeecv_pdf_outer */
        .zeecv_pdf_outer {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background-color: #ffffff !important;
            font-family: 'Inter', sans-serif;
            color: #2d3748;
            padding: 0;
            box-sizing: border-box;
            position: relative;
        }

        .zeecv_pdf_outer table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .zeecv_pdf_outer td {
            vertical-align: top;
            padding: 0;
        }

        /* Top Header Style */
        .zeecv_pdf_outer .resume-header {
            background-color: #1a202c;
            color: #ffffff;
            padding: 30px 40px;
        }

        .zeecv_pdf_outer .header-name {
            font-size: 26pt;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
            line-height: 1;
        }

        .zeecv_pdf_outer .header-tagline {
            font-size: 11pt;
            color: #63b3ed;
            font-weight: 600;
            margin-top: 5px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .zeecv_pdf_outer .contact-bar {
            margin-top: 15px;
            border-top: 1px solid #4a5568;
            padding-top: 10px;
        }

        .zeecv_pdf_outer .contact-item {
            font-size: 8.5pt;
            color: #cbd5e0;
            display: inline-block;
            margin-right: 15px;
        }

        .zeecv_pdf_outer .contact-item i {
            color: #63b3ed;
            margin-right: 4px;
        }

        /* Sidebar Column */
        .zeecv_pdf_outer .sidebar-col {
            background-color: #f8fafc;
            width: 32%;
            padding: 20px;
            border-right: 1px solid #e2e8f0;
        }

        /* Main Content Column */
        .zeecv_pdf_outer .main-col {
            width: 68%;
            padding: 20px 30px;
        }

        /* Section Headings */
        .zeecv_pdf_outer .section-title {
            font-size: 11pt;
            font-weight: 800;
            color: #2c5282;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
            margin-top: 20px;
            display: block;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 4px;
        }

        .zeecv_pdf_outer .sidebar-title {
            font-size: 10pt;
            font-weight: 700;
            color: #1a202c;
            text-transform: uppercase;
            margin-bottom: 10px;
            margin-top: 25px;
            display: block;
        }

        /* Content Styles */
        .zeecv_pdf_outer .profile-summary {
            font-size: 9pt;
            line-height: 1.5;
            color: #4a5568;
            text-align: justify;
        }

        .zeecv_pdf_outer .exp-item {
            margin-bottom: 18px;
        }

        .zeecv_pdf_outer .job-title {
            font-size: 10pt;
            font-weight: 700;
            color: #1a202c;
        }

        .zeecv_pdf_outer .company-line {
            font-size: 9pt;
            font-weight: 600;
            color: #3182ce;
            margin: 2px 0;
        }

        .zeecv_pdf_outer .date-loc {
            font-size: 8pt;
            color: #718096;
            margin-bottom: 6px;
            font-weight: 500;
        }

        .zeecv_pdf_outer .bullet-list {
            margin: 5px 0 0 15px;
            padding: 0;
        }

        .zeecv_pdf_outer .bullet-list li {
            font-size: 8.5pt;
            line-height: 1.4;
            color: #4a5568;
            margin-bottom: 3px;
        }

        /* Skill Pills */
        .zeecv_pdf_outer .skill-tag {
            display: inline-block;
            background-color: #edf2f7;
            color: #2d3748;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 7.5pt;
            font-weight: 600;
            margin-bottom: 5px;
            margin-right: 3px;
            border: 1px solid #cbd5e0;
        }

        /* Certification / Education small items */
        .zeecv_pdf_outer .side-item {
            margin-bottom: 12px;
        }

        .zeecv_pdf_outer .side-item-title {
            font-size: 8.5pt;
            font-weight: 700;
            color: #2d3748;
            line-height: 1.2;
        }

        .zeecv_pdf_outer .side-item-sub {
            font-size: 8pt;
            color: #718096;
            line-height: 1.2;
        }

        .zeecv_pdf_outer .side-item-date {
            font-size: 7.5pt;
            font-weight: 600;
            color: #3182ce;
        }
    </style>
</head>
<body>

<div class="zeecv_pdf_outer">
    <!-- HEADER -->
    <div class="resume-header">
        <h1 class="header-name">{{ $cv->contact->first_name }} {{ $cv->contact->last_name }}</h1>
        <div class="header-tagline">{{ $cv->contact->desired_job_title }}</div>
        
        <div class="contact-bar">
            @if(!empty($cv->contact->email))
                <span class="contact-item"><i class="fa fa-envelope"></i> {{ $cv->contact->email }}</span>
            @endif
            @if(!empty($cv->contact->phone))
                <span class="contact-item"><i class="fa fa-phone"></i> {{ $cv->contact->phone }}</span>
            @endif
            @if(!empty($cv->contact->location))
                <span class="contact-item"><i class="fa fa-map-marker-alt"></i> {{ $cv->contact->location }}, {{ $cv->contact->country }}</span>
            @endif
            @if(!empty($cv->contact->profile_link))
                <span class="contact-item"><i class="fa fa-link"></i> {{ str_replace(['https://', 'http://'], '', $cv->contact->profile_link) }}</span>
            @endif
        </div>
    </div>

    <table>
        <tr>
            <!-- SIDEBAR COLUMN -->
            <td class="sidebar-col">
                <!-- SKILLS -->
                @if (!empty($cv->skills))
                    <span class="sidebar-title">Core Competencies</span>
                    <div style="margin-top: 10px;">
                        @foreach ($cv->skills as $skillItem)
                            <span class="skill-tag">{{ is_object($skillItem) ? $skillItem->skill : $skillItem }}</span>
                        @endforeach
                    </div>
                @endif

                <!-- CERTIFICATIONS -->
                @if (!empty($cv->certificates))
                    <span class="sidebar-title">Certifications</span>
                    @foreach ($cv->certificates as $cert)
                        <div class="side-item">
                            <div class="side-item-title">{{ $cert->name }}</div>
                            <div class="side-item-sub">{{ $cert->organization }}</div>
                            <div class="side-item-date">{{ $cert->start_month }}/{{ $cert->start_year }}</div>
                        </div>
                    @endforeach
                @endif

                <!-- LANGUAGES -->
                @if (!empty($cv->languages))
                    <span class="sidebar-title">Languages</span>
                    @foreach ($cv->languages as $lang)
                        <div class="side-item">
                            <div class="side-item-title">{{ $lang->language }}</div>
                            <div class="side-item-sub">{{ $lang->proficiency }}</div>
                        </div>
                    @endforeach
                @endif
            </td>

            <!-- MAIN CONTENT COLUMN -->
            <td class="main-col">
                <!-- PROFILE -->
                @if (!empty($cv->summary->summary))
                    <span class="section-title" style="margin-top: 0;">Professional Profile</span>
                    <div class="profile-summary">
                        {{ $cv->summary->summary }}
                    </div>
                @endif

                <!-- EXPERIENCE -->
                @if (!empty($cv->experiences))
                    <span class="section-title">Professional Experience</span>
                    @foreach ($cv->experiences as $exp)
                        <div class="exp-item">
                            <div class="job-title">{{ $exp->job_title }}</div>
                            <div class="company-line">{{ $exp->company }}</div>
                            <div class="date-loc">
                                <i class="far fa-calendar-alt"></i> 
                                {{ $exp->start_month }}/{{ $exp->start_year }} – 
                                {{ $exp->is_present ? 'Present' : $exp->end_month.'/'.$exp->end_year }}
                                &nbsp;&nbsp;|&nbsp;&nbsp; 
                                <i class="fa fa-map-marker-alt"></i> {{ $exp->location }}
                            </div>
                            <ul class="bullet-list">
                                @foreach(explode("\n", str_replace('•', '', $exp->description)) as $bullet)
                                    @if(trim($bullet) !== '')
                                        <li>{{ trim($bullet) }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                @endif

                <!-- EDUCATION -->
                @if (!empty($cv->educations))
                    <span class="section-title">Education</span>
                    @foreach ($cv->educations as $edu)
                        <div class="exp-item">
                            <div class="job-title">{{ $edu->degree }}</div>
                            <div class="company-line" style="color: #4a5568;">{{ $edu->institution }}</div>
                            <div class="date-loc">{{ $edu->start_year }} — {{ $edu->end_year }} | {{ $edu->location }}</div>
                        </div>
                    @endforeach
                @endif
            </td>
        </tr>
    </table>
</div>

</body>
</html>