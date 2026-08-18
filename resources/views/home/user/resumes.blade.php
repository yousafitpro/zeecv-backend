@extends('layout.home')

@section('title', "Resumes")

@section('content')

<style>
    #resumes_outer_div {
        background: #f8fafc;
        min-height: calc(100vh - 70px);
        padding: 35px 25px;
    }

    #resumes_outer_div .resumes-wrapper {
        width: 100%;
        max-width: 1600px;
        margin: 0 auto;
    }

    /* Header */
    #resumes_outer_div .resumes-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 25px;
        gap: 20px;
    }

    #resumes_outer_div .resumes-title {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        color: #0f172a;
        letter-spacing: -0.5px;
    }

    #resumes_outer_div .resumes-subtitle {
        margin: 6px 0 0;
        color: #64748b;
        font-size: 14px;
    }

    /* Main Container */
    #resumes_outer_div .resumes-container {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
    }

    /* Table */
    #resumes_outer_div .resumes-table {
        width: 100%;
        margin: 0;
        border-collapse: collapse;
    }

    #resumes_outer_div .resumes-table thead {
        background: #f8fafc;
    }

    #resumes_outer_div .resumes-table th {
        border: 0;
        border-bottom: 1px solid #e2e8f0;
        padding: 15px 22px;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        white-space: nowrap;
    }

    #resumes_outer_div .resumes-table td {
        border: 0;
        border-bottom: 1px solid #f1f5f9;
        padding: 18px 22px;
        vertical-align: middle;
        color: #334155;
        font-size: 14px;
    }

    #resumes_outer_div .resumes-table tbody tr {
        transition: background .15s ease;
    }

    #resumes_outer_div .resumes-table tbody tr:hover {
        background: #f8fafc;
    }

    #resumes_outer_div .resumes-table tbody tr:last-child td {
        border-bottom: 0;
    }

    /* Resume Info */
    #resumes_outer_div .resume-info {
        display: flex;
        align-items: center;
        min-width: 250px;
    }

    #resumes_outer_div .resume-icon {
        width: 42px;
        height: 42px;
        min-width: 42px;
        border-radius: 8px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        margin-right: 13px;
        overflow: hidden;
    }

    #resumes_outer_div .resume-icon img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
    }

    #resumes_outer_div .resume-name {
        font-weight: 600;
        color: #0f172a;
        font-size: 15px;
        margin-bottom: 3px;
    }

    #resumes_outer_div .resume-id {
        color: #94a3b8;
        font-size: 12px;
    }

    /* Status */
    #resumes_outer_div .resume-status {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        border-radius: 20px;
        background: #ecfdf5;
        color: #059669;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    #resumes_outer_div .resume-status-dot {
        width: 6px;
        height: 6px;
        background: #10b981;
        border-radius: 50%;
        margin-right: 6px;
    }

    /* Date / File Info */
    #resumes_outer_div .resume-date {
        color: #475569;
        font-size: 13px;
        white-space: nowrap;
    }

    #resumes_outer_div .resume-date i {
        color: #94a3b8;
        margin-right: 5px;
    }

    /* Actions */
    #resumes_outer_div .resume-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 7px;
        white-space: nowrap;
    }

    #resumes_outer_div .resume-action {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        background: #fff;
        color: #64748b;
        font-size: 14px;
        transition: all .2s ease;
        cursor: pointer;
    }

    #resumes_outer_div .resume-action:hover {
        background: #f8fafc;
        color: #2563eb;
        border-color: #bfdbfe;
        text-decoration: none;
    }

    #resumes_outer_div .resume-action.edit:hover {
        color: #2563eb;
        border-color: #bfdbfe;
        background: #eff6ff;
    }

    #resumes_outer_div .resume-action.preview:hover {
        color: #7c3aed;
        border-color: #ddd6fe;
        background: #f5f3ff;
    }

    #resumes_outer_div .resume-action.download:hover {
        color: #059669;
        border-color: #a7f3d0;
        background: #ecfdf5;
    }

    /* Upload Button */
    #resumes_outer_div .upload-resume-btn {
        border: 1px solid #2563eb;
        background: #2563eb;
        color: #fff;
        padding: 8px 15px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all .2s ease;
        white-space: nowrap;
    }

    #resumes_outer_div .upload-resume-btn:hover {
        background: #1d4ed8;
        border-color: #1d4ed8;
    }

    #resumes_outer_div .upload-resume-btn:disabled {
        opacity: .6;
        cursor: not-allowed;
    }

    #resumes_outer_div .upload-resume-btn i {
        margin-right: 5px;
    }

    /* Upload Submit */
    #resumes_outer_div .resume-action.upload-submit {
        color: #059669;
        border-color: #a7f3d0;
        background: #ecfdf5;
    }

    #resumes_outer_div .resume-action.upload-submit:hover {
        background: #d1fae5;
        border-color: #6ee7b7;
        color: #047857;
    }

    #resumes_outer_div .resume-action.upload-submit:disabled {
        opacity: .6;
        cursor: not-allowed;
    }

    /* Uploaded Resume Heading */
    #resumes_outer_div .resumes-upload-section {
        margin-top: 25px;
    }

    #resumes_outer_div .resumes-upload-title {
        font-size: 19px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 10px;
    }

    /* Empty */
    #resumes_outer_div .empty-state {
        text-align: center;
        padding: 80px 20px;
    }

    #resumes_outer_div .empty-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 18px;
        border-radius: 14px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    #resumes_outer_div .empty-title {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 7px;
    }

    #resumes_outer_div .empty-text {
        color: #64748b;
        font-size: 14px;
        margin-bottom: 22px;
    }

    /* Pagination */
    #resumes_outer_div .resumes-pagination {
        padding: 18px 22px;
        border-top: 1px solid #f1f5f9;
        background: #fff;
    }

    /* Mobile */
    @media (max-width: 767px) {

        #resumes_outer_div {
            padding: 25px 12px;
        }

        #resumes_outer_div .resumes-header {
            align-items: flex-start;
            flex-direction: column;
        }

        #resumes_outer_div .resumes-title {
            font-size: 24px;
        }

        #resumes_outer_div .resumes-container {
            overflow-x: auto;
        }

        #resumes_outer_div .resumes-table {
            min-width: 850px;
        }

        #resumes_outer_div .resumes-upload-title {
            font-size: 18px;
        }
    }
