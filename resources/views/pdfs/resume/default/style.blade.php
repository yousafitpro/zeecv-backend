    @php
    $interPath = asset('fonts/Montserrat-Open-Sans/Inter/static');
    @endphp

    <style>
        :root{
            --pdf-primary-color:#c7885c;
            --pdf-primary-text-color:#333333;
            --pdf-heading-text-color:#333333;
            --pdf-muted-text-color:#797777;
            --pdf-full-muted-text-color:#a8a6a6;
            --pdf-sub-text-color:var(--pdf-primary-color);
            --pdf-font-primary:'Montserrat', sans-serif;
            --pdf-font-secondary:'Inter', sans-serif;
        }
         @font-face {
        font-family: 'Montserrat';
        src: url('{{ asset("fonts/Montserrat-Open-Sans/Montserrat/static/Montserrat-Regular.ttf") }}') format('truetype');
        font-weight: 400;
        font-style: normal;
        }

        @font-face {
            font-family: 'Montserrat';
            src: url('{{ asset("fonts/Montserrat-Open-Sans/Montserrat/static/Montserrat-SemiBold.ttf") }}') format('truetype');
            font-weight: 600;
            font-style: normal;
        }

        @font-face {
            font-family: 'Montserrat';
            src: url('{{ asset("fonts/Montserrat-Open-Sans/Montserrat/static/Montserrat-Bold.ttf") }}') format('truetype');
            font-weight: 700;
            font-style: normal;
        }

        @font-face {
            font-family: 'Montserrat';
            src: url('{{ asset("fonts/Montserrat-Open-Sans/Montserrat/static/Montserrat-ExtraBold.ttf") }}') format('truetype');
            font-weight: 800;
            font-style: normal;
        }
        
        // Inter Font
            @font-face {
                font-family: 'Inter';
                src: url('{{ $interPath }}/Inter_18pt-Regular.ttf') format('truetype');
                font-weight: 400;
                font-style: normal;
            }

            @font-face {
                font-family: 'Inter';
                src: url('{{ $interPath }}/Inter_18pt-Medium.ttf') format('truetype');
                font-weight: 500;
                font-style: normal;
            }

            @font-face {
                font-family: 'Inter';
                src: url('{{ $interPath }}/Inter_18pt-SemiBold.ttf') format('truetype');
                font-weight: 600;
                font-style: normal;
            }

            @font-face {
                font-family: 'Inter';
                src: url('{{ $interPath }}/Inter_18pt-Bold.ttf') format('truetype');
                font-weight: 700;
                font-style: normal;
            }

        /* PDF Page Setup */
        @page {
            margin: 25px 30px;
        }

        body {
            font-family: var(--pdf-font-primary);
            color: var(--pdf-primary-text-color);
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
            font-family: var(--pdf-font-primary);
            font-size: 28px;
            font-weight: 700;
            color: var(--pdf-heading-text-color);
            margin: 0 0 3px 0;
        }

        .resume-subtitle {
            font-size: 12px;
            font-family: var(--pdf-font-secondary);
            color: var(--pdf-sub-text-color);
            margin: 0;
        }

        .contact-text i{
          color: var(--pdf-primary-color);
          font-size: 12px;
          margin-left: 5px;
          margin-top: 5px;
        }
        .contact-text {
            font-family: var(--pdf-font-secondary);
            font-weight: 400;
            font-size:9px;
            color: var(--pdf-muted-text-color);
            text-align: right;
            line-height: 1.5;
        }

        .section-heading {
            font-family: var(--pdf-font-primary);
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--pdf-font-primary);
            border-bottom: 2px solid var(--pdf-primary-color);
            padding-bottom: 4px;
            margin-top: 15px;
            margin-bottom: 12px;
        }

        .summary-text {
            font-size: 10px;
            color: var(--pdf-muted-text-color);
            font-family: var(--pdf-font-secondary);
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
            width: 8px;
            height: 8px;
            border: 3px solid var(--pdf-primary-color);
            border-radius: 50%;
            background-color: #ffffff;
            margin-top: 2px;
        }

        .timeline-line-cell {
            /* width: 16px;
            background: url('data:image/png;base64,iVBORw0KGgoAAAANSUheader...') repeat-y center;
            border-right: 1px solid var(--pdf-primary-color); */
        }

        .entry-title {
            font-family: var(--pdf-font-secondary);
            font-size: 11px;
            font-weight: 700;
            color: var(--pdf-primary-text-color);
            margin: 0;
        }

        .entry-subtitle {
            font-size: 10px;
            font-style: italic;
            color: var(--pdf-muted-text-color);
            font-family: var(--pdf-font-secondary);
            margin: 2px 0;
        }

        .entry-location {
            font-size: 9.5px;
            font-family: var(--pdf-font-secondary);
            color: var(--pdf-primary-color);
            margin: 0 0 2px 0;
        }
        .entry-description {
            font-size: 10px;
            color: var(--pdf-muted-text-color);
            font-family: var(--pdf-font-secondary);
            line-height: 1.5;
            margin-bottom: 12px;
            border-left: dotted 3px var(--pdf-primary-color);
            padding-left:5px;
            margin-top:10px;
        }

        .entry-date {
            font-size: 10px;
            font-style: italic;
            font-weight: 400;
            font-family: var(--pdf-font-secondary);
            color: var(--pdf-primary-color);
            text-align: right;
            white-space: nowrap;
        }

        /* Skills Pill Layout */
        .skill-pill {
            background-color: var(--pdf-primary-color);
            font-family: var(--pdf-font-secondary);
            font-weight: 500;
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