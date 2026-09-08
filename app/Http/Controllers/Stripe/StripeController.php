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
         StripeWebhookReceivedJob::dispatch($jobData);
         return response()->json(['message'=>"success"],200);

    }

    public function success_url(Request $request,$id)
    {
        $sub=Subscription::find(unique_decrypt($id));
        $sub->status='processing';
        $sub->save();
        return view('packages.thankyou');

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
