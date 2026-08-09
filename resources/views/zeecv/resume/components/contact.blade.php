            <!-- Contact Card -->
            <div class="builder-card bg-white rounded shadow-sm mb-2">
              <div class="p-3 d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#collapseContact" style="cursor: pointer;">
                <div>
                  <i class="fas fa-th mr-2 text-muted drag-handle"></i>
                  <strong class="h6 mb-0">Contact</strong>
                </div>
                <div>
                  <i class="fas fa-cog text-muted mr-3 action-icon"></i>
                  <i class="fas fa-chevron-down text-muted action-icon icon-toggle"></i>
                </div>
              </div>
              <div id="collapseContact" class="collapse p-3 border-top" data-parent="#builderAccordion">
                 <form class="mt-1" method="post" action="{{ route('resume.contact.save') }}"  onsubmit="saveContact(event,this)">
                      @csrf
                      <input hidden name="resume_id" value="{{ request('id') }}">
                      <div class="floating-label-group mb-3">
                        <input type="text" id="roleTitle" name="desired_job_title" class="form-control" value="{{ $contact->desired_job_title}}">
                        <label for="roleTitle">Desired Job title</label>
                      </div>
                      <div class="form-row mb-3">
                        <div class="col-6">
                          <div class="floating-label-group">
                            <input type="text" id="first_name" name="first_name" class="form-control" value="{{ $contact->first_name}}">
                            <label for="first_name">First Name</label>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="floating-label-group">
                            <input type="text" id="last_name" name="last_name" class="form-control" value="{{ $contact->last_name}}">
                            <label for="last_name">Last Name</label>
                          </div>
                        </div>
                      </div>
                      <div class="floating-label-group mb-3">
                        <input type="text" id="location" name="location" class="form-control" value="{{ $contact->location}}">
                        <label for="location">Location</label>
                      </div>
                      <div class="form-row mb-3">
                        <div class="col-6">
                          <div class="floating-label-group">
                            <input type="text" id="zip_code" name="zip_code" class="form-control" value="{{ $contact->zip_code}}">
                            <label for="zip_code">Zip Code</label>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="floating-label-group">
                            <input type="text" id="country" name="country" class="form-control" value="{{ $contact->country}}">
                            <label for="country">Country</label>
                          </div>
                        </div>
                      </div>
                      <div class="floating-label-group mb-3">
                        <input type="text" id="phone" name="phone" class="form-control" value="{{ $contact->phone}}">
                        <label for="phone">Phone</label>
                      </div>
                               <div class="floating-label-group mb-3">
                        <input type="text" id="email" name="email" class="form-control" value="{{ $contact->email}}">
                        <label for="email">Email</label>
                      </div>
                               <div class="floating-label-group mb-3">
                        <input type="text" id="profile_link" name="profile_link" class="form-control" value="{{ $contact->profile_link}}">
                        <label for="profile_link">Profile Link</label>
                      </div>
                      <button type="submit" class="btn btn-primary btn-block rounded-pill btn-save-list">
                        <i class="fas fa-sparkles mr-1"></i> Save
                      </button>
                    </form>
              </div>
            </div>

<script>
  function saveContact(event, form) {
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
            $("#collapseContact").collapse('toggle');
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