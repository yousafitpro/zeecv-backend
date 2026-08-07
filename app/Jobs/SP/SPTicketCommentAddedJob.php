<?php

namespace App\Jobs\SP;

use App\Events\AlertCreatedEvent;
use App\Mail\PM\PMTaskAssignedMail;
use App\Mail\PM\PMTaskCommentAddedMail;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SPTicketCommentAddedJob //implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

     protected $data=null;
     public function __construct($data)
    {
        $this->data=$data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {
  try{
       $alert= create_alert(
           $this->data['user_id'],
           $this->data['user_id'],
           "comment_added_on_task",
           $this->data['task_title'],
           "New Comment Added",
           $this->data['comment_id'],
           $this->data['redirect_url'],
        );

             event(new AlertCreatedEvent($alert,$this->data));

        // Mail::to($this->data['email'])->send(new PMTaskCommentAddedMail($this->data));
        }catch(\Exception $e){}
    }


}
