<?php
use Illuminate\Support\Facades\Broadcast;
Broadcast::channel('app.alerts', function ($user, $taskId) {
    return true; // or check permissions
});
