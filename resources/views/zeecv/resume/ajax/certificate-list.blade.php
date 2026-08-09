                <!-- First Entry (Expanded Form) -->
            @foreach ($list as $item)
              <div class="border-bottom">
                  <div class="p-3 bg-light d-flex justify-content-between align-items-start"  style="cursor: pointer;">
                    {{-- <i class="fas fa-th text-muted drag-handle mr-2 mt-1"></i> --}}
                    <div class="flex-grow-1 pr-2">
                      <h6 class="mb-0 text-dark font-weight-bold" id="formRoleTitle">{{ $item->name}}</h6>
                      <small class="text-muted" id="formDateSubtitle">Sept 2025 – Present</small>
                    </div>
                    <div class="toggle-icons-outer">
                      <i class="far fa-trash-alt text-muted mr-2 " onclick="deleteCertificate('{{ route('resume.certificate.delete',$item->id) }}')"></i>
                      <i class="fas fa-chevron-down text-muted action-icon icon-toggle" onclick="toggleUpDown(this)" data-toggle="collapse" data-target="#CertificateForm{{ $item->id }}"></i>
                    </div>
                  </div>

                  <!-- Expanded Work Item Form -->
                  <div id="CertificateForm{{ $item->id }}" class="collapse p-3 bg-light">
                    <form class="mt-1" method="post" action="{{ route('resume.certificate.save') }}"  onsubmit="saveCertificate(event,this)">
                      @csrf
                      <input hidden value="{{ $item->id }}" name="item_id">
                      <div class="floating-label-group mb-3">
                        <input type="text" id="name" name="name" class="form-control" value="{{ $item->name}}">
                        <label for="name">Name</label>
                      </div>

                      {{-- <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="currentPos" checked>
                        <label class="form-check-label font-weight-bold text-dark" for="currentPos">Current position</label>
                      </div> --}}

                      <div class="floating-label-group mb-3">
                        <input type="text" id="organization" name="organization" class="form-control" value="{{ $item->organization}}">
                        <label for="organization">Organization</label>
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
                            <label for="startMonth">Month</label>
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
                            <label for="startYear">Year</label>
                          </div>
                        </div>
                      </div>

                      

           
                      <button type="submit" class="btn btn-primary  btn-block rounded-pill btn-save-list">
                        <i class="fas fa-sparkles mr-1"></i> Save
                      </button>
                    </form>
                  </div>
                </div>
          @endforeach