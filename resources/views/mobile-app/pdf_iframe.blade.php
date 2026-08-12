@php
    $preview_url = route('resume.pdf.preview2', $r_id) . '?' . http_build_query([
        'resume' => now()
    ]);
@endphp

<div style="width: 100%; height: 100vh;">
    <iframe
        src="{{ $preview_url }}"
        width="100%"
        height="100%"
        style="border: none;"
        title="Resume PDF Preview">
    </iframe>
</div>