</style>


<div id="resumes_outer_div">

    <div class="resumes-wrapper">

        {{-- Header --}}
        <div class="resumes-header">

            <div>

                <h1 class="resumes-title">
                    My Resumes (Resume Builder)
                </h1>

                <p class="resumes-subtitle">
                    Manage, edit and download your professional resumes.
                </p>

            </div>

        </div>


        {{-- Resume Builder Resumes --}}
        <div class="resumes-container">

            @if(isset($resumes) && count($resumes) > 0)

                <table class="resumes-table">

                    <tbody>

                    @foreach($resumes as $resume)

                        <tr>

                            {{-- Resume --}}
                            <td>

                                <div class="resume-info">

                                    <div class="resume-icon">

                                        <img src="{{ auth()->user()->avatar() }}"
                                             alt="Profile">

                                    </div>

                                    <div>

                                        <div class="resume-name">

                                            {{ $resume->contact->first_name.' '.$resume->contact->last_name }}

                                        </div>

                                        <div class="resume-id">

                                            Resume #{{ unique_encrypt($resume->id) }}

                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- Status --}}
                            <td>

                                <span class="resume-status">

                                    <span class="resume-status-dot"></span>

                                    Active

                                </span>

                            </td>


                            {{-- Created --}}
                            <td>

                                @if(isset($resume->created_at))

                                    <span class="resume-date">

                                        <i class="fa fa-calendar-o"></i>

                                        {{ $resume->created_at->format('M d, Y') }}

                                    </span>

                                @else

                                    <span class="text-muted">—</span>

                                @endif

                            </td>


                            {{-- Updated --}}
                            <td>

                                @if(isset($resume->updated_at))

                                    <span class="resume-date">

                                        <i class="fa fa-clock-o"></i>

                                        {{ $resume->updated_at->format('M d, Y') }}

                                    </span>

                                @else

                                    <span class="text-muted">—</span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td>

                                <div class="resume-actions">

                                    {{-- Edit --}}
                                    <a href="{{ route('resume.edit', unique_encrypt($resume->id)) }}"
                                       class="resume-action edit"
                                       title="Edit Resume">

                                        <i class="fa fa-pencil"></i>

                                    </a>


                                    {{-- Preview --}}
                                    <a href="{{ route('resume.pdf.preview', unique_encrypt($resume->id)) }}"
                                       target="_blank"
                                       class="resume-action preview"
                                       title="Preview Resume">

                                        <i class="fa fa-eye"></i>

                                    </a>


                                    {{-- Download --}}
                                    <a href="{{ route('resume.pdf', unique_encrypt($resume->id)) }}"
                                       class="resume-action download"
                                       title="Download PDF">

                                        <i class="fa fa-download"></i>

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

            @else

                {{-- Empty Resume Builder --}}
                <div class="empty-state">

                    <div class="empty-icon">
                        <i class="fa fa-file-text-o"></i>
                    </div>

                    <div class="empty-title">
                        No Resumes Yet
                    </div>

                    <div class="empty-text">
                        You haven't created any resumes with the Resume Builder yet.
                    </div>

                </div>

            @endif

        </div>


        {{-- Uploaded Resumes --}}
        <div class="resumes-upload-section">

            <h4 class="resumes-upload-title">
                Uploaded Resumes
            </h4>


            <div class="resumes-container">

                <form action="{{ route('home.user.resume.custom.upload') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      id="custom_resume_upload_form">

                    @csrf

                    {{-- Hidden File Input --}}
                    <input type="file"
                           name="resume"
                           id="custom_resume_file"
                           accept=".pdf,.doc,.docx"
                           style="display: none;">

                    <table class="resumes-table">

                        <tbody>

                        <tr>

                            {{-- Resume --}}
                            <td>

                                <div class="resume-info">

                                    <div class="resume-icon">

                                        <img src="{{ auth()->user()->avatar() }}"
                                             alt="Profile">

                                    </div>

                                    <div>

                                        <div class="resume-name">
                                          @if (!empty(auth()->user()->uploadedresume))
                                            {{ auth()->user()->uploadedresume->attachment->original_name }}
                                          @endif
                                        </div>

                                        <div class="resume-id">

                                            Custom / Uploaded Resume

                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- Status --}}
                            <td>

                                <span class="resume-status">

                                    <span class="resume-status-dot"></span>

                                    Ready

                                </span>

                            </td>


                            {{-- Selected File --}}
                            <td>
                              @if (empty(auth()->user()->uploadedresume))
                              <span id="selected_resume_name"
                                      class="resume-date">

                                    <i class="fa fa-file-o"></i>

                                    No file selected

                                </span>
                              @else
                              {{ auth()->user()->uploadedresume->attachment->original_name }}
                              @endif
                                

                            </td>


                            {{-- Supported Files --}}
                            <td>

                                <span class="resume-date">

                                    PDF, DOC, DOCX

                                </span>

                            </td>


                            {{-- Actions --}}
                            <td>

                                <div class="resume-actions">

                                    {{-- Select File --}}
                                    <button type="button"
                                            class="upload-resume-btn"
                                            id="upload_resume_btn">

                                        <i class="fa fa-upload"></i>

                                        Upload Resume

                                    </button>


                                    {{-- Submit --}}
                                    <button type="submit"
                                            class="resume-action upload-submit"
                                            id="upload_resume_submit"
                                            title="Submit Resume"
                                            style="display: none;">

                                        <i class="fa fa-check"></i>

                                    </button>
                                     {{-- Download --}}
                                    <a href="{{ auth()->user()->uploadedresume->attachment->file_url }}"
                                       class="resume-action download"
                                       target="_blank"
                                       title="Download PDF">

                                        <i class="fa fa-download"></i>

                                    </a>
                                </div>

                            </td>

                        </tr>

                        </tbody>

                    </table>

                </form>

            </div>

        </div>

    </div>

