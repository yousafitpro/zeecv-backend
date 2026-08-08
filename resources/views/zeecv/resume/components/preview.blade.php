  <!-- RIGHT COLUMN: Real-Time Resume Sheet Preview -->
   
        <div class="resume-sheet bg-white p-5 shadow-sm rounded">
          
          <!-- Header Profile -->
          <div class="row mb-3">
            <div class="col-md-7">
              <h1 class="resume-name font-weight-bold mb-1">{{$cv->contact->first_name.' '.$cv->contact->last_name}}</h1>
              <p class="resume-subtitle text-muted mb-0">{{$cv->contact->desired_job_title}}</p>
            </div>
            <div class="col-md-5 text-md-right resume-contact">
              <div>   {{$cv->contact->email}} <i class="far fa-envelope ml-1"></i></div>
              <div>   {{$cv->contact->phone}} <i class="fas fa-phone-alt ml-1"></i></div>
              <div>   {{$cv->contact->location}} ,    {{$cv->contact->country}} <i class="fas fa-map-marker-alt ml-1"></i></div>
              <div>   {{$cv->contact->profile_link}} <i class="fab fa-linkedin ml-1"></i></div>
            </div>
          </div>

          <!-- Summary Section -->
          <p class="resume-summary text-secondary small leading-relaxed mb-4">
           {{ $cv->summary->summary }}
          </p>


          @if (!empty($cv->experiences))
                   <!-- Work Experience Timeline -->
          <section class="mb-4">
            <h5 class="section-heading text-uppercase font-weight-bold pb-1 border-bottom">WORK EXPERIENCE</h5>
            
            <div class="timeline-container mt-3">
              
              @foreach ($cv->experiences as $exp)
              <!-- Timeline Item 1 -->
              <div class="timeline-item position-relative pl-4 pb-3">
                <div class="d-flex justify-content-between align-items-baseline">
                  <h6 class="font-weight-bold mb-0 text-dark" id="previewRole">{{$exp->job_title}}</h6>
                  <span class="text-muted font-italic small" id="previewDates">{{$exp->start_month}}/{{$exp->start_year}}– {{$exp->end_month}}/{{$exp->end_year}}</span>
                </div>
                <div class="text-muted font-italic small mb-1" id="previewCompany">{{$exp->company}}</div>
                <div class="text-muted small mb-2" id="previewLocation">{{$exp->location}},{{$exp->country}}</div>
              
              </div>
              @endforeach


     

            </div>
          </section>
          @endif
   
@if (!empty($cv->educations))

          <!-- Education Section -->
          
          <section class="mb-4">
            <h5 class="section-heading text-uppercase font-weight-bold pb-1 border-bottom">EDUCATION</h5>
            <div class="timeline-container mt-3">
              @foreach ($cv->educations as $edu)
              <div class="timeline-item position-relative pl-4">
                <h6 class="font-weight-bold mb-0 text-dark">{{$edu->degree}}</h6>
                <div class="d-flex justify-content-between align-items-baseline">
                  <span class="text-muted font-italic small">{{$edu->institution}}</span>
                  <span class="text-muted font-italic small">{{$edu->start_month}}/{{$edu->start_year}}– {{$edu->end_month}}/{{$edu->end_year}}</span>
                </div>
                <div class="text-muted small">{{$exp->location}},{{$exp->country}}</div>
              </div>
               @endforeach
            </div>
          </section>
            
         
@endif

@if (!empty($cv->skills))
          <!-- Skills Section -->
          <section>
            <h5 class="section-heading text-uppercase font-weight-bold pb-1 border-bottom">SKILLS</h5>
            <div class="d-flex flex-wrap gap-2 mt-3">
              @foreach ($cv->skills as $skill)
                <span class="skill-pill">{{$skill->skill}}</span>
              @endforeach
            </div>
          </section>
@endif

        </div>
      