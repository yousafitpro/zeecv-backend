            <!-- Work Experience Card (Expanded by Default) -->
            <div class="builder-card bg-white rounded shadow-sm mb-2 overflow-hidden">
              <div class="p-3 d-flex justify-content-between align-items-center border-bottom" data-toggle="collapse" data-target="#collapseEducation" style="cursor: pointer;">
                <div>
                  <i class="fas fa-th mr-2 text-muted drag-handle"></i>
                  <strong class="h6 mb-0">Education</strong>
                </div>
                <div>
                  <i class="fas fa-cog text-muted mr-3 action-icon"></i>
                  <i class="fas fa-chevron-up text-muted action-icon icon-toggle"></i>
                </div>
              </div>

              <div id="collapseEducation" class="collapse show" data-parent="#builderAccordion">
                
              <div id="education_div"></div>

        

                <!-- Add New Entry Button -->
                <div class="p-3 text-center bg-white" onclick="addEducation()">
                  <a href="javascript:void" class="text-muted font-weight-bold text-decoration-none">
                    <i class="far fa-plus-circle mr-1"></i> Add new entry
                  </a>
                </div>

              </div>
            </div>

  <script>
    $(document).ready(function(){
      loadEducations()
    })
function saveEducation(event, form) {
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
             loadEducations();
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
function addEducation() {
    // 4. Send AJAX request
    $.ajax({
        url: "{{ route('resume.education.add') }}",
        type: 'POST',
        data:{
            'resume_id':'{{ request('id') }}'
        },
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function(response) {
            if (response.code === '1') {
                loadEducations().then(function() {
                    // Use response from the original AJAX call
                    if (response.item && response.item.id) {
                        $("#EducaionForm" + response.item.id).addClass("show");
                    }
                }).catch(function(error) {
                    console.error('Failed to load experiences:', error);
                });
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
function deleteEducation(url) {
    // 4. Send AJAX request
    $.ajax({
        url: url,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function(response) {
            if (response.code === '1') {
                loadEducations();
            }
        },
        error: function(xhr) {
        },
        complete: function() {
        }
    });
}
function loadEducations() {
    LoadCVPreview()
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '{{ route('resume.education.list') }}?resume_id={{ request('id') }}',
            type: 'GET',
            beforeSend: function() {
                // $('#experience_div').html(`
                //     <div class="text-center py-4">
                //         <div class="spinner-border text-primary" role="status">
                //             <span class="sr-only">Loading...</span>
                //         </div>
                //         <p class="mt-2 text-muted">Loading experiences...</p>
                //     </div>
                // `);
            },
            success: function(response) {
                $('#education_div').html(response);
                resolve(response);
            },
            error: function(xhr, status, error) {
                reject({ xhr, status, error });
            }
        });
    });
}
  </script>