</div>


<script>
    $(document).ready(function () {

        /*
         * Open file selector
         */
        $('#upload_resume_btn').on('click', function () {

            $('#custom_resume_file').click();

        });


        /*
         * File selected
         */
        $('#custom_resume_file').on('change', function () {

            if (this.files && this.files.length > 0) {

                let file = this.files[0];

                /*
                 * Validate file size
                 * 10 MB maximum
                 */
                let maxSize = 10 * 1024 * 1024;

                if (file.size > maxSize) {

                    alert('Maximum file size allowed is 10 MB.');

                    $(this).val('');

                    $('#selected_resume_name').html(
                        '<i class="fa fa-file-o"></i> No file selected'
                    );

                    $('#upload_resume_submit').hide();

                    return;

                }


                /*
                 * Display selected filename
                 */
                $('#selected_resume_name').html(
                    '<i class="fa fa-file-o"></i> ' + file.name
                );


                /*
                 * Change upload button text
                 */
                $('#upload_resume_btn').html(
                    '<i class="fa fa-check"></i> File Selected'
                );


                /*
                 * Show submit button
                 */
                $('#upload_resume_submit').show();

            }

        });


        /*
         * Submit form
         */
        $('#custom_resume_upload_form').on('submit', function () {

            if (!$('#custom_resume_file').val()) {

                alert('Please select a resume first.');

                return false;

            }


            /*
             * Disable buttons while uploading
             */
            $('#upload_resume_submit')
                .html('<i class="fa fa-spinner fa-spin"></i>')
                .prop('disabled', true);


            $('#upload_resume_btn')
                .prop('disabled', true);

        });

    });
</script>

@endsection