<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Marketing Resume PDF</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        @page {
            size: A4;
            margin: 0;
            background-color: #ffffff;
        }

        /* STRICTLY SCOPED CSS - Dompdf & PDF Safe */
        .zeecv_pdf_outer {
            width: 88%;
            /* max-width: 800px; */
            margin: 0 auto;
            background-color: #ffffff !important;
            box-sizing: border-box;
            color: #1e293b;
            font-size: 8.5pt;
            line-height: 1.45;
            /* padding: 10mm 12mm; */
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .zeecv_pdf_outer,
        .zeecv_pdf_outer * {
            font-family: 'Plus Jakarta Sans', Arial, sans-serif !important;
            box-sizing: border-box;
        }

        .zeecv_pdf_outer table {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
        }

        /* --- Dompdf-Safe Header Banner (Solid Backgrounds) --- */
        .zeecv_pdf_outer .marketing-header-card {
            background-color: #0f172a !important; /* Solid color instead of linear-gradient */
            border-left: 6px solid #ff4757;
            padding: 14px 18px;
            margin-bottom: 12px;
        }

        .zeecv_pdf_outer .resume-name {
            margin: 0 0 3px 0;
            font-size: 20pt;
            font-weight: 800;
            color: #ffffff !important;
            line-height: 1.1;
            text-transform: uppercase;
        }

        .zeecv_pdf_outer .resume-subtitle {
            margin: 0;
            font-size: 9.5pt;
            font-weight: 700;
            color: #ff6b81 !important;
            line-height: 1.2;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }

        .zeecv_pdf_outer .contact-text {
            font-size: 8pt;
            color: #e2e8f0 !important;
            text-align: right;
            line-height: 1.65;
            font-weight: 500;
            word-wrap: break-word;
        }

        .zeecv_pdf_outer .contact-symbol {
            color: #ffa502 !important;
            font-weight: bold;
            font-style: normal;
        }

        /* --- Section Titles --- */
        .zeecv_pdf_outer .section-heading {
            font-size: 9.5pt;
            font-weight: 800;
            color: #0f172a;
            border-bottom: 2px solid #ff4757;
            padding-bottom: 3px;
            margin-top: 12px;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* --- Executive Summary Highlight Block --- */
        .zeecv_pdf_outer .summary-box {
            background-color: #fff5f5 !important;
            border-left: 3px solid #ff4757;
            padding: 8px 12px;
            margin-bottom: 8px;
        }

        .zeecv_pdf_outer .summary-text {
            font-size: 8.5pt;
            color: #334155;
            line-height: 1.45;
            text-align: justify;
        }

        /* --- Experience & Education --- */
        .zeecv_pdf_outer .entry-title {
            font-size: 9pt;
            font-weight: 800;
            color: #0f172a;
            word-wrap: break-word;
        }

        .zeecv_pdf_outer .entry-subtitle {
            font-size: 8.5pt;
            font-weight: 700;
            color: #ff4757;
        }

        .zeecv_pdf_outer .entry-location {
            font-size: 8pt;
            color: #64748b;
            font-style: italic;
            font-weight: 500;
        }

        .zeecv_pdf_outer .entry-date {
            font-size: 8pt;
            font-weight: 700;
            color: #475569;
            text-align: right;
            vertical-align: top;
            white-space: nowrap;
        }

        .zeecv_pdf_outer .bullet-list {
            margin: 4px 0 0 0;
            padding-left: 14px;
        }

        .zeecv_pdf_outer .bullet-list li {
            margin-bottom: 3px;
            font-size: 8.5pt;
            line-height: 1.35;
            color: #334155;
        }

        /* --- Table-Based Skill Badges (No Flexbox) --- */
        .zeecv_pdf_outer .skill-badge {
            background-color: #f1f5f9 !important;
            color: #0f172a;
            border: 1px solid #cbd5e1;
            border-left: 3px solid #ffa502;
            padding: 3px 7px;
            font-weight: 700;
            font-size: 7.8pt;
            display: inline-block;
            margin-right: 4px;
            margin-bottom: 5px;
        }

        /* --- Languages --- */
        .zeecv_pdf_outer .lang-table td {
            font-size: 8.5pt;
            padding-bottom: 4px;
        }

        .zeecv_pdf_outer .lang-title {
            font-weight: 700;
            color: #0f172a;
        }

        .zeecv_pdf_outer .lang-prof {
            color: #64748b;
            font-size: 8pt;
        }
    </style>
</head>
<body>
    <div class="zeecv_pdf_outer">
        <div id="resumePrintDive" class="resumePrintDiveInner">

            <!-- HEADER BANNER SECTION -->
            <div class="marketing-header-card">
                <table class="header-table" cell-spacing="0" cell-padding="0" width="100%">
                    <tr>
                        <td width="55%" style="vertical-align: middle;">
                            <h1 class="resume-name">{{ $cv->contact->first_name . ' ' . $cv->contact->last_name }}</h1>
                            <p class="resume-subtitle">{{ $cv->contact->desired_job_title }}</p>
                        </td>
                        <td width="45%" class="contact-text" style="vertical-align: middle;">
                            @if (!empty($cv->contact->email))
                                <div><span class="contact-symbol">@</span> {{ $cv->contact->email }}</div>
                            @endif
                            @if (!empty($cv->contact->phone) || !empty($cv->contact->location))
                                <div>
                                    <span class="contact-symbol">&#9992;</span> 
                                    {{ implode(', ', array_filter([
                                        $cv->contact->location ?? '',
                                        $cv->contact->country ?? ''
                                    ])) }}
                                    @if(!empty($cv->contact->phone))
                                        &nbsp;|&nbsp; <span class="contact-symbol">&#9742;</span> {{ $cv->contact->phone }}
                                    @endif
                                </div>
                            @endif
                            @if (!empty($cv->contact->profile_link))
                                <div><span class="contact-symbol">&#127760;</span> {{ $cv->contact->profile_link }}</div>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <!-- SUMMARY SECTION -->
            @if (!empty($cv->summary->summary))
                <div class="section-heading">Executive Profile</div>
                <div class="summary-box">
                    <div class="summary-text">
                        {{ $cv->summary->summary }}
                    </div>
                </div>
            @endif

            <!-- WORK EXPERIENCE SECTION -->
            @if (!empty($cv->experiences) && count($cv->experiences) > 0)
                <div class="section-heading">Campaign & Professional Experience</div>

                <table width="100%" cell-spacing="0" cell-padding="0">
                    @foreach ($cv->experiences as $exp)
                        <tr>
                            <td width="72%" style="padding-bottom: 10px; vertical-align: top;">
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
                            <td class="entry-date" width="28%" style="padding-bottom: 10px;">
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
                            <td width="72%" style="padding-bottom: 8px; vertical-align: top;">
                                <div class="entry-title">{{ $edu->degree }}</div>
                                <div class="entry-subtitle">
                                    {{ $edu->institution }}
                                    @if(!empty($edu->location) || !empty($edu->country))
                                        <span class="entry-location">, {{ implode(', ', array_filter([$edu->location ?? '', $edu->country ?? ''])) }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="entry-date" width="28%" style="padding-bottom: 8px;">
                                {{ $edu->start_month }}/{{ $edu->start_year }} – {{ $edu->end_month }}/{{ $edu->end_year }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif

            <!-- SKILLS SECTION -->
            @if (!empty($cv->skills) && count($cv->skills) > 0)
                <div class="section-heading">Core Marketing Competencies</div>
                <div style="padding-top:2px; padding-bottom:2px;">
                    @foreach ($cv->skills as $skillItem)
                        <span class="skill-badge">{{ is_object($skillItem) ? $skillItem->skill : $skillItem }}</span>
                    @endforeach
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
                            <td width="72%" style="padding-bottom: 6px; vertical-align: top;">
                                <div class="entry-title">{{ $cert->name }} <span class="entry-subtitle">| {{ $cert->organization }}</span></div>
                            </td>
                            <td class="entry-date" width="28%" style="padding-bottom: 6px;">
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