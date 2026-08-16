@extends('layout.home')

@section('meta_tags')
    <title>Post a Job | ZeeCV</title>
    <meta name="description" content="Post your job on ZeeCV and connect with qualified candidates. Add your company and job details to reach the right talent.">
@endsection

@section('content')

<style>
    .post_job_outer_div {
        background: #f7f9fc;
        padding: 60px 15px;
        min-height: 70vh;
    }

    .post_job_outer_div .post_job_wrapper {
        max-width: 1150px;
        margin: 0 auto;
    }

    .post_job_outer_div .post_job_header {
        text-align: center;
        margin-bottom: 40px;
    }

    .post_job_outer_div .post_job_badge {
        display: inline-block;
        background: rgba(13, 110, 253, 0.08);
        color: #0d6efd;
        padding: 7px 16px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .post_job_outer_div .post_job_title {
        font-size: 36px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 10px;
    }

    .post_job_outer_div .post_job_subtitle {
        color: #6b7280;
        font-size: 16px;
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.7;
    }

    .post_job_outer_div .post_job_card {
        background: #ffffff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 8px 35px rgba(31, 41, 55, 0.08);
        border: 1px solid #edf0f5;
    }

    /*
    |--------------------------------------------------------------------------
    | Company Information
    |--------------------------------------------------------------------------
    */

    .post_job_outer_div .post_job_company_info {
        background: #111827;
        color: #ffffff;
        height: 100%;
        padding: 40px 35px;
    }

    .post_job_outer_div .post_job_company_title {
        font-size: 25px;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .post_job_outer_div .post_job_company_text {
        color: #cbd5e1;
        line-height: 1.7;
        font-size: 14px;
        margin-bottom: 30px;
    }

    .post_job_outer_div .post_job_company_item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 23px;
    }

    .post_job_outer_div .post_job_company_icon {
        width: 42px;
        height: 42px;
        min-width: 42px;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 14px;
        color: #ffffff;
        font-size: 16px;
    }

    .post_job_outer_div .post_job_company_item h6 {
        margin: 0 0 4px;
        font-size: 14px;
        font-weight: 600;
    }

    .post_job_outer_div .post_job_company_item p {
        margin: 0;
        color: #cbd5e1;
        font-size: 13px;
        line-height: 1.5;
        word-break: break-word;
    }

    /*
    |--------------------------------------------------------------------------
    | Form
    |--------------------------------------------------------------------------
    */

    .post_job_outer_div .post_job_form {
        padding: 40px 35px;
    }

    .post_job_outer_div .post_job_form_title {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 25px;
    }

    .post_job_outer_div .post_job_section_title {
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
        margin: 25px 0 18px;
        padding-bottom: 10px;
        border-bottom: 1px solid #edf0f5;
    }

    .post_job_outer_div .post_job_label {
        color: #374151;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .post_job_outer_div .post_job_required {
        color: #dc3545;
    }

    .post_job_outer_div .post_job_input,
    .post_job_outer_div .post_job_select,
    .post_job_outer_div .post_job_textarea {
        width: 100%;
        border: 1px solid #dfe3e8;
        border-radius: 7px;
        padding: 0 14px;
        font-size: 14px;
        color: #1f2937;
        background: #ffffff;
        outline: none;
        transition: all 0.2s ease;
    }

    .post_job_outer_div .post_job_input,
    .post_job_outer_div .post_job_select {
        height: 48px;
    }

    .post_job_outer_div .post_job_textarea {
        min-height: 120px;
        padding: 13px 14px;
        resize: vertical;
        line-height: 1.6;
    }

    .post_job_outer_div .post_job_input:focus,
    .post_job_outer_div .post_job_select:focus,
    .post_job_outer_div .post_job_textarea:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.08);
    }

    .post_job_outer_div .post_job_submit {
        height: 48px;
        padding: 0 28px;
        border: 0;
        border-radius: 7px;
        background: #0d6efd;
        color: #ffffff;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-top: 5px;
    }

    .post_job_outer_div .post_job_submit:hover {
        background: #0b5ed7;
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.2);
    }

    .post_job_outer_div .post_job_alert {
        border-radius: 7px;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .post_job_outer_div .post_job_hint {
        font-size: 11px;
        color: #9ca3af;
        margin-top: 5px;
    }

    /*
    |--------------------------------------------------------------------------
    | Mobile
    |--------------------------------------------------------------------------
    */

    @media (max-width: 767px) {

        .post_job_outer_div {
            padding: 40px 10px;
        }

        .post_job_outer_div .post_job_title {
            font-size: 28px;
        }

        .post_job_outer_div .post_job_subtitle {
            font-size: 14px;
        }

        .post_job_outer_div .post_job_company_info {
            padding: 30px 25px;
        }

        .post_job_outer_div .post_job_form {
            padding: 30px 20px;
        }
    }
</style>


<div class="post_job_outer_div">

    <div class="post_job_wrapper">

        {{-- Header --}}
        <div class="post_job_header">

            <span class="post_job_badge">
                <i class="fas fa-briefcase mr-1"></i>
                Hire Top Talent
            </span>

            <h1 class="post_job_title">
                Post a Job
            </h1>

            <p class="post_job_subtitle">
                Share your job opportunity with talented professionals.
                Provide your company and job details to reach the right candidates.
            </p>

        </div>


        {{-- Success --}}
        @if(session('success'))

            <div class="alert alert-success post_job_alert">
                {{ session('success') }}
            </div>

        @endif


        {{-- Errors --}}
        @if($errors->any())

            <div class="alert alert-danger post_job_alert">

                <ul class="mb-0 pl-3">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        <div class="post_job_card">

            <div class="row no-gutters">

                {{-- LEFT SIDE --}}
                <div class="col-lg-5">

                    <div class="post_job_company_info">

                        <h2 class="post_job_company_title">
                            Find the right talent
                        </h2>

                        <p class="post_job_company_text">
                            Post your vacancy on ZeeCV and give talented
                            professionals the opportunity to discover your
                            company and apply for your open position.
                        </p>


                        {{-- Company --}}
                        <div class="post_job_company_item">

                            <div class="post_job_company_icon">
                                <i class="fas fa-building"></i>
                            </div>

                            <div>

                                <h6>
                                    Company Information
                                </h6>

                                <p>
                                    Add your company name and website so
                                    candidates can learn more about your business.
                                </p>

                            </div>

                        </div>


                        {{-- Job --}}
                        <div class="post_job_company_item">

                            <div class="post_job_company_icon">
                                <i class="fas fa-user-tie"></i>
                            </div>

                            <div>

                                <h6>
                                    Reach Candidates
                                </h6>

                                <p>
                                    Share your job requirements and attract
                                    qualified candidates.
                                </p>

                            </div>

                        </div>


                        {{-- Email --}}
                        <div class="post_job_company_item">

                            <div class="post_job_company_icon">
                                <i class="fas fa-envelope"></i>
                            </div>

                            <div>

                                <h6>
                                    Contact Email
                                </h6>

                                <p>
                                    Your email will be used for job-related
                                    communication.
                                </p>

                            </div>

                        </div>


                        {{-- Free --}}
                        <div class="post_job_company_item">

                            <div class="post_job_company_icon">
                                <i class="fas fa-check-circle"></i>
                            </div>

                            <div>

                                <h6>
                                    Easy Job Posting
                                </h6>

                                <p>
                                    Provide the details once and let candidates
                                    discover your opportunity.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- RIGHT SIDE --}}
                <div class="col-lg-7">

                    <div class="post_job_form">

                        <h2 class="post_job_form_title">
                            Job & Company Details
                        </h2>


                        <form
                            method="POST"
                            action="{{ route('home.post_a_job_process') }}"
                        >

                            @csrf


                            {{-- ============================= --}}
                            {{-- COMPANY INFORMATION --}}
                            {{-- ============================= --}}

                            <div class="post_job_section_title">

                                <i class="fas fa-building mr-2"></i>
                                Company Information

                            </div>


                            <div class="form-row">

                                {{-- Company Name --}}
                                <div class="form-group col-md-6">

                                    <label class="post_job_label">
                                        Company Name
                                        <span class="post_job_required">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="company_name"
                                        value="{{ old('company_name') }}"
                                        class="post_job_input"
                                        placeholder="e.g. ZeeCV"
                                        required
                                    >

                                </div>


                                {{-- Company Email --}}
                                <div class="form-group col-md-6">

                                    <label class="post_job_label">
                                        Company Email
                                        <span class="post_job_required">*</span>
                                    </label>

                                    <input
                                        type="email"
                                        name="company_email"
                                        value="{{ old('company_email') }}"
                                        class="post_job_input"
                                        placeholder="hr@company.com"
                                        required
                                    >

                                </div>

                            </div>


                            <div class="form-row">

                                {{-- Website --}}
                                <div class="form-group col-md-6">

                                    <label class="post_job_label">
                                        Company Website
                                    </label>

                                    <input
                                        type="url"
                                        name="company_website"
                                        value="{{ old('company_website') }}"
                                        class="post_job_input"
                                        placeholder="https://company.com"
                                    >

                                </div>


                                {{-- Company Phone --}}
                                <div class="form-group col-md-6">

                                    <label class="post_job_label">
                                        Contact Number
                                    </label>

                                    <input
                                        type="text"
                                        name="company_phone"
                                        value="{{ old('company_phone') }}"
                                        class="post_job_input"
                                        placeholder="+92 300 1234567"
                                    >

                                </div>

                            </div>


                            <div class="form-group">

                                <label class="post_job_label">
                                    Company Description
                                </label>

                                <textarea
                                    name="company_description"
                                    class="post_job_textarea"
                                    placeholder="Tell candidates briefly about your company..."
                                >{{ old('company_description') }}</textarea>

                            </div>


                            {{-- ============================= --}}
                            {{-- JOB INFORMATION --}}
                            {{-- ============================= --}}

                            <div class="post_job_section_title">

                                <i class="fas fa-briefcase mr-2"></i>
                                Job Information

                            </div>


                            {{-- Job Title --}}
                            <div class="form-group">

                                <label class="post_job_label">
                                    Job Title
                                    <span class="post_job_required">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="job_title"
                                    value="{{ old('job_title') }}"
                                    class="post_job_input"
                                    placeholder="e.g. Senior Laravel Developer"
                                    required
                                >

                            </div>


                            <div class="form-row">

                                {{-- Location --}}
                                <div class="form-group col-md-6">

                                    <label class="post_job_label">
                                        Job Location
                                        <span class="post_job_required">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="location"
                                        value="{{ old('location') }}"
                                        class="post_job_input"
                                        placeholder="e.g. Lahore, Pakistan"
                                        required
                                    >

                                </div>


                                {{-- Job Type --}}
                                <div class="form-group col-md-6">

                                    <label class="post_job_label">
                                        Job Type
                                        <span class="post_job_required">*</span>
                                    </label>

                                    <select
                                        name="job_type"
                                        class="post_job_select"
                                        required
                                    >

                                        <option value="">
                                            Select job type
                                        </option>

                                        <option
                                            value="Full Time"
                                            {{ old('job_type') == 'Full Time' ? 'selected' : '' }}
                                        >
                                            Full Time
                                        </option>

                                        <option
                                            value="Part Time"
                                            {{ old('job_type') == 'Part Time' ? 'selected' : '' }}
                                        >
                                            Part Time
                                        </option>

                                        <option
                                            value="Contract"
                                            {{ old('job_type') == 'Contract' ? 'selected' : '' }}
                                        >
                                            Contract
                                        </option>

                                        <option
                                            value="Freelance"
                                            {{ old('job_type') == 'Freelance' ? 'selected' : '' }}
                                        >
                                            Freelance
                                        </option>

                                        <option
                                            value="Internship"
                                            {{ old('job_type') == 'Internship' ? 'selected' : '' }}
                                        >
                                            Internship
                                        </option>

                                    </select>

                                </div>

                            </div>


                            <div class="form-row">

                                {{-- Salary --}}
                                <div class="form-group col-md-6">

                                    <label class="post_job_label">
                                        Salary
                                    </label>

                                    <input
                                        type="text"
                                        name="salary"
                                        value="{{ old('salary') }}"
                                        class="post_job_input"
                                        placeholder="e.g. $2,000 - $3,000 / month"
                                    >

                                </div>


                                {{-- Experience --}}
                                <div class="form-group col-md-6">

                                    <label class="post_job_label">
                                        Experience
                                    </label>

                                    <input
                                        type="text"
                                        name="experience"
                                        value="{{ old('experience') }}"
                                        class="post_job_input"
                                        placeholder="e.g. 3+ years"
                                    >

                                </div>

                            </div>


                            {{-- Job Description --}}
                            <div class="form-group">

                                <label class="post_job_label">
                                    Job Description
                                    <span class="post_job_required">*</span>
                                </label>

                                <textarea
                                    name="job_description"
                                    class="post_job_textarea"
                                    style="min-height: 180px;"
                                    placeholder="Describe the role, responsibilities, requirements and qualifications..."
                                    required
                                >{{ old('job_description') }}</textarea>

                            </div>


                            {{-- Apply URL --}}
                            <div class="form-group">

                                <label class="post_job_label">
                                    Application URL / Email
                                    <span class="post_job_required">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="apply_url"
                                    value="{{ old('apply_url') }}"
                                    class="post_job_input"
                                    placeholder="https://company.com/careers/job or hr@company.com"
                                    required
                                >

                                <div class="post_job_hint">
                                    Candidates will use this information to apply for the position.
                                </div>

                            </div>


                            {{-- Submit --}}
                            <button
                                type="submit"
                                class="post_job_submit"
                            >

                                <i class="fas fa-paper-plane mr-2"></i>

                                Post Job

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection