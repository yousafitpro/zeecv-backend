
@if(app_notifications()['bar'] && app_notifications()['bar']->place=='home_page_top_bar')
    <?php

        $bar=app_notifications()['bar'];
        ?>
<div class="alert alert-{{$bar->type}} alert-dismissible fade show" style=" padding: 5px; border-radius: 0px" role="alert">
    <div style="text-align: center; color: {{$bar->front_color?:'grey'}};">
        <strong>{!! $bar->text !!}</strong>
    </div>
    @if($bar->is_close_able=='true')
    <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="padding: 0px; padding-right: 20px; padding-top: 5px">
        <span aria-hidden="true">&times;</span>
    </button>
        @endif
</div>

    @endif
