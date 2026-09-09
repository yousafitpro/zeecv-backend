@if (empty($cv->contact->desired_job_title) && empty($cv->contact->first_name))
    <div class="d-flex flex-column align-items-center justify-content-center text-center p-1" style="min-height: 300px;">
        {{-- <i class="fa fa-exclamation-circle text-warning mb-3" style="font-size: 48px;"></i> --}}
        <h4 class="mb-2">Complete Your Profile</h4>
        <div class="card card-body">
            <form class="mt-1" method="post" action="{{ route('resume.contact.save') }}"  onsubmit="saveContact(event,this,true)">
                      @csrf
                      <input hidden name="resume_id" value="{{ unique_encrypt($cv->id) }}">
                      <div class="floating-label-group mb-3">
                        <input type="text" id="roleTitle" name="desired_job_title" class="form-control" value="">
                        <label for="roleTitle">Tag Line / Desired Job title</label>
                      </div>
                      <div class="form-row mb-3">
                        <div class="col-6">
                          <div class="floating-label-group">
                            <input type="text" id="first_name" name="first_name" class="form-control" value="">
                            <label for="first_name">First Name</label>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="floating-label-group">
                            <input type="text" id="last_name" name="last_name" class="form-control" value="">
                            <label for="last_name">Last Name</label>
                          </div>
                        </div>
                      </div>
                      <div class="floating-label-group mb-3">
                        <input type="text" id="location" name="location" class="form-control" value="">
                        <label for="location">Location</label>
                      </div>
                      <div class="form-row mb-3">
                        <div class="col-6">
                          <div class="floating-label-group">
                            <input type="text" id="zip_code" name="zip_code" class="form-control" value="">
                            <label for="zip_code">Zip Code</label>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="floating-label-group">
                            <input type="text" id="country" name="country" class="form-control" value="">
                            <label for="country">Country</label>
                          </div>
                        </div>
                      </div>
                      <div class="floating-label-group mb-3">
                        <input type="text" id="phone" name="phone" class="form-control" value="">
                        <label for="phone">Phone</label>
                      </div>
                               <div class="floating-label-group mb-3">
                        <input type="text" id="email" name="email" class="form-control" value="">
                        <label for="email">Email</label>
                      </div>
                               <div class="floating-label-group mb-3">
                        <input type="text" id="profile_link" name="profile_link" class="form-control" value="">
                        <label for="profile_link">Profile Link</label>
                      </div>
                      <button type="submit" class="btn btn-primary btn-block rounded-pill btn-save-list">
                        <i class="fas fa-sparkles mr-1"></i> Save
                      </button>
                    </form>
        </div>
     
    </div>
@else
    @yield('resume_content')
@endif