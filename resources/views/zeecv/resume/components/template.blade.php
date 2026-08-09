      <!-- TEMPLATE TAB VIEW (Hidden by default) -->
        <div id="templateView" style="display: none;">
          <div class="bg-white p-3 rounded shadow-sm">
            <h6 class="font-weight-bold mb-3">Choose Layout & Styling</h6>
             <form class="mt-1" method="post" action="{{ route('resume.template.save') }}"  onsubmit="saveTemplate(event,this)">
                      @csrf
                      <input hidden name="resume_id" value="{{ request('id') }}">
                      <div class="floating-label-group mb-3">
                        
                        <select id="template" name="template" class="form-control">
                          <option value="default" {{ $template->template=='default'?'selected':'' }}>Default</option>
                        </select>
                        <label for="template">Template</label>
                      </div>
                      <button type="submit" class="btn btn-primary btn-block rounded-pill btn-save-list">
                        <i class="fas fa-sparkles mr-1"></i> Save
                      </button>
                    </form>
          

          </div>
        </div>
        <script>
  function saveTemplate(event, form) {
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