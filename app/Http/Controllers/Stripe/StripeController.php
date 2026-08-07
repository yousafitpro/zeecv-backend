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
use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;

class StripeController extends Controller
{

    public function webhook(Request $request)
    {
          $jobData['request_content']=$request->getContent();
          $jobData['sig_header']=$_SERVER['HTTP_STRIPE_SIGNATURE'];
         Log::channel('error_log')->info("webhook received");
         StripeWebhookReceivedJob::dispatch($jobData);
         return response()->json(['message'=>"success"],200);

    }

    public function success_url(Request $request,$id)
    {

        return redirect(route('frontend.product.thankyou',$id));

    }
    public function cancel_url(Request $request,$id)
    {
        $payment=Payment::find(product_decrypt($id));
        return redirect(route('pmm.product.purchase',product_encrypt($payment->reference)));

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
    public function checkout(Request $request)
    {

        $input=$request->all();

        $input['currency']="EUR";

        if($request->has('subscription'))
        {
            $url= create_stripe_subscription_payment_url($input['amount'],$input['currency'],$input['type'],auth()->user()->id,$input['plan_identity'],$request->subscription);

        }
        else
        {
        $url= create_stripe_payment_url($input['amount'],$input['currency'],$input['type'],auth()->user()->id);
        }

        return redirect($url);
    }
}
