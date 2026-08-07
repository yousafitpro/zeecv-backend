<?php

namespace App\Jobs\PMM\Product;

use App\Events\AlertCreatedEvent;
use App\Http\Controllers\Connect\CONTelegramController;
use App\Mail\PM\PMTaskAssignedMail;
use App\Mail\PM\PMTaskCommentAddedMail;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PMMProductUpdatedJob implements ShouldQueue
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
           "product_updated",
           $this->data['title'],
           "Product Updated",
           $this->data['product_id'],
           $this->data['redirect_url'],
        );

        event(new AlertCreatedEvent($alert,$this->data));
       (new CONTelegramController())->sendMessageByUserID($this->data['user_id'],"Product Updated : ".$this->data['title']);
        // Mail::to($this->data['email'])->send(new PMTaskCommentAddedMail($this->data));
        }catch(\Exception $e){
            Log::channel('error_log')->error($e->getMessage());
        }
    }


}
