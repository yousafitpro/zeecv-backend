                <!-- First Entry (Expanded Form) -->
            @foreach ($list as $item)
              <div class="border-bottom">
                  <div class="p-3 bg-light d-flex justify-content-between align-items-start"  style="cursor: pointer;">
                    <i class="fas fa-th text-muted drag-handle mr-2 mt-1"></i>
                    <div class="flex-grow-1 pr-2">
                      <h6 class="mb-0 text-dark font-weight-bold" id="formRoleTitle">{{ $item->skill}}</h6>
                      
                    </div>
                    <div class="toggle-icons-outer">
                      <i class="far fa-trash-alt text-muted mr-2 " onclick="deleteSkill('{{ route('resume.skill.delete',$item->id) }}')"></i>
                      {{-- <i class="fas fa-chevron-up text-muted action-icon icon-toggle" data-toggle="collapse" data-target="#EducaionForm{{ $item->id }}"></i> --}}
                    </div>
                  </div>

                  <!-- Expanded Work Item Form -->
                  <div id="EducaionForm{{ $item->id }}" class="collapse p-3 bg-light">
                    <form class="mt-1" method="post" action="{{ route('resume.skill.save') }}"  onsubmit="saveSkill(event,this)">
                      @csrf
                      <input hidden value="{{ $item->id }}" name="item_id">
                      <div class="floating-label-group mb-3">
                        <input type="text" id="skill" name="skill" class="form-control" value="{{ $item->skill}}">
                        <label for="skill">Skill</label>
                      </div>

                      <button type="submit" class="btn btn-primary btn-block rounded-pill btn-save-list">
                        <i class="fas fa-sparkles mr-1"></i> Save
                      </button>
                    </form>
                  </div>
                </div>
          @endforeach