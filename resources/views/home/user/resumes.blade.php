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

    #resumes_outer_div .create-resume-btn {
        background: #2563eb;
        border: 1px solid #2563eb;
        color: #fff;
        padding: 10px 18px;
        border-radius: 7px;
        font-size: 14px;
        font-weight: 600;
        white-space: nowrap;
        transition: all .2s ease;
    }

    #resumes_outer_div .create-resume-btn:hover {
        background: #1d4ed8;
        border-color: #1d4ed8;
        color: #fff;
        text-decoration: none;
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

    /* Resume Name */
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
    }

    #resumes_outer_div .resume-status-dot {
        width: 6px;
        height: 6px;
        background: #10b981;
        border-radius: 50%;
        margin-right: 6px;
    }

    /* Date */
    #resumes_outer_div .resume-date {
        color: #475569;
        font-size: 13px;
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

    #resumes_outer_div .resume-action.delete:hover {
        color: #dc2626;
        border-color: #fecaca;
        background: #fef2f2;
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

        #resumes_outer_div .create-resume-btn {
            width: 100%;
            text-align: center;
        }

        #resumes_outer_div .resumes-container {
            overflow-x: auto;
        }

        #resumes_outer_div .resumes-table {
            min-width: 800px;
        }
    }
</style>

<div id="resumes_outer_div">

    <div class="resumes-wrapper">

        {{-- Header --}}
        <div class="resumes-header">

            <div>
                <h1 class="resumes-title">
                    My Resumes
                </h1>

                <p class="resumes-subtitle">
                    Manage, edit and download your professional resumes.
                </p>
            </div>

            <a href="{{ route('resume.create') }}"
               class="create-resume-btn">
                <i class="fa fa-plus mr-1"></i>
                Create New Resume
            </a>

        </div>


        {{-- Resumes --}}
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
                                            <img style="width: 100%;" src="{{ auth()->user()->avatar() }}">
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
                                        <a href="{{ route('resume.pdf',unique_encrypt($resume->id)) }}"
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


                {{-- Pagination --}}
                @if(method_exists($resumes, 'links'))

                    <div class="resumes-pagination">
                        {{ $resumes->links() }}
                    </div>

                @endif


            @else

                {{-- Empty State --}}
                <div class="empty-state">

                    <div class="empty-icon">
                        <i class="fa fa-file-text-o"></i>
                    </div>

                    <div class="empty-title">
                        No Resumes Yet
                    </div>

                    <div class="empty-text">
                        Create your first professional resume and start applying for jobs.
                    </div>

                    <a href="{{ route('resume.create') }}"
                       class="create-resume-btn">
                        <i class="fa fa-plus mr-1"></i>
                        Create Your First Resume
                    </a>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection