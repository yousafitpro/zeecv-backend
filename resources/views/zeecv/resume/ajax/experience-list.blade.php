
<div id="experienceList">

@foreach ($list as $item)
    <div class="border-bottom experience-item" data-id="{{ $item->id }}">

        <div class="p-3 bg-light d-flex justify-content-between align-items-start"
             >
             <i class="fas fa-grip-vertical text-muted mr-3 drag-handle"
                   style="cursor: move;"></i>
            <div class="flex-grow-1 pr-2">
                <h6 class="mb-0 text-dark font-weight-bold">
                    {{ $item->job_title }}
                </h6>

                <small class="text-muted">
                    {{ $item->start_month }}/{{ $item->start_year }} –
                    @if ($item->is_present == 1)
                        Present
                    @else
                        {{ $item->end_month }}/{{ $item->end_year }}
                    @endif
                </small>
            </div>

            <div class="toggle-icons-outer">

                

                <i class="far fa-trash-alt text-muted mr-2"
                   onclick="deleteExperience('{{ route('resume.experience.delete',$item->id) }}')">
                </i>

                <i class="fas fa-chevron-down text-muted action-icon icon-toggle icon-toggle-sub"
                   onclick="toggleUpDown(this)"
                   data-toggle="collapse"
                   data-target="#workForm{{ $item->id }}">
                </i>

            </div>
        </div>

        <!-- Your existing form -->
        <div id="workForm{{ $item->id }}" class="collapse p-3 bg-light">
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

            console.log('Experience order saved');

        },

        error: function (xhr) {

            console.error('Failed to save experience order');

        }

    });

}

</script>