@extends('layout.home')

@section('content')

<style>
    .job_update_outer {
        /* background: #f8fafc;
        min-height: calc(100vh - 70px);
        padding: 40px 15px; */
    }

    .job_update_outer .job_update_card {
        max-width: 1000px;
        margin: 0 auto;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .job_update_outer .job_update_header {
        padding: 25px 30px;
        border-bottom: 1px solid #eef0f3;
        background: #ffffff;
    }

    .job_update_outer .job_update_header_inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .job_update_outer .job_update_title {
        margin: 0;
        color: #0f172a;
        font-size: 23px;
        font-weight: 700;
        letter-spacing: -0.3px;
    }

    .job_update_outer .job_update_subtitle {
        margin: 5px 0 0;
        color: #64748b;
        font-size: 14px;
    }

    .job_update_outer .job_update_badge {
        display: inline-flex;
        align-items: center;
        padding: 7px 12px;
        background: #f1f5f9;
        color: #475569;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .job_update_outer .job_update_body {
        padding: 30px;
    }

    .job_update_outer .job_update_section {
        margin-bottom: 28px;
    }

    .job_update_outer .job_update_section:last-child {
        margin-bottom: 0;
    }

    .job_update_outer .job_update_section_title {
        margin-bottom: 18px;
        color: #1e293b;
        font-size: 16px;
        font-weight: 700;
    }

    .job_update_outer .job_update_section_title i {
        margin-right: 7px;
        color: #64748b;
    }

    .job_update_outer .job_update_label {
        display: block;
        margin-bottom: 7px;
        color: #334155;
        font-size: 13px;
        font-weight: 600;
    }

    .job_update_outer .job_update_required {
        color: #ef4444;
    }

    .job_update_outer .job_update_input,
    .job_update_outer .job_update_textarea {
        width: 100%;
        border: 1px solid #dbe1e8;
        border-radius: 9px;
        background: #ffffff;
        color: #1e293b;
        font-size: 14px;
        transition: all 0.2s ease;
        box-shadow: none;
    }

    .job_update_outer .job_update_input {
        height: 46px;
        padding: 0 14px;
    }

    .job_update_outer .job_update_textarea {
        min-height: 190px;
        padding: 13px 14px;
        resize: vertical;
        line-height: 1.6;
    }

    .job_update_outer .job_update_input::placeholder,
    .job_update_outer .job_update_textarea::placeholder {
        color: #94a3b8;
    }

    .job_update_outer .job_update_input:focus,
    .job_update_outer .job_update_textarea:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.10);
        outline: none;
    }

    .job_update_outer .job_update_help {
        display: block;
        margin-top: 6px;
        color: #94a3b8;
        font-size: 12px;
    }

    .job_update_outer .job_update_switch_box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 17px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background: #f8fafc;
    }

    .job_update_outer .job_update_switch_content {
        padding-right: 15px;
    }

    .job_update_outer .job_update_switch_title {
        margin: 0 0 3px;
        color: #334155;
        font-size: 14px;
        font-weight: 600;
    }

    .job_update_outer .job_update_switch_text {
        margin: 0;
        color: #94a3b8;
        font-size: 12px;
    }

    .job_update_outer .job_update_switch {
        position: relative;
        display: inline-block;
        width: 46px;
        height: 24px;
        margin: 0;
        flex-shrink: 0;
    }

    .job_update_outer .job_update_switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .job_update_outer .job_update_slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: #cbd5e1;
        border-radius: 30px;
        transition: 0.25s;
    }

    .job_update_outer .job_update_slider:before {
        content: "";
        position: absolute;
        width: 18px;
        height: 18px;
        left: 3px;
        top: 3px;
        background: #ffffff;
        border-radius: 50%;
        transition: 0.25s;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
    }

    .job_update_outer .job_update_switch input:checked + .job_update_slider {
        background: #4f46e5;
    }

    .job_update_outer .job_update_switch input:checked + .job_update_slider:before {
        transform: translateX(22px);
    }

    .job_update_outer .job_update_footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        padding: 20px 30px;
        border-top: 1px solid #eef0f3;
        background: #fafbfc;
    }

    .job_update_outer .job_update_cancel {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 100px;
        height: 42px;
        padding: 0 18px;
        border: 1px solid #dbe1e8;
        border-radius: 8px;
        background: #ffffff;
        color: #475569;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .job_update_outer .job_update_cancel:hover {
        background: #f8fafc;
        color: #1e293b;
        text-decoration: none;
    }

    .job_update_outer .job_update_submit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 140px;
        height: 42px;
        padding: 0 20px;
        border: 0;
        border-radius: 8px;
        background: #4f46e5;
        color: #ffffff;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .job_update_outer .job_update_submit:hover {
        background: #4338ca;
        color: #ffffff;
        box-shadow: 0 5px 15px rgba(79, 70, 229, 0.20);
    }

    .job_update_outer .job_update_submit i,
    .job_update_outer .job_update_cancel i {
        margin-right: 6px;
    }

    @media (max-width: 767px) {
        .job_update_outer {
            padding: 20px 10px;
        }

        .job_update_outer .job_update_header,
        .job_update_outer .job_update_body {
            padding: 20px;
        }

        .job_update_outer .job_update_header_inner {
            align-items: flex-start;
            flex-direction: column;
        }

        .job_update_outer .job_update_title {
            font-size: 20px;
        }

        .job_update_outer .job_update_footer {
            padding: 18px 20px;
        }

        .job_update_outer .job_update_cancel,
        .job_update_outer .job_update_submit {
            flex: 1;
        }
    }
