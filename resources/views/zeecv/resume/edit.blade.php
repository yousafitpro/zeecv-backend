@extends('zeecv.resume.layout')
@section('title',"Dashboard")
@section('content')
<style>
/* Page Backgrounds & General Setup */
body {
  background-color: #f5f2eb;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  color: #333333;
}

/* Header Navbar */
.app-header {
  border-bottom: 1px solid #e2ded6;
}

.btn-save {
  background-color: #ff6b6b;
  color: #ffffff;
  font-weight: 600;
  border: none;
  transition: background-color 0.2s ease;
}

.btn-save:hover {
  background-color: #fa5252;
  color: #ffffff;
}

/* Content / Template Pill Switcher */
.toggle-pills {
  background-color: #e8e3d8;
}

.btn-pill {
  border: none;
  background: transparent;
  color: #6c757d;
  font-weight: 600;
  font-size: 14px;
  border-radius: 6px;
  padding: 6px 12px;
}

.btn-pill.active {
  background-color: #ffffff;
  color: #212529;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

/* Floating Label Outlined Input System */
.floating-label-group {
  position: relative;
  background-color: #ffffff;
  border: 1px solid #ced4da;
  border-radius: 6px;
  padding: 6px 12px 2px 12px;
}

.floating-label-group label {
  position: absolute;
  top: -9px;
  left: 10px;
  background: #ffffff;
  padding: 0 4px;
  font-size: 11px;
  color: #6c757d;
  margin-bottom: 0;
}

.floating-label-group .form-control {
  border: none;
  padding: 4px 0;
  height: auto;
  font-size: 13px;
  box-shadow: none;
  background: transparent;
}

.floating-label-group .form-control:focus {
  outline: none;
  box-shadow: none;
}

/* Action Icons & Utilities */
.drag-handle {
  cursor: grab;
}

.action-icon {
  cursor: pointer;
  font-size: 13px;
}

.bg-light-item {
  background-color: #fcfbf9;
}

/* AI Button */
.btn-ai {
  background-color: #d8f5a2;
  color: #2b8a3e;
  font-weight: 700;
  border: none;
  font-size: 13px;
  padding: 8px 16px;
}

.btn-ai:hover {
  background-color: #c0eb75;
  color: #2b8a3e;
}

/* Resume Document Sheet */
.resume-sheet {
  min-height: 900px;
  color: #2b2b2b;
}

.resume-name {
  font-size: 24px;
  color: #111111;
}

.resume-subtitle {
  font-size: 12px;
}

.resume-contact {
  font-size: 11px;
  color: #555555;
  line-height: 1.5;
}

.section-heading {
  font-size: 13px;
  letter-spacing: 0.5px;
  border-bottom-color: #a38c73 !important;
}

/* Timeline Custom Bullet & Vertical Line styling */
.timeline-item::before {
  content: '';
  position: absolute;
  left: 3px;
  top: 6px;
  width: 10px;
  height: 10px;
  border: 2px solid #a38c73;
  border-radius: 50%;
  background-color: #ffffff;
  z-index: 2;
}

.timeline-item::after {
  content: '';
  position: absolute;
  left: 7px;
  top: 16px;
  bottom: 0;
  width: 1px;
  border-left: 1px dotted #a38c73;
}

.timeline-item:last-child::after {
  display: none;
}

/* Skill Badges */
.skill-pill {
  background-color: #b0a18f;
  color: #ffffff;
  font-size: 11px;
  padding: 4px 10px;
  border-radius: 4px;
  display: inline-block;
  margin-right: 4px;
  margin-bottom: 6px;
}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resume Builder Layout</title>
  <!-- Bootstrap 4 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

  <!-- Top Navigation Bar -->
  <header class="app-header d-flex justify-content-between align-items-center px-4 py-2 bg-white">
    <a href="#" class="btn btn-link text-secondary text-decoration-none p-0">
      <i class="fas fa-arrow-left mr-2"></i>Back to previous page
    </a>
    <button class="btn btn-save px-4 rounded-pill">Save</button>
  </header>

  <!-- Main Container -->
  <main class="container-fluid main-wrapper py-4 px-lg-5">
    <div class="row">

      <!-- LEFT COLUMN: Editor Form Controls -->
      <div class="col-lg-4 col-md-5 mb-4">
        
        <!-- Tab Switcher -->
        <div class="toggle-pills d-flex mb-3 p-1 rounded">
          <button class="btn btn-pill active flex-fill" id="btnContentTab">
            <i class="fas fa-pen mr-1"></i> Content
          </button>
          <button class="btn btn-pill flex-fill" id="btnTemplateTab">
            <i class="fas fa-palette mr-1"></i> Template
          </button>
        </div>

        <!-- CONTENT TAB VIEW -->
        <div id="contentView">
          <div class="accordion-list" id="builderAccordion">
            
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
                <p class="text-muted small mb-0">Contact details form controls go here...</p>
              </div>
            </div>

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
                <p class="text-muted small mb-0">Summary editor form controls go here...</p>
              </div>
            </div>

            <!-- Work Experience Card (Expanded by Default) -->
            <div class="builder-card bg-white rounded shadow-sm mb-2 overflow-hidden">
              <div class="p-3 d-flex justify-content-between align-items-center border-bottom" data-toggle="collapse" data-target="#collapseWork" style="cursor: pointer;">
                <div>
                  <i class="fas fa-th mr-2 text-muted drag-handle"></i>
                  <strong class="h6 mb-0">Work Experience</strong>
                </div>
                <div>
                  <i class="fas fa-cog text-muted mr-3 action-icon"></i>
                  <i class="fas fa-chevron-up text-muted action-icon icon-toggle"></i>
                </div>
              </div>

              <div id="collapseWork" class="collapse show" data-parent="#builderAccordion">
                
                <!-- First Entry (Expanded Form) -->
                <div class="border-bottom">
                  <div class="p-3 bg-light d-flex justify-content-between align-items-start" data-toggle="collapse" data-target="#workForm1" style="cursor: pointer;">
                    <i class="fas fa-th text-muted drag-handle mr-2 mt-1"></i>
                    <div class="flex-grow-1 pr-2">
                      <h6 class="mb-0 text-dark font-weight-bold" id="formRoleTitle">Sr Full Stack Developer | PHP | Pyt</h6>
                      <small class="text-muted" id="formDateSubtitle">Sept 2025 – Present</small>
                    </div>
                    <div>
                      <i class="far fa-trash-alt text-muted mr-2 action-icon"></i>
                      <i class="fas fa-chevron-up text-muted action-icon icon-toggle"></i>
                    </div>
                  </div>

                  <!-- Expanded Work Item Form -->
                  <div id="workForm1" class="collapse show p-3 bg-light">
                    <form class="mt-1">
                      <div class="floating-label-group mb-3">
                        <input type="text" id="roleTitle" class="form-control" value="Sr Full Stack Developer | PHP | Python | Larav">
                        <label for="roleTitle">Role/Job title</label>
                      </div>

                      <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="currentPos" checked>
                        <label class="form-check-label font-weight-bold text-dark" for="currentPos">Current position</label>
                      </div>

                      <div class="floating-label-group mb-3">
                        <input type="text" id="companyName" class="form-control" value="XAD Group of Companies">
                        <label for="companyName">Company</label>
                      </div>

                      <div class="form-row mb-3">
                        <div class="col-6">
                          <div class="floating-label-group">
                            <input type="text" id="location" class="form-control" value="Sharjah">
                            <label for="location">Location</label>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="floating-label-group">
                            <input type="text" id="country" class="form-control" value="UAE">
                            <label for="country">Country (optional)</label>
                          </div>
                        </div>
                      </div>

                      <div class="form-row mb-3">
                        <div class="col-6">
                          <div class="floating-label-group">
                            <select class="form-control custom-select" id="startMonth">
                              <option selected>September</option>
                            </select>
                            <label for="startMonth">Start month</label>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="floating-label-group">
                            <select class="form-control custom-select" id="startYear">
                              <option selected>2025</option>
                            </select>
                            <label for="startYear">Start year</label>
                          </div>
                        </div>
                      </div>

                      <div class="form-row mb-3">
                        <div class="col-6">
                          <div class="floating-label-group">
                            <select class="form-control custom-select" disabled id="endMonth">
                              <option selected>End month</option>
                            </select>
                            <label for="endMonth">End month</label>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="floating-label-group">
                            <select class="form-control custom-select" disabled id="endYear">
                              <option selected>End year</option>
                            </select>
                            <label for="endYear">End year</label>
                          </div>
                        </div>
                      </div>

                      <div class="floating-label-group mb-2">
                        <textarea id="description" class="form-control" rows="3">XAD Group of Companies</textarea>
                        <label for="description">Description (optional)</label>
                      </div>
                      <div class="text-right text-muted small mb-3">22/1500</div>

                      <button type="button" class="btn btn-ai btn-block rounded-pill">
                        <i class="fas fa-sparkles mr-1"></i> Rewrite with AI
                      </button>
                    </form>
                  </div>
                </div>

                <!-- Item Lists -->
                <div class="item-collapsed-list">
                  <div class="border-bottom">
                    <div class="p-3 d-flex justify-content-between align-items-center bg-light-item" data-toggle="collapse" data-target="#workForm2" style="cursor: pointer;">
                      <div class="d-flex align-items-center">
                        <i class="fas fa-th text-muted drag-handle mr-2"></i>
                        <div>
                          <span class="d-block font-weight-bold small">Project Manager | Laravel | PHP | V</span>
                          <small class="text-muted">Jan 2025 – Sept 2025</small>
                        </div>
                      </div>
                      <div>
                        <i class="far fa-trash-alt text-muted mr-2 action-icon"></i>
                        <i class="fas fa-chevron-down text-muted action-icon icon-toggle"></i>
                      </div>
                    </div>
                    <div id="workForm2" class="collapse p-3 bg-light">
                      <p class="text-muted small mb-0">Project Manager position form controls go here...</p>
                    </div>
                  </div>

                  <div class="border-bottom">
                    <div class="p-3 d-flex justify-content-between align-items-center bg-light-item" data-toggle="collapse" data-target="#workForm3" style="cursor: pointer;">
                      <div class="d-flex align-items-center">
                        <i class="fas fa-th text-muted drag-handle mr-2"></i>
                        <div>
                          <span class="d-block font-weight-bold small">Software Engineer | PHP | Laravel</span>
                          <small class="text-muted">Jun 2023 – Dec 2024</small>
                        </div>
                      </div>
                      <div>
                        <i class="far fa-trash-alt text-muted mr-2 action-icon"></i>
                        <i class="fas fa-chevron-down text-muted action-icon icon-toggle"></i>
                      </div>
                    </div>
                    <div id="workForm3" class="collapse p-3 bg-light">
                      <p class="text-muted small mb-0">Software Engineer position form controls go here...</p>
                    </div>
                  </div>
                </div>

                <!-- Add New Entry Button -->
                <div class="p-3 text-center bg-white">
                  <a href="#" class="text-muted font-weight-bold text-decoration-none">
                    <i class="far fa-plus-circle mr-1"></i> Add new entry
                  </a>
                </div>

              </div>
            </div>

            <!-- Education Card -->
            <div class="builder-card bg-white rounded shadow-sm mb-2">
              <div class="p-3 d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#collapseEducation" style="cursor: pointer;">
                <div>
                  <i class="fas fa-th mr-2 text-muted drag-handle"></i>
                  <strong class="h6 mb-0">Education</strong>
                </div>
                <div>
                  <i class="fas fa-cog text-muted mr-3 action-icon"></i>
                  <i class="fas fa-chevron-down text-muted action-icon icon-toggle"></i>
                </div>
              </div>
              <div id="collapseEducation" class="collapse p-3 border-top" data-parent="#builderAccordion">
                <p class="text-muted small mb-0">Education details form controls go here...</p>
              </div>
            </div>

            <!-- Skills Card -->
            <div class="builder-card bg-white rounded shadow-sm mb-2">
              <div class="p-3 d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#collapseSkills" style="cursor: pointer;">
                <div>
                  <i class="fas fa-th mr-2 text-muted drag-handle"></i>
                  <strong class="h6 mb-0">Skills</strong>
                </div>
                <div>
                  <i class="fas fa-cog text-muted mr-3 action-icon"></i>
                  <i class="fas fa-chevron-down text-muted action-icon icon-toggle"></i>
                </div>
              </div>
              <div id="collapseSkills" class="collapse p-3 border-top" data-parent="#builderAccordion">
                <p class="text-muted small mb-0">Skills list form controls go here...</p>
              </div>
            </div>

          </div>
        </div>

        <!-- TEMPLATE TAB VIEW (Hidden by default) -->
        <div id="templateView" style="display: none;">
          <div class="bg-white p-3 rounded shadow-sm">
            <h6 class="font-weight-bold mb-3">Choose Layout & Styling</h6>
            
            <div class="form-group">
              <label class="small font-weight-bold">Primary Accent Color</label>
              <div class="d-flex gap-2">
                <input type="color" class="form-control form-control-color" value="#ff6b6b" style="width: 50px;">
              </div>
            </div>

            <div class="form-group">
              <label class="small font-weight-bold">Font Style</label>
              <select class="form-control custom-select">
                <option selected>System Default (Sans-Serif)</option>
                <option>Georgia (Serif)</option>
                <option>Roboto</option>
              </select>
            </div>

            <div class="form-group mb-0">
              <label class="small font-weight-bold">Templates</label>
              <div class="p-3 border rounded text-center bg-light">
                <i class="fas fa-file-alt fa-2x text-muted mb-2"></i>
                <p class="small text-muted mb-0">Classic Executive Template Selected</p>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- RIGHT COLUMN: Real-Time Resume Sheet Preview -->
      <div class="col-lg-8 col-md-7">
        <div class="resume-sheet bg-white p-5 shadow-sm rounded">
          
          <!-- Header Profile -->
          <div class="row mb-3">
            <div class="col-md-7">
              <h1 class="resume-name font-weight-bold mb-1">Muhammad Yousaf</h1>
              <p class="resume-subtitle text-muted mb-0">Full Stack | PHP | Python | Laravel | Codeigniter | Fast API | Django | API</p>
            </div>
            <div class="col-md-5 text-md-right resume-contact">
              <div>yousaf.connect@gmail.com <i class="far fa-envelope ml-1"></i></div>
              <div>+92-317-0773093 <i class="fas fa-phone-alt ml-1"></i></div>
              <div>Islamabad, Pakistan <i class="fas fa-map-marker-alt ml-1"></i></div>
              <div>https://linkedin.com/in/yousafitpro <i class="fab fa-linkedin ml-1"></i></div>
            </div>
          </div>

          <!-- Summary Section -->
          <p class="resume-summary text-secondary small leading-relaxed mb-4">
            A dedicated Full Stack Developer with a strong background in PHP, Laravel, and CodeIgniter, alongside experience in Python, Django, and FastAPI. I have a knack for developing and integrating APIs, optimising database performance, and setting up efficient CI/CD pipelines.
          </p>

          <!-- Work Experience Timeline -->
          <section class="mb-4">
            <h5 class="section-heading text-uppercase font-weight-bold pb-1 border-bottom">WORK EXPERIENCE</h5>
            
            <div class="timeline-container mt-3">
              
              <!-- Timeline Item 1 -->
              <div class="timeline-item position-relative pl-4 pb-3">
                <div class="d-flex justify-content-between align-items-baseline">
                  <h6 class="font-weight-bold mb-0 text-dark" id="previewRole">Sr Full Stack Developer | PHP | Python | Laravel | CodeIgniter</h6>
                  <span class="text-muted font-italic small" id="previewDates">09/2025 – Present</span>
                </div>
                <div class="text-muted font-italic small mb-1" id="previewCompany">XAD Group of Companies</div>
                <div class="text-muted small mb-2" id="previewLocation">Sharjah, UAE</div>
                <div class="timeline-bullets text-secondary small" id="previewDescription">
                  XAD Group of Companies
                </div>
              </div>

              <!-- Timeline Item 2 -->
              <div class="timeline-item position-relative pl-4 pb-3">
                <div class="d-flex justify-content-between align-items-baseline">
                  <h6 class="font-weight-bold mb-0 text-dark">Project Manager | Laravel | PHP | Vue</h6>
                  <span class="text-muted font-italic small">01/2025 – 09/2025</span>
                </div>
                <div class="text-muted font-italic small mb-1">ZPAYD.COM</div>
                <div class="text-muted small mb-2">Mississauga, Canada</div>
                <ul class="pl-3 mb-0 text-secondary small">
                  <li>Engineered and developed APIs, facilitating seamless integrations and advancing overall functionality.</li>
                  <li>Revamped database queries, yielding enhanced performance and scalability.</li>
                  <li>Established CI/CD pipelines, promoting efficient and reliable deployment processes.</li>
                </ul>
              </div>

              <!-- Timeline Item 3 -->
              <div class="timeline-item position-relative pl-4 pb-1">
                <div class="d-flex justify-content-between align-items-baseline">
                  <h6 class="font-weight-bold mb-0 text-dark">Software Engineer | PHP | Laravel</h6>
                  <span class="text-muted font-italic small">06/2023 – 12/2024</span>
                </div>
                <div class="text-muted font-italic small mb-1">ACE MONEY TRANSFER</div>
                <div class="text-muted small">Lahore, Pakistan</div>
              </div>

            </div>
          </section>

          <!-- Education Section -->
          <section class="mb-4">
            <h5 class="section-heading text-uppercase font-weight-bold pb-1 border-bottom">EDUCATION</h5>
            <div class="timeline-container mt-3">
              <div class="timeline-item position-relative pl-4">
                <h6 class="font-weight-bold mb-0 text-dark">Bachelor's in Information Technology</h6>
                <div class="d-flex justify-content-between align-items-baseline">
                  <span class="text-muted font-italic small">University of Gujrat</span>
                  <span class="text-muted font-italic small">01/2017 – 01/2021</span>
                </div>
                <div class="text-muted small">Lahore, Pakistan</div>
              </div>
            </div>
          </section>

          <!-- Skills Section -->
          <section>
            <h5 class="section-heading text-uppercase font-weight-bold pb-1 border-bottom">SKILLS</h5>
            <div class="d-flex flex-wrap gap-2 mt-3">
              <span class="skill-pill">PHP</span>
              <span class="skill-pill">Python</span>
              <span class="skill-pill">Django</span>
              <span class="skill-pill">PM</span>
              <span class="skill-pill">Fast API</span>
              <span class="skill-pill">Laravel</span>
              <span class="skill-pill">CodeIgniter</span>
              <span class="skill-pill">CI/CD</span>
              <span class="skill-pill">EC2</span>
              <span class="skill-pill">S3</span>
              <span class="skill-pill">JavaScript</span>
              <span class="skill-pill">JQuery</span>
              <span class="skill-pill">Bootstrap</span>
              <span class="skill-pill">VueJS</span>
              <span class="skill-pill">Angular8+</span>
              <span class="skill-pill">ReactJS</span>
              <span class="skill-pill">Flutter</span>
              <span class="skill-pill">Livewire</span>
            </div>
          </section>

        </div>
      </div>

    </div>
  </main>

  <!-- JS Dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom JS -->
  <script>
    $(document).ready(function () {

      // Dynamic chevron icon flipping on collapse show/hide
      $('.collapse').on('show.bs.collapse', function () {
        $(this).prev().find('.icon-toggle').removeClass('fa-chevron-down').addClass('fa-chevron-up');
      }).on('hide.bs.collapse', function () {
        $(this).prev().find('.icon-toggle').removeClass('fa-chevron-up').addClass('fa-chevron-down');
      });

      // Toggle Content / Template pill tabs & left column views
      $('#btnContentTab').on('click', function () {
        $('.toggle-pills .btn-pill').removeClass('active');
        $(this).addClass('active');
        
        $('#templateView').hide();
        $('#contentView').fadeIn(200);
      });

      $('#btnTemplateTab').on('click', function () {
        $('.toggle-pills .btn-pill').removeClass('active');
        $(this).addClass('active');
        
        $('#contentView').hide();
        $('#templateView').fadeIn(200);
      });

      // Real-time synchronization between editor form and preview sheet
      $('#roleTitle').on('input', function () {
        const val = $(this).val();
        $('#previewRole').text(val);
        $('#formRoleTitle').text(val.substring(0, 30) + (val.length > 30 ? '...' : ''));
      });

      $('#companyName').on('input', function () {
        const val = $(this).val();
        $('#previewCompany').text(val);
      });

      $('#location, #country').on('input', function () {
        const loc = $('#location').val();
        const country = $('#country').val();
        $('#previewLocation').text(`${loc}${country ? ', ' + country : ''}`);
      });

      $('#description').on('input', function () {
        $('#previewDescription').text($(this).val());
      });

      // Toggle present position dates
      $('#currentPos').on('change', function () {
        if ($(this).is(':checked')) {
          $('#endMonth, #endYear').prop('disabled', true);
          $('#previewDates').text(`${$('#startMonth').val()}/${$('#startYear').val()} – Present`);
        } else {
          $('#endMonth, #endYear').prop('disabled', false);
        }
      });

    });
  </script>
</body>
</html>
@endsection