<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resume PDF</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        @page {
            size: A4;
            margin: 10mm 15mm;
            background-color: #ffffff;
        }

        .zeecv_pdf_outer {
            width: 100%;
            background-color: #ffffff !important;
            box-sizing: border-box;
            color: #222222;
            font-size: 9pt;
            line-height: 1.4;
        }

        .zeecv_pdf_outer *,
        .zeecv_pdf_outer *::before,
        .zeecv_pdf_outer *::after {
            box-sizing: border-box;
        }

        /* Top Header Styling */
        .zeecv_pdf_outer .resume-name {
            margin: 0 0 3px 0;
            font-size: 20pt;
            font-weight: 700;
            color: #1a365d;
            line-height: 1.1;
        }

        .zeecv_pdf_outer .resume-subtitle {
            margin: 0;
            font-size: 10pt;
            font-weight: 600;
            color: #333333;
            line-height: 1.3;
        }

        .zeecv_pdf_outer .contact-text {
            font-size: 8.5pt;
            color: #333333;
            text-align: right;
            line-height: 1.5;
        }

        .zeecv_pdf_outer .contact-text div {
            margin-bottom: 2px;
        }

        /* Summary Styling */
        .zeecv_pdf_outer .summary-container {
            margin-top: 10px;
            margin-bottom: 12px;
        }

        .zeecv_pdf_outer .summary-text {
            font-size: 8.5pt;
            color: #333333;
            line-height: 1.45;
            text-align: justify;
        }

        /* Bold Clean Section Headings */
        .zeecv_pdf_outer .section-heading {
            font-size: 11pt;
            font-weight: 700;
            color: #1a365d;
            border-bottom: 1px solid #1a365d;
            padding-bottom: 2px;
            margin-top: 10px;
            margin-bottom: 8px;
            text-transform: capitalize;
        }

        /* Job & Entry Title Layout */
        .zeecv_pdf_outer .entry-title {
            font-size: 9.5pt;
            font-weight: 700;
            color: #111111;
        }

        .zeecv_pdf_outer .entry-subtitle {
            font-size: 9pt;
            font-weight: 600;
            color: #333333;
        }

        .zeecv_pdf_outer .entry-location {
            font-size: 8.5pt;
            color: #555555;
        }

        .zeecv_pdf_outer .entry-date {
            font-size: 8.5pt;
            font-weight: 600;
            color: #333333;
            text-align: right;
            vertical-align: top;
            white-space: nowrap;
        }

        .zeecv_pdf_outer .entry-description {
            font-size: 8.5pt;
            color: #333333;
            margin-top: 4px;
            line-height: 1.4;
        }

        .zeecv_pdf_outer .bullet-list {
            margin: 3px 0 0 0;
            padding-left: 14px;
        }

        .zeecv_pdf_outer .bullet-list li {
            margin-bottom: 3px;
            font-size: 8.5pt;
            line-height: 1.35;
        }

        /* Skills Layout */
        .zeecv_pdf_outer .skills-table td {
            font-size: 8.5pt;
            padding-bottom: 4px;
            vertical-align: top;
        }

        .zeecv_pdf_outer .skills-category {
            font-weight: 700;
            color: #1a365d;
            width: 120px;
        }

        .zeecv_pdf_outer table {
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <div class="zeecv_pdf_outer">
        <div id="resumePrintDive" class="resumePrintDiveInner">

            <!-- HEADER SECTION -->
            <table width="100%" cell-spacing="0" cell-padding="0">
                <tr>
                    <td width="65%" style="vertical-align: top;">
                        <h1 class="resume-name">{{ $cv->contact->first_name . ' ' . $cv->contact->last_name }}</h1>
                        <p class="resume-subtitle">{{ $cv->contact->desired_job_title }}</p>
                    </td>
                    <td width="35%" class="contact-text" style="vertical-align: top;">
                        @if (!empty($cv->contact->email))
                            <div>{{ $cv->contact->email }}</div>
                        @endif
                        @if (!empty($cv->contact->phone) || !empty($cv->contact->location))
                            <div>
                                {{ implode(' | ', array_filter([
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
                <div class="summary-container">
                    <div class="section-heading">Summary</div>
                    <div class="summary-text">
                        {{ $cv->summary->summary }}
                    </div>
                </div>
            @endif

            <!-- WORK EXPERIENCE SECTION -->
            @if (!empty($cv->experiences) && count($cv->experiences) > 0)
                <div class="section-heading">Work Experience</div>

                <table width="100%" cell-spacing="0" cell-padding="0">
                    @foreach ($cv->experiences as $exp)
                        <tr>
                            <td style="padding-bottom: 8px; vertical-align: top;">
                                <div class="entry-title">
                                    {{ $exp->job_title }}
                                    @if (!empty($exp->company))
                                        <span class="entry-subtitle">, {{ $exp->company }}</span>
                                    @endif
                                    @if (!empty($exp->location) || !empty($exp->country))
                                        <span class="entry-location">, {{ implode(', ', array_filter([$exp->location, $exp->country])) }}</span>
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
                            <td class="entry-date" width="130" style="padding-bottom: 8px;">
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
                            <td style="padding-bottom: 6px; vertical-align: top;">
                                <div class="entry-title">{{ $edu->degree }}</div>
                                <div class="entry-subtitle">
                                    {{ $edu->institution }}
                                    @if(!empty($edu->location) || !empty($edu->country))
                                        <span class="entry-location">, {{ implode(', ', array_filter([$edu->location ?? '', $edu->country ?? ''])) }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="entry-date" width="130" style="padding-bottom: 6px;">
                                {{ $edu->start_month }}/{{ $edu->start_year }} – {{ $edu->end_month }}/{{ $edu->end_year }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif

            <!-- SKILLS SECTION -->
            @if (!empty($cv->skills) && count($cv->skills) > 0)
                <div class="section-heading">Skills</div>
                <div style="padding-top: 2px; padding-bottom: 4px;">
                    <table width="100%" class="skills-table">
                        <tr>
                            <td>
                                {{ implode(' | ', array_column($cv->skills->toArray(), 'skill')) }}
                            </td>
                        </tr>
                    </table>
                </div>
            @endif

            <!-- LANGUAGES SECTION -->
            @if (!empty($cv->languages) && count($cv->languages) > 0)
                <div class="section-heading">Languages</div>
                <div style="padding-top: 2px; padding-bottom: 4px;">
                    <table width="100%" class="skills-table">
                        <tr>
                            @foreach ($cv->languages as $lang)
                                <td style="padding-right: 15px; width: auto;">
                                    <strong>{{ $lang->language }}</strong> @if(!empty($lang->proficiency))({{ $lang->proficiency }})@endif
                                </td>
                            @endforeach
                        </tr>
                    </table>
                </div>
            @endif

            <!-- CERTIFICATES SECTION -->
            @if (!empty($cv->certificates) && count($cv->certificates) > 0)
                <div class="section-heading">Certificates</div>

                <table width="100%" cell-spacing="0" cell-padding="0">
                    @foreach ($cv->certificates as $cert)
                        <tr>
                            <td style="padding-bottom: 4px; vertical-align: top;">
                                <div class="entry-title">{{ $cert->name }}<span class="entry-subtitle">, {{ $cert->organization }}</span></div>
                            </td>
                            <td class="entry-date" width="130" style="padding-bottom: 4px;">
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