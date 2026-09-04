
<div id="experienceList">

            @foreach ($list as $item)
              <div class="border-bottom experience-item" data-id="{{ $item->id }}">
                  <div class="p-3 bg-light d-flex justify-content-between align-items-start"  >
                    <i class="fas fa-grip-vertical text-muted mr-3 drag-handle"
                   style="cursor: move;margin-top:5px;"></i>
                    <div class="flex-grow-1 pr-2">
                      <h6 class="mb-0 text-dark font-weight-bold" id="formRoleTitle" style="max-width: 350px">{{ $item->job_title}}</h6>
                      <small class="text-muted" id="formDateSubtitle">
                        {{ $item->start_month }}/{{ $item->start_year }} – 
                                @if ($item->is_present == 1)
                                    Present
                                @else
                                    {{ $item->end_month }}/{{ $item->end_year }}
                                @endif
                      </small>
                    </div>
                    <div class="toggle-icons-outer">
                      <i class="far fa-trash-alt text-muted mr-2 " onclick="deleteExperience('{{ route('resume.experience.delete',$item->id) }}')"></i>
                      <i class="fas fa-chevron-down text-muted action-icon icon-toggle icon-toggle-sub" onclick="toggleUpDown(this)" data-toggle="collapse" data-target="#workForm{{ $item->id }}"></i>
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

                      <div class="form-check mb-3">
                        <input type="checkbox" name="is_present" class="form-check-input" id="is_current" item-id='{{ $item->id }}' onclick="toggleIsPresent(this)" {{ $item->is_present==1?'checked':'' }}>
                        <label class="form-check-label font-weight-bold text-dark" for="currentPos">Current position</label>
                      </div>

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

                      <div class="form-row mb-3 {{ $item->is_present==1?'d-none':'' }}" id="endMonthOuter_<?php echo $item->id; ?>">
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

                      <button type="submit" class="btn btn-primary btn-block rounded-pill btn-save-list">
                        <i class="fas fa-sparkles mr-1"></i> Save
                      </button>
                    </form>
                  </div>
                </div>
          @endforeach

</div>
<script>

$(document).ready(function () {

    $("#experienceList").sortable({

        handle: ".drag-handle",

        placeholder: "sortable-placeholder",

        update: function (event, ui) {

            let order = [];

            $("#experienceList .experience-item").each(function (index) {

                order.push({
                    id: $(this).data('id'),
                    sort_order: index + 1
                });

            });

            saveSortOrder(order);
        }

    });

});

function saveSortOrder(order) {

    $.ajax({

        url: "{{ route('resume.update.sortorder') }}",

        type: "POST",

        data: {
            _token: "{{ csrf_token() }}",
            order: order,
            resume_id:'{{ $resume_id}}'
        },

        success: function (response) {

            loadExperiences();

        },

        error: function (xhr) {

            console.error('Failed to save experience order');

        }

    });

}

</script>