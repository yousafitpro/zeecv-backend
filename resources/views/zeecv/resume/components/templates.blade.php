<style>
.zeecv_template_outer .active_template {
    border: solid 2px darkred;
    border-radius: 4px;
    padding: 3px;
}
.zeecv_template_outer .temp_name h6{
 font-size: 10px;
}
.zeecv_template_outer .template-item {
    padding: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
    border-radius: 10px;
    height: 250px;
}
.template-item img{
     height: 240px;
     border-radius: 10px;
}
.zeecv_template_outer .template-item:hover {
    transform: scale(1.02);
}
    @media (max-width: 991.98px) {
        .zeecv_template_outer .template-item {
            height: 200px;
        }
        .template-item img{
            height: 190px;
        }
    }
</style>

<div style="padding: 10px;" class="zeecv_template_outer">
    <div class="row">
        @foreach ($templates as $key => $value)
            <div class="col-6 col-sm-6 col-md-6 col-lg-6 mb-3">
                <div class="template-item {{ isset($template) && $template->template == $key ? 'active_template' : '' }}">
                    <img 
                        src="{{ $value['thumbnail'] }}" 
                        data-template="{{ $key }}" 
                        onclick="updateResumeTemplate(this)" 
                        style="width: 100%; cursor: pointer;" 
                        alt="{{ $key }} template"
                    >
                </div>
                <div class="temp_name">
                    <h6 style="text-align: center;margin-top:5px;">{{ $value['name'] }}</h3>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
function updateResumeTemplate(el) {
    var template = $(el).data('template'); // or attr('data-template')
    
    $.ajax({
        url: "{{ route('resume.update.template') }}",
        type: 'POST',
        data: {
            'resume_id': "{{ request('id') }}",
            'template': template // You forgot to send the template
        },
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        beforeSend: function() {
            // Show loading state
            $(el).css('opacity', '0.5');
        },
        success: function(response) {
            // Remove active class from all
            $('.template-item').removeClass('active_template');
            // Add active class to parent
            $(el).closest('.template-item').addClass('active_template');
            LoadCVPreview()
        },
        error: function(xhr) {
            alert('Error updating template: ' + xhr.responseText);
        },
        complete: function() {
            // Remove loading state
            $(el).css('opacity', '1');
        }
    });
}
</script>