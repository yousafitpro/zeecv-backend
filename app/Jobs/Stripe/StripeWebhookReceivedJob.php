<?php

namespace App\Jobs\Stripe;

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

class StripeWebhookReceivedJob implements ShouldQueue
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
        $stripe = new \Stripe\StripeClient(config('services.Stripe.sk_key'));

        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = config('services.Stripe.sign');
        $payload = $this->data['request_content'];
        $sig_header = $this->data['sig_header'];
        $event = null;
        try {
          $event = \Stripe\Webhook::constructEvent(
            $payload, $sig_header, $endpoint_secret
          );
        } catch(\UnexpectedValueException $e) {
            Log::channel('error_log')->error("Stripe Error",['message'=>$e->getMessage(),'data'=>$e]);
          // Invalid payload
          http_response_code(400);
          exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e)
        {
          // Invalid signature
          http_response_code(400);
          Log::channel('error_log')->error("Stripe Error",['message'=>$e->getMessage(),'data'=>$e]);
          exit();
        }
         Log::channel('error_log')->error("webhook received .".$event->type);

           $payment=null;
           $session = $event->data->object;
           if(Payment::where('stripe_session_id',$session->id)->exists())
           {
           $payment=Payment::where('stripe_session_id',$session->id)->first();
           }else if(Payment::where('stripe_intent_id',$session->id)->exists()){
            $payment=Payment::where('stripe_intent_id',$session->id)->first();
           }

        if($event->type=='checkout.session.completed')
          {

            $subscription_id = $session->subscription;
            $amount_total = $session->amount_total ?? 0;
            $amount_total=$amount_total/100;
            // $payment->status="Completed";
            $payment->subscription_id=$subscription_id;
            $payment->save();
            $this->dispatchOrderCompletionJob($payment->id,$amount_total);
          }
        elseif($event->type=='checkout.session.async_payment_failed')
          {
            $session = $event->data->object;
            $payment->status="Failed";
            $payment->save();
            Log::channel('error_log')->info("Payment Completed",$payment->toArray());
          }
        elseif($event->type=='checkout.session.async_payment_succeeded')
          {
            $session = $event->data->object;
            $payment->status="Succeeded";
            $payment->save();
            Log::channel('error_log')->info("Payment Completed",$payment->toArray());
          }
        elseif($event->type=='checkout.session.expired')
        {
            $session = $event->data->object;
            $payment->status="Expired";
            $payment->save();
            Log::channel('error_log')->info("Payment Completed",$payment->toArray());
        }
          elseif ($event->type === 'payment_intent.succeeded') {
               $total_amount=0;
               try{
                $intent = $event->data->object;
                if(!empty($intent))
                {
                    try{
                    Log::channel('error_log')->info("amount 1".$intent->amount_total);
                    }catch(\Exception $e){}
                                try{
                    Log::channel('error_log')->info("amount 2".$intent->amount);
                    }catch(\Exception $e){}
                    //  $total_amount = $intent->amount/100; // Amount in cents
                }
               }catch(\Exception $e){
                 Log::channel('error_log')->info("amount 2".$e->getMessage());
               }

            if ($payment) {
                // $payment->status = "Completed";
                $payment->save();
                $this->dispatchOrderCompletionJob($payment->id,$total_amount);
                Log::channel('error_log')->info("PaymentIntent succeeded", $payment->toArray());
            }
        } elseif ($event->type === 'payment_intent.payment_failed') {
            if ($payment) {
                $payment->status = "Failed";
                $payment->save();
                Log::channel('error_log')->info("PaymentIntent failed", $payment->toArray());
            }
        }
        // Handle the event


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
