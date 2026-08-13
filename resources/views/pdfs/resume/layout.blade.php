@if (empty($cv->contact->desired_job_title) || empty($cv->contact->first_name))
    <small>Please contact details</small>
@endif
@yield('resume_content')