<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Stripe\StripeController;
use App\Models\Package;
use App\Models\Payment\Payment;
use App\Models\Subscription;

class PackagesController extends Controller
{
  public function subscribe(){
    $data['packages']=Package::where('status','active')->get();
    return view('packages.subscribe',$data);
  }
  public function thankyou($payment_id){
       $data['sub']=Subscription::find(unique_decrypt($payment_id));
       return view('packages.thankyou');
  }
  public function waitingpayment($payment_id){
       $data['sub']=Subscription::find(unique_decrypt($payment_id));
       return view('packages.wait_payment_in_progress');
  }
  public function unsubscribe(){
      // (new StripeController())->cancel_subscription()
      return redirect()->back()
    ->with([
        'toast' => [
            'heading' => 'Success!',
            'message' =>"Subscription canceled successfully",
            'type' => 'success',
        ]
    ]);
  }
  public function pay($id){
       $package=Package::find(unique_decrypt($id));
       $subscription=my_subscription();
       if(empty($subscription)){
        $sub=Subscription::updateOrCreate([
            'user_id'=>auth_user_id()
          ],[
            'package_id'=>$package->id,
            'status'=>'pending'
        ]);
        return (new StripeController())->createSubscription($sub->id);
        }
        
        
        
        
  }
}