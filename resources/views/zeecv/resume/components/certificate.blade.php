            <!-- Work Experience Card (Expanded by Default) -->
            <div class="builder-card bg-white rounded shadow-sm mb-2 overflow-hidden">
              <div class="p-3 d-flex justify-content-between align-items-center border-bottom" data-toggle="collapse" data-target="#collapseCertificate" style="cursor: pointer;">
                <div>
                  <i class="fas fa-th mr-2 text-muted drag-handle"></i>
                  <strong class="h6 mb-0">Certificates</strong>
                </div>
                <div class="toggle-icons-outer">
                  {{-- <i class="fas fa-cog text-muted mr-3 action-icon"></i> --}}
                  <i class="fas fa-chevron-down text-muted action-icon icon-toggle" onclick="toggleUpDown(this)"></i>
                </div>
              </div>

              <div id="collapseCertificate" class="collapse" data-parent="#builderAccordion">
                
              <div id="certificate_div"></div>

        

                <!-- Add New Entry Button -->
                <div class="p-3 text-center bg-white btn-add-entry-outer" onclick="addCertificate()">
                  <a href="javascript:void" class="text-muted font-weight-bold text-decoration-none btn-add-entry">
                    <i class="fas fa-plus-circle ml-1"></i>
                  </a>
                </div>

              </div>
            </div>

  <script>
    $(document).ready(function(){
      loadCertificates()
    })
function saveCertificate(event, form) {
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
             loadCertificates();
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
function addCertificate() {
    // 4. Send AJAX request
    $.ajax({
        url: "{{ route('resume.certificate.add') }}",
        type: 'POST',
        data:{
            'resume_id':'{{ request('id') }}'
        },
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function(response) {
            if (response.code === '1') {
                loadCertificates().then(function() {
                    // Use response from the original AJAX call
                    if (response.item && response.item.id) {
                        $("#CertificateForm" + response.item.id).addClass("show");
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
function deleteCertificate(url) {
    // 4. Send AJAX request
    $.ajax({
        url: url,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function(response) {
            if (response.code === '1') {
                loadCertificates();
            }
        },
        error: function(xhr) {
        },
        complete: function() {
        }
    });
}
function loadCertificates() {
    LoadCVPreview()
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '{{ route('resume.certificate.list') }}?resume_id={{ request('id') }}',
            type: 'GET',
            beforeSend: function() {
                // $('#certificate_div').html(`
                //     <div class="text-center py-4">
                //         <div class="spinner-border text-primary" role="status">
                //             <span class="sr-only">Loading...</span>
                //         </div>
                //         <p class="mt-2 text-muted">Loading experiences...</p>
                //     </div>
                // `);
            },
            success: function(response) {
                $('#certificate_div').html(response);
                resolve(response);
            },
            error: function(xhr, status, error) {
                $('#certificate_div').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        Failed to load experiences. Please try again.
                    </div>
                `);
                reject({ xhr, status, error });
            }
        });
    });
}
  </script>