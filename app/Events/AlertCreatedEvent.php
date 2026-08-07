<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AlertCreatedEvent implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $alert;
    public $data;

    public function __construct($alert,$data)
    {
        $this->alert = $alert;
        $this->data = $data;
    }

    public function broadcastOn()
    {
        return new Channel('app.alerts');
    }
    public function broadcastAs()
    {
        return 'alert.created';
    }
}
