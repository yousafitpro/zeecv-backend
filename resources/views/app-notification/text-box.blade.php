
{{-- @if(app_notifications()['dashboard_inner'] && app_notifications()['dashboard_inner']->place=='dashboard_inner_container')
    <?php

        $bar=app_notifications()['dashboard_inner'];
        ?>
<div style="border:solid 1px lightgrey; padding: 10px; background-color: white" >
    <h4 style="font-weight: bold">{{$bar->title}}</h4>
    <small>{!! $bar->text !!}</small>
</div>
    <br>
    @endif --}}
