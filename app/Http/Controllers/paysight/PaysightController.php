<?php

namespace App\Http\Controllers\paysight;

use App\Models\GPTAssistant;
use App\Models\Package;
use App\Models\Payment\Payment;
use App\Models\UserItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Paysight\PaysightWebhookReceivedJob;
use App\Jobs\PMM\Product\PMMProductPaymentCompletedJob;
use App\Jobs\Stripe\StripeWebhookReceivedJob;
use App\Models\DataLogs;
use App\Models\MyRole\UserSetting;
use App\Models\PMM\AffiliateLink\PMMAffiliateLink;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;

class PaysightController extends Controller
{

    //sdsdsdasas
    public function webhook(Request $request)
    {
        $input=$request->all();
        $raw_payload['raw_payload']=$input['raw_payload'];
        Log::channel('error_log')->info("webhook received",$raw_payload);
        PaysightWebhookReceivedJob::dispatch($raw_payload);
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
 
    public function APICheckout($input, $payment)
    {
        $setting = UserSetting::firstOrCreate([
                'user_id' =>who_is_admin()
            ]);
        $product_id=$setting->paysigh_product_id;
        if(isset($input['is_test']) && $input['is_test']=='true')
        {
            $product_id=$setting->paysigh_test_product_id;
        }
        $api_key=config('myconfig.Paysight.API_KEY');
        $env=config('myconfig.Paysight.ENV');

        $url='https://secure.paysight.io/api/'.$product_id;
        if($env=='sandbox' || $input['mode']=='sandbox')
        {
           $url='https://test.paysight.io/api/'.$product_id; 
        }
        // dd($url);
        $exp=explode('/',$input['exp']);
        $name=explode(' ',$payment->name);
        // $name[0]='Soha';
        // $name[1]='Ransd';
        // $card_pan='4242424242424242';
        $card_pan=$input['card'];
        $partner_session='payment-'.$payment->id.'-'.rand(12345,56789343);
        $datalog_data['product_id']=$product_id;
        $datalog=DataLogs::create([
            'reference'=>$payment->id,
            'type'=>'paysigh-iframe-payment'
            ]
        );
        $datalog->payload=json_encode($datalog_data);
        try{
            
            //sdsdf
            $email = $payment->email;
            [$ename, $domain] = explode('@', $email);
            $random = rand(1000, 9999);
            $newEmail = $ename . 'scalify' . $random . '@' . $domain;
            if(isset($input['is_test']) && $input['is_test']=='true')
              {
                $newEmail=$payment->email;
              }
            // dd($newEmail);
            $ipAddress = request()->ip();
            $userAgent = request()->userAgent();
            $request_payload=[
            'partnerSession'=>$partner_session,
            'ip'=>$ipAddress,
            'useragent'=>$userAgent,
            'email'=>$newEmail,
            'phone'=>$payment->phone,
            'address'=>[
                'firstName'=>$name[0],
                'lastName'=>$name[1],
                'city'=>$payment->city,
                'zip'=>$payment->postalcode,
                'country'=>$payment->country,
                'street'=>$payment->address,
            ],
            'shippingAddress'=>[
                'firstName'=>$name[0],
                'lastName'=>$name[1],
                'city'=>$payment->city,
                'zip'=>$payment->postalcode,
                'country'=>$payment->country,
                'street'=>$payment->address,
            ],
            'amount'=>$payment->usd_amount,
            'card'=>[
                'name'=>$name[0].' '.$name[1],
                'pan'=>trim($card_pan),
                'expiryMonth'=>trim($exp[0]),
                'expiryYear'=>trim($exp[1]),
                'cvv'=>trim($input['cvc']),
                'bin'=>$input['card_bin'],
                'brand'=>$input['card_brand'],
                'lastFour'=>$input['card_last_four']
            ],
        ];
        if($payment->country=='US')
        {
            $request_payload['address']['state']=$payment->state;
            $request_payload['shippingAddress']['state']=$payment->state;
        }
        $headers=[
            'ClientId'=>'409',
            'Authorization'=>$api_key.'oo',
            'UserEmail'=>'admin@scalifypro.net',
            'Content-Type'=>'application/json',
        ];
        // return ['code'=>'1','message'=>'Transaction successful'];
        // return ['code'=>'0','message'=>'Transaction failed']; 
        // dd($url,$headers,$request_payload);
        $datalog_data['request']=$request_payload;
        $datalog->payload=json_encode($datalog_data);
        $datalog->save();
        $http=Http::withHeaders($headers)->post($url,$request_payload);
        $res=$http->json();
        $rr_data['json']=$res;
        $rr_data['body']=$http->body();
        $rr_data['status']=$http->status();
        $rr_data['successful']= $http->successful();
        $payment->processor_response=json_encode($rr_data);
        $r_data['request_payload']=$request_payload;
        $r_data['base_url']=$url;
        $payment->request_payload=json_encode($r_data);
        $payment->save();
        $datalog_data['request']=$r_data;
        $datalog_data['response']=$rr_data;
        $datalog->payload=json_encode($datalog_data);
        $datalog->save();
        //   dd($url,$headers,$request_payload,$http->status(),$res);
        if($res['subscribeSuccess'] || $res['chargeSuccess'])
        {
            $payment->session_id=$res['paysightSession']??'';
            $payment->intent_id=$res['transactionId']??'';
            $payment->save();
            return ['code'=>'1','message'=>'Transaction successful'];
        }else
        {
            $error_message='Transaction failed';
            if(isset($res['error']))
            {
                $error_message=$error_message.' : '.$res['error'];
            }
          return ['code'=>'0','message'=>$error_message];  
        }
        }catch(\Exception $e){
        $datalog_data['error_message']=$e->getMessage();
        $datalog_data['error_code']=$e->getCode();
        $datalog->payload=json_encode($datalog_data);
        $datalog->save();  
        }
            
       
    }
}
