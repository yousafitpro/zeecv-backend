<?php

namespace App\Jobs\Paysight;

use App\Events\AlertCreatedEvent;
use App\Http\Controllers\PMM\Connect\CONTelegramController;
use App\Jobs\PMM\Product\PMMProductPaymentCompletedJob;
use App\Mail\PM\PMTaskAssignedMail;
use App\Mail\PM\PMTaskCommentAddedMail;
use App\Models\Payment\Ledger;
use App\Models\Payment\Payment;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaysightWebhookReceivedJob implements ShouldQueue
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
       foreach($this->data['raw_payload'] as $pay)
       {
        if(isset($pay['transactionId']))
        {
          $payment=Payment::where('intent_id',$pay['transactionId'])->first();
          if($payment)
          {
            if(isset($pay['status']) && $pay['status']=="Approved")
            {
              $this->dispatchOrderCompletionJob($payment->id,0);
            }
            // elseif(isset($pay['status'])){
            //   $payment->status=$pay['status'];
            //   $payment->save();
            // }
            
          }
          
        }
         
       }
       


        http_response_code(200);
        }catch(\Exception $e){
            Log::channel('error_log')->error($e->getMessage());
        }
    }

    public function dispatchOrderCompletionJob($id,$amount=0)
    {
            $mailData['payment_id']=$id;
            $mailData['amount']=$amount;
            PMMProductPaymentCompletedJob::dispatch($mailData);
    }
}
