<?php

namespace App\Jobs\PMM\Product;

use App\Events\AlertCreatedEvent;
use App\Http\Controllers\PMM\Connect\CONTelegramController;
use App\Http\Controllers\SMS\SMSController;
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

class PMMProductPaymentCompletedJob //implements ShouldQueue
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

        $payment=Payment::find($this->data['payment_id']);
        if($payment->status=="Completed")
        {
            return;
        }
        if($this->data['amount']==$payment->amount)
        {
            $payment->check_amount_matched=1;
        }else
        {
           $payment->check_amount_matched=0;
        }
        $payment->status="Completed";
        $payment->save();
        $link=$payment->link;
        $affiliater=$link->user;
        $product=$link->product;
        $commission_type='Flat';
        if($product->commission_type=='Percentage')
        {
          $commission_type='Percentage';
        }
        $commission_amount=$product->commission;
        if($commission_type=="Percentage")
        {
           $commission_amount = ($payment->usd_amount / 100) * $product->commission;
        }
        $merchant=$link->product->user;
        $merchant_amount=$payment->usd_amount;
        if($affiliater->id!=$merchant->id)
        {
           $merchant_amount=$payment->usd_amount-$commission_amount;
           $affiliater_amount=$commission_amount;
        }


        if($merchant)
        {
            $title=" ".$merchant_amount."$ ".$product->name;
            Ledger::create([
                'reference_type'=>'payment',
                'narration'=>'merchant product sale',
                'reference'=>$payment->id,
                'user_id'=>$merchant->id,
                'credit'=>$merchant_amount
            ]);
            $alert=create_alert(
           $merchant->id,
           $merchant->id,
           "order_payment_received",
           $title,
           "Order Payment Received",
           '',
           '',
           );

            event(new AlertCreatedEvent($alert,$this->data));
            (new CONTelegramController())->sendMessageByUserID($merchant->id,"Order Payment Received : ".$title);
            $message = "Dear customer, your order #" . unique_encrypt($payment->id) . " for " . $payment->link->product->name . " has been successfully placed. We will notify you once it is dispatched. Thank you for shopping with us!";
            (new SMSController())->sendSms($message, $payment->phone,'payment_completed',$payment->id, $merchant->id);

        }
         if($affiliater && $affiliater->id!=$merchant->id)
        {
            $title=" ".$affiliater_amount."$ ".$product->name;
            Ledger::create([
                'reference_type'=>'payment',
                'narration'=>'affiliate commission',
                'reference'=>$payment->id,
                'user_id'=>$affiliater->id,
                'credit'=>$affiliater_amount
            ]);
            $alert=create_alert(
           $affiliater->id,
           $affiliater->id,
           "order_payment_received",
           $title,
           "Order Payment Received",
           '',
           '',
           );
            event(new AlertCreatedEvent($alert,$this->data));
            (new CONTelegramController())->sendMessageByUserID($affiliater->id,"Order Commission Received : ".$title);
            $message = "Dear customer, your order #" . unique_encrypt($payment->id) . " for " . $payment->link->product->name . " has been successfully placed. We will notify you once it is dispatched. Thank you for shopping with us!";
            (new SMSController())->sendSms($message, $payment->phone,'payment_completed',$payment->id, $merchant->id);


        }




        // Mail::to($this->data['email'])->send(new PMTaskCommentAddedMail($this->data));
        }catch(\Exception $e){

            Log::channel('error_log')->error($e->getMessage());
        }
    }


}
