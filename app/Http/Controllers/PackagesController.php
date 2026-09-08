<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Stripe\StripeController;
use App\Models\Package;
use App\Models\Subscription;

class PackagesController extends Controller
{
  public function subscribe(){
    $data['packages']=Package::where('status','active')->get();
    return view('packages.subscribe',$data);
  }
  public function pay($id){
        $package=Package::find(unique_decrypt($id));
        if(Subscription::where([
          'package_id'=>$package->id,
          'user_id'=>auth_user_id(),
          'status'=>'pending'
        ])->first()){
          $sub=Subscription::where([
          'package_id'=>$package->id,
          'user_id'=>auth_user_id(),
          'status'=>'pending'
        ])->first();
        }else{
          $sub=Subscription::create([
          'package_id'=>$package->id,
          'user_id'=>auth_user_id(),
          'status'=>'pending'
        ]);
        }
        return (new StripeController())->createSubscription($sub->id);
        
  }
}