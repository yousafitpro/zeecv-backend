<?php

namespace App\Http\Controllers\Stripe;

use App\Models\GPTAssistant;
use App\Models\Package;
use App\Models\Payment\Payment;
use App\Models\UserItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\PMM\Product\PMMProductPaymentCompletedJob;
use App\Jobs\Stripe\StripeWebhookReceivedJob;
use App\Models\PMM\AffiliateLink\PMMAffiliateLink;
use App\Models\Subscription;
use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;

class StripeController extends Controller
{

    public function webhook(Request $request)
    {
          $jobData['request_content']=$request->getContent();
          $jobData['sig_header']=$_SERVER['HTTP_STRIPE_SIGNATURE'];
        //  Log::channel('error_log')->info("webhook received");
         $this->handleWebhook($jobData);
         return response()->json(['message'=>"success"],200);

    }
    public function handleWebhook($data){
                $stripe = new \Stripe\StripeClient(config('services.Stripe.sk_key'));

        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = config('services.Stripe.sign');
        $payload = $data['request_content'];
        $sig_header = $data['sig_header'];
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
    }
    public function dispatchOrderCompletionJob($id,$amount=0)
    {
          $payment=Payment::find($id);
          $payment->status='completed';
          $payment->save();
          $sub=Subscription::find($payment->app_subscription_id);
          $sub->expire_at=now()->addDays($sub->package->days);
          $sub->status='active';
          $sub->save();
    }

    public function success_url(Request $request,$id)
    {
        $sub=Subscription::find(unique_decrypt($id));
        $sub->status='processing';
        $sub->save();
        return redirect()->route('packages.thankyou',$id);

    }
    public function cancel_url(Request $request,$id)
    {
        $sub=Subscription::find(unique_decrypt($id));
        $sub->status='canceled';
        $sub->save();
        return redirect(url('/'));

    }
    function cancel_subscription(Request $request)
   {

    $payment=Payment::find($request->payment_id);
    $stripe = new StripeClient(config('services.Stripe.sk_key'));

    // Retrieve the user's active subscription (assuming it's stored in the database)

    if (!$payment) {
        return response()->json(['error' => 'No active subscription found'], 404);
    }

    // Cancel the subscription

    $subscription = $stripe->subscriptions->cancel($payment->subscription_id);

    // Update the payment record to mark it as canceled
    $payment->update(['status' => 'canceled']);
    return redirect()->back()
    ->with([
        'toast' => [
            'heading' => 'Success!',
            'message' =>"Subscription canceled successfully",
            'type' => 'success',
        ]
    ]);

   }
    public function createSubscription($sub_id)
    {
        $sub=Subscription::find($sub_id);
        // Assume you get package_id from request
        $package =$sub->package;
        // if (!$package || !$package->stripe_price_id) {
        //     return back()->withErrors('Invalid package or missing Stripe price.');
        // }

        // Get or create Stripe customer
        $user=auth()->user();
        $stripe = new StripeClient(config('services.Stripe.sk_key'));
        if (!$user->stripe_customer_id) {
            $customer = $stripe->customers->create([
                'email' => $user->email,
                'name'  => $user->name,
            ]);
            $user->stripe_customer_id = $customer->id;
            $user->save();
        }
        // Create Checkout Session
        $session = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'mode' => 'subscription',
            'line_items' => [[
                'price'    => $package->stripe_price_id,
                'quantity' => 1,
            ]],
            'customer' => $user->stripe_customer_id,
            'success_url' => route('stripeg.success_url', ['id' => unique_encrypt($sub->id)]), // you already have success_url
            'cancel_url'  => route('stripeg.cancel_url', ['id' => unique_encrypt($sub->id)]),
            'metadata' => [
                'user_id' => $user->id,
                'package_id' => $package->id,
            ],
        ]);
        // Optionally save a local Payment record with status 'pending' and store session_id
        $payment = Payment::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'app_subscription_id' => $sub->id,
            'gateway'=>'stripe',
            'stripe_session_id' => $session->id, // add this column if needed
            'status' => 'pending',
            'amount' => $package->amount,
            'currency' => 'EUR',
        ]);

        return redirect($session->url);
    }
    public function checkout(Request $request)
    {

        $input=$request->all();

        $input['currency']="EUR";


        // return redirect($url);
    }
}