</style>

<div class="job_update_outer">

    <div class="job_update_card">
    <br>
 <div class="row no-gutters page-header-outer"   >
    
                        <div class="col-md-6">
                               <div class="page-header">
                                <ul class="breadcrumbs">
                                    <li class="nav-home">
                                        <a href="{{route('jobs.my')}}">
                                            <i class="flaticon-home"></i>
                                        </a>
                                    </li>
                                    <li class="separator">
                                        <i class="flaticon-right-arrow"></i>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('jobs.my')}}">Post Jobs</a>
                                    </li>

                                </ul>

                            </div>
                                    </div>
                                </div>
        {{-- Header --}}
        <div class="job_update_header">
            <div class="job_update_header_inner">

                <div>
                    <h1 class="job_update_title">
                        Update Job
                    </h1>

                    <p class="job_update_subtitle">
                        Update the job information and keep the listing accurate.
                    </p>
                </div>

                <div class="job_update_badge">
                    <i class="fa fa-pencil mr-1"></i>
                    Edit Listing
                </div>

            </div>
        </div>

        {{-- Form --}}
        <form action="{{ route('jobs.update',request('id')) }}" method="POST">
            @csrf

            <div class="job_update_body">

                {{-- Basic Information --}}
                <div class="job_update_section">

                    <div class="job_update_section_title">
                        <i class="fa fa-briefcase"></i>
                        Basic Information
                    </div>

                    <div class="form-group">
                        <label for="title" class="job_update_label">
                            Job Title
                            <span class="job_update_required">*</span>
                        </label>

                        <input
                            type="text"
                            name="title"
                            id="title"
                            class="job_update_input"
                            value="{{ old('title', $job->title ?? '') }}"
                            placeholder="e.g. Senior Laravel Developer"
                            required
                        >
                    </div>

                    <div class="form-group mb-0">
                        <label for="description" class="job_update_label">
                            Job Description
                            <span class="job_update_required">*</span>
                        </label>

                        <textarea
                            name="description"
                            id="description"
                            class="job_update_textarea"
                            placeholder="Enter a detailed description of the job..."
                            required
                        >{{ old('description', $job->description ?? '') }}</textarea>
                    </div>

                </div>

                {{-- Job Details --}}
                <div class="job_update_section">

                    <div class="job_update_section_title">
                        <i class="fa fa-info-circle"></i>
                        Job Details
                    </div>

                    <div class="row">

                        {{-- Location --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="location" class="job_update_label">
                                    Location
                                </label>

                                <input
                                    type="text"
                                    name="location"
                                    id="location"
                                    class="job_update_input"
                                    value="{{ old('location', $job->location ?? '') }}"
                                    placeholder="e.g. London, UK"
                                >
                            </div>
                        </div>

                        {{-- URL --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="url" class="job_update_label">
                                    Job URL
                                    <span style="color:#94a3b8;font-weight:400;">(Optional)</span>
                                </label>

                                <input
                                    type="url"
                                    name="url"
                                    id="url"
                                    class="job_update_input"
                                    value="{{ old('url', $job->url ?? '') }}"
                                    placeholder="https://example.com/job"
                                >

                                <small class="job_update_help">
                                    Add the original job posting URL if available.
                                </small>
                            </div>
                        </div>

                        {{-- Tags --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tags" class="job_update_label">
                                    Tags
                                </label>

                                <input
                                    type="text"
                                    name="tags"
                                    id="tags"
                                    class="job_update_input"
                                    value="{{ old('tags', $job->tags ?? '') }}"
                                    placeholder="Laravel, PHP, MySQL"
                                >

                                <small class="job_update_help">
                                    Separate multiple tags with commas.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tags" class="job_update_label">
                                    Last Date
                                </label>

                                <input
                                    required
                                    type="date"
                                    name="expiry_date"
                                    id="expiry_date"
                                    class="job_update_input"
                                    value="{{ old('expiry_date', !empty($job->expiry_date) ? \Carbon\Carbon::parse($job->expiry_date)->format('Y-m-d') : '') }}"
                                >
                            </div>
                        </div>

                        {{-- Job Types --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="job_types" class="job_update_label">
                                    Job Types
                                </label>

                                <input
                                    type="text"
                                    name="job_types"
                                    id="job_types"
                                    class="job_update_input"
                                    value="{{ old('job_types', $job->job_types ?? '') }}"
                                    placeholder="Full-time, Part-time"
                                >

                                <small class="job_update_help">
                                    Separate multiple job types with commas.
                                </small>
                            </div>
                        </div>

                    </div>

                </div>

                {{-- Remote --}}
                <div class="job_update_section">

                    <div class="job_update_section_title">
                        <i class="fa fa-globe"></i>
                        Work Location
                    </div>

                    <div class="job_update_switch_box">

                        <div class="job_update_switch_content">
                            <p class="job_update_switch_title">
                                Remote Job
                            </p>

                            <p class="job_update_switch_text">
                                Enable this if the position can be performed remotely.
                            </p>
                        </div>

                        <label class="job_update_switch">
                            <input
                                type="checkbox"
                                name="remote"
                                value="1"
                                {{ old('remote', $job->remote ?? 0) ? 'checked' : '' }}
                            >

                            <span class="job_update_slider"></span>
                        </label>

                    </div>
                    <br>
                    <div class="job_update_section_title">
                        <i class="fa fa-cog"></i>
                        Setting
                    </div>
                    <div class="job_update_switch_box">

                        <div class="job_update_switch_content">
                            <p class="job_update_switch_title">
                                Publish
                            </p>
                        </div>

                        <label class="job_update_switch">
                            <input
                                type="checkbox"
                                name="published"
                                value="1"
                                {{ old('status', $job->published??0) ? 'checked' : '' }}
                            >

                            <span class="job_update_slider"></span>
                        </label>

                    </div>
                    <div class="row">
                        @if (is_admin())
                           <div class="col-md-6">
                            <div class="form-group">
                                <label for="status" class="job_update_label">
                                Approval Status
                                </label>

                                <select id="status" name="status" class="form-control">
                                    <option value="pending" {{ $job->status=='pending'?'selected':'' }}>Pending</option>
                                    <option value="rejected" {{ $job->status=='rejected'?'selected':'' }}>Rejected</option>
                                    <option value="approved" {{ $job->status=='approved'?'selected':'' }}>Approved</option>
                                </select>
                            </div>
                        </div> 
                        @endif
                    </div>

                </div>

            </div>

            {{-- Footer --}}
            <div class="job_update_footer">

                <a href="{{ url()->previous() }}" class="job_update_cancel">
                    <i class="fa fa-times"></i>
                    Cancel
                </a>

                <button type="submit" class="job_update_submit">
                    <i class="fa fa-save"></i>
                    Update Job
                </button>

            </div>

        </form>

    </div>

</div>

@endsection