            <!-- Summary Card -->
            <div class="builder-card bg-white rounded shadow-sm mb-2">
              <div class="p-3 d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#collapseSummary" style="cursor: pointer;">
                <div>
                  <i class="fas fa-th mr-2 text-muted drag-handle"></i>
                  <strong class="h6 mb-0">Summary</strong>
                </div>
                <div>
                  <i class="fas fa-cog text-muted mr-3 action-icon"></i>
                  <i class="fas fa-chevron-down text-muted action-icon icon-toggle"></i>
                </div>
              </div>
              <div id="collapseSummary" class="collapse p-3 border-top" data-parent="#builderAccordion">
                 <form class="mt-1" method="post" action="{{ route('resume.summary.save') }}"  onsubmit="saveSummary(event,this)">
                      @csrf
                      <input hidden name="resume_id" value="{{ request('id') }}">
                      <div class="floating-label-group mb-3">
                        <textarea id="summary" name="summary" class="form-control">{{ $summary->summary}}</textarea>
                        <label for="summary">Summary</label>
                      </div>
                      <button type="submit" class="btn btn-primary btn-block rounded-pill btn-save-list">
                        <i class="fas fa-sparkles mr-1"></i> Save
                      </button>
                    </form>
              </div>
            </div>

<script>
  function saveSummary(event, form) {
    // 1. Prevent the default form submission
    event.preventDefault();


    // 3. Gather form data
    const formData = new FormData(form);

    // 4. Send AJAX request
    $.ajax({
        url: form.action,
        type: 'POST',
        data: formData,
        processData: false,  // Important for FormData
        contentType: false,  // Important for FormData
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        beforeSend: function() {
            // Show loading state
            $(form).find('button[type="submit"]').prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        },
        success: function(response) {
            if (response.code === '1') {
            $("#collapseSummary").collapse('toggle');
            LoadCVPreview()
            }
        },
        error: function(xhr) {
        },
        complete: function() {
          $(form).find('button[type="submit"]').prop('disabled', false)
                .html('Save');
        }
    });
}
</script>