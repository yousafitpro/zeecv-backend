                <!-- First Entry (Expanded Form) -->
                @foreach ($list as $item)
                  <div class="border-bottom">
                  <div class="p-3 bg-light d-flex justify-content-between align-items-start"  style="cursor: pointer;">
                    <i class="fas fa-th text-muted drag-handle mr-2 mt-1"></i>
                    <div class="flex-grow-1 pr-2">
                      <h6 class="mb-0 text-dark font-weight-bold" id="formRoleTitle">{{ $item->job_title}}</h6>
                      <small class="text-muted" id="formDateSubtitle">Sept 2025 – Present</small>
                    </div>
                    <div>
                      <i class="far fa-trash-alt text-muted mr-2 " onclick="deleteExperience('{{ route('resume.experience.delete',$item->id) }}')"></i>
                      <i class="fas fa-chevron-up text-muted action-icon icon-toggle" data-toggle="collapse" data-target="#workForm{{ $item->id }}"></i>
                    </div>
                  </div>

                  <!-- Expanded Work Item Form -->
                  <div id="workForm{{ $item->id }}" class="collapse p-3 bg-light">
                    <form class="mt-1" method="post" action="{{ route('resume.experience.save') }}"  onsubmit="saveExperiences(event,this)">
                      @csrf
                      <input hidden value="{{ $item->id }}" name="item_id">
                      <div class="floating-label-group mb-3">
                        <input type="text" id="roleTitle" name="job_title" class="form-control" value="{{ $item->job_title}}">
                        <label for="roleTitle">Role/Job title</label>
                      </div>

                      {{-- <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="currentPos" checked>
                        <label class="form-check-label font-weight-bold text-dark" for="currentPos">Current position</label>
                      </div> --}}

                      <div class="floating-label-group mb-3">
                        <input type="text" id="companyName" name="company" class="form-control" value="{{ $item->company}}">
                        <label for="companyName">Company</label>
                      </div>

                      <div class="form-row mb-3">
                        <div class="col-6">
                          <div class="floating-label-group">
                            <input type="text" id="location" name="location" class="form-control" value="{{ $item->location}}">
                            <label for="location">Location</label>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="floating-label-group">
                            <input type="text" id="country" name="country" class="form-control" value="{{ $item->country}}">
                            <label for="country">Country (optional)</label>
                          </div>
                        </div>
                      </div>

                      <div class="form-row mb-3">
                        <div class="col-6">
                          <div class="floating-label-group">
                      <select class="form-control custom-select" id="startMonth_<?php echo $item->id; ?>" name="start_month">
                          <?php
                          $months = [
                              'January', 'February', 'March', 'April', 'May', 'June',
                              'July', 'August', 'September', 'October', 'November', 'December'
                          ];
                          
                          foreach ($months as $month) {
                              $selected = ($item->start_month == $month) ? 'selected' : '';
                              echo "<option value=\"$month\" $selected>$month</option>";
                          }
                          ?>
                      </select>
                            <label for="startMonth">Start month</label>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="floating-label-group">
                        <select class="form-control custom-select" id="startYear_<?php echo $item->id; ?>" name="start_year">
                            <?php
                            $currentYear = date('Y');
                            $startYear = 1980;
                            $endYear = 2026;
                            
                            for ($year = $endYear; $year >= $startYear; $year--) {
                                $selected = ($item->start_year == $year) ? 'selected' : '';
                                echo "<option value=\"$year\" $selected>$year</option>";
                            }
                            ?>
                        </select>
                            <label for="startYear">Start year</label>
                          </div>
                        </div>
                      </div>

                      <div class="form-row mb-3">
                        <div class="col-6">
                          <div class="floating-label-group">
                      <select class="form-control custom-select" id="endMonth_<?php echo $item->id; ?>" name="end_month">
                          <?php
                          $months = [
                              'January', 'February', 'March', 'April', 'May', 'June',
                              'July', 'August', 'September', 'October', 'November', 'December'
                          ];
                          
                          foreach ($months as $month) {
                              $selected = ($item->start_month == $month) ? 'selected' : '';
                              echo "<option value=\"$month\" $selected>$month</option>";
                          }
                          ?>
                      </select>
                            <label for="endMonth">End month</label>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="floating-label-group">
                        <select class="form-control custom-select" id="endYear_<?php echo $item->id; ?>" name="end_year">
                            <?php
                            $currentYear = date('Y');
                            $startYear = 1980;
                            $endYear = 2026;
                            
                            for ($year = $endYear; $year >= $startYear; $year--) {
                                $selected = ($item->start_year == $year) ? 'selected' : '';
                                echo "<option value=\"$year\" $selected>$year</option>";
                            }
                            ?>
                        </select>
                            <label for="endYear">End year</label>
                          </div>
                        </div>
                      </div>

                      <div class="floating-label-group mb-2">
                        <textarea id="description" class="form-control" name="description" rows="3">{{ $item->description}}</textarea>
                        <label for="description">Description (optional)</label>
                      </div>
                      <div class="text-right text-muted small mb-3">22/1500</div>

                      <button type="submit" class="btn btn-primary btn-block rounded-pill">
                        <i class="fas fa-sparkles mr-1"></i> Save
                      </button>
                    </form>
                  </div>
                </div>
                @endforeach