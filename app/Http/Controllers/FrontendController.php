<?php

namespace App\Http\Controllers;

use App\Http\Controllers\App\AppGoogleRecaptchaController;
use App\Http\Controllers\paysight\PaysightController;
use App\Models\MyRole\MyRole;
use App\Models\MyRole\MyUserRole;
use App\Models\MyRole\UserSetting;
use App\Models\Payment\Payment;
use App\Models\PMM\Affiliate\PMMAffiliate;
use App\Models\PMM\AffiliateLink\PMMAffiliateLink;
use App\Models\PMM\Merchant\PMMMerchant;
use App\Models\PMM\Product\PMMProduct;
use App\Models\User;
use App\Notifications\passwordChangedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\PMM\PMMRats;
use Illuminate\Support\Facades\Http;

class FrontendController extends Controller
{
    public $theme_url='frontend/themes/eshoper/';

    public function index()
    {
        $data['products'] = PMMProduct::latest()->take(20)->where('status','active')->get(); // 20 latest
        $data['random_products'] = PMMProduct::inRandomOrder()->take(9)->where('status','active')->get();
        $path = public_path('themes/eshoper/images/home/hero.webp');  // local file path
        $mime = mime_content_type($path);           // e.g. image/webp
        $base64 = base64_encode(file_get_contents($path));
        $data['dataUri'] = "data:$mime;base64,$base64";

        return view(theme_url().'index',$data);
    }
        public function shop()
    {
        $data['products'] = PMMProduct::latest()->where('status','active')->take(20)->get(); // 20 latest
        $data['random_products'] = PMMProduct::inRandomOrder()->where('status','active')->take(9)->get();
        return view(theme_url().'shop',$data);
    }
    public function thankyou(Request $request,$id)
    {
        $data['payment']=Payment::find(product_decrypt($id));
        if(empty($data['payment']) || $data['payment']->is_thankyou_done==1)
        {
            return redirect()->back();
        }
        $data['link']=PMMAffiliateLink::where('id',$data['payment']->reference)->first();
        $data['payment']->is_thankyou_done=1;
        $data['payment']->save();
       return view(theme_url().'thankyou',$data);
    }
    public function notFound(Request $request)
    {
      return view(theme_url().'product-not-found');
    }
    public function checkoutProcess(Request $request,$id)
    {
        $input=$request->all();
        // $score=(new AppGoogleRecaptchaController())->getScore($input['g-recaptcha-response']);
        // if($score<0.7)
        // {
        //   return response()->json(['code'=>0,'message'=>"Invalid recaptcha"]);
        // }
            $validator = Validator::make($input, [
                'name' => 'required|string|max:255',

                // Accepts phone numbers like +923001234567 or +1345345345
                'phone' => [
                    'required'
                ],

                'email' => 'required|email|max:255',

                'quantity' => 'required|integer|min:1',

                'address' => 'required|string|max:500',
            ], [
                'phone.required' => 'The phone number is required.',
            ]);
// 'phone.regex' => 'The phone number must include a valid country code, e.g., +14155552671.',
        if ($validator->fails()) {
            $firstError = $validator->errors()->first();
            return response()->json(['code'=>0,'message'=>$firstError]);
        }
        $affiliateLink = PMMAffiliateLink::find(product_decrypt($id));
        if (!$affiliateLink) {
            return back()->withErrors(['Invalid affiliate link.']);
        }

        // Get the associated product
        $product = PMMProduct::find($affiliateLink->product_id);

        if (!$product) {
            return back()->withErrors(['Product not found.']);
        }

        // Calculate commission
        $commission = ($product->price / 100) * $product->commission;

        $input['amount'] = $product->price*$input['quantity'];
        if($product->crouncy!='USD'){
            $rate = PMMRats::where('symbol', 'USD/'.$product->crouncy)->value('rate');
            $input['local_amount'] = $input['amount'] * ($rate ?? 1);
        }else
        {
           $input['local_amount'] = $input['amount']; 
        }

            $data['symbol']=$product->crouncy;
        $input['currency']=$product->crouncy;
        $input['type']="product";
        $result= create_stripe_payment_intent($input['amount'],$input['currency'],$input['type'],$affiliateLink->user_id,'affiliate_link',$affiliateLink->id,$product->name);
        $payment=Payment::find($result['id']);
        $payment->name=$request->name;
        $payment->amount=$input['amount'];
        $payment->local_amount=$input['local_amount'];
        $payment->email=$request->email;
        $payment->city=$request->city;
        $payment->country=$request->country??'';
        $payment->postalcode=$request->postal_code;
        $payment->phone=$request->phone;
        $payment->quantity=$request->quantity;
        $payment->address=$request->address;
        $payment->save();

        $success_url=route('frontend.product.thankyou',product_encrypt($result['id']));
        return response()->json(['code'=>1,'success_url'=>$success_url,'client_secret'=>$result['client_secret'],'message'=>"Order successfully Created",'amount'=>$payment->amount,'product_name'=>$product->name,'currency'=>'usd','country'=>'US']);


    }
    public function paysightCheckoutSaveAfterInfo(Request $request,$id)
    {
            $payment=Payment::find(unique_decrypt($id));
            $payment->session_id=$request->paysightSession;
            $payment->intent_id=$request->transactionId;
            $payment->save();
            if($payment->save())
            {
                return response()->json(['code'=>'1','message'=>'saved']);
            }
            
    }
    public function paysightCheckoutProcessIframe(Request $request)
    {
        $input=$request->all();
        $payment=Payment::find(unique_decrypt($input['transactionId']));
       return response()->json((new PaysightController())->APICheckout($input,$payment));
      
    }
    public function paysightCheckoutProcess(Request $request,$id)
    {
        //asdasd
        $input=$request->all();
        // $score=(new AppGoogleRecaptchaController())->getScore($input['g-recaptcha-response']);
        // if($score<0.7)
        // {
        //   return response()->json(['code'=>0,'message'=>"Invalid recaptcha"]);
        // }
            $validator = Validator::make($input, [
                'name' => 'required|string|max:255',

                // Accepts phone numbers like +923001234567 or +1345345345
                'phone' => [
                    'required'
                ],

                // 'email' => 'required|email|max:255',

                'quantity' => 'required|integer|min:1',
            ], [
                'phone.required' => 'The phone number is required.',
            ]);
// 'phone.regex' => 'The phone number must include a valid country code, e.g., +14155552671.',
        if ($validator->fails()) {
            $firstError = $validator->errors()->first();
            return response()->json(['code'=>0,'message'=>$firstError]);
        }
        $affiliateLink = PMMAffiliateLink::find(product_decrypt($id));
        if (!$affiliateLink) {
            return back()->withErrors(['Invalid affiliate link.']);
        }

        // Get the associated product
        $product = PMMProduct::find($affiliateLink->product_id);

        if (!$product) {
            return back()->withErrors(['Product not found.']);
        }

        // Calculate commission
        $commission = ($product->price / 100) * $product->commission;

        $input['amount'] = $product->price*$input['quantity'];
            
            // convert to USD
            if($product->crouncy!='USD')
                {
                    $usd_rate = PMMRats::where('symbol',$product->crouncy.'/USD')->value('rate');
                    $input['usd_amount'] = $input['amount'] * ($usd_rate ?? 1);
                }else
                {
                    $input['usd_amount'] = $input['amount'];    
                }
            if($product->crouncy!='USD')
                {
                    $rate = PMMRats::where('symbol', 'USD/'.$product->crouncy)->value('rate');
                    $input['local_amount'] = $input['usd_amount'] * ($rate ?? 1);
                }else
                { 
                     $input['local_amount'] = $input['usd_amount'];   
                }
             $input['local_amount']=round($input['local_amount'],2);
            $data['symbol']=$product->crouncy;
        $input['currency']=$product->crouncy;
        $input['type']="product";

        $base_url=config('myconfig.Paysight.BASIC_URL');
        $product_id=config('myconfig.Paysight.PRODUCT_ID');
        $api_key=config('myconfig.Paysight.API_KEY');
        $client_id=config('myconfig.Paysight.CLIENT_ID');
        // $headers=[
        //     "Authorization"=>$api_key,
        //     "ClientId"=>$client_id,
        //     "UserEmail"=>"sandbox@paysight.io",
        //     "Content-Type"=>"application/json"
        // ];
        // $request_body=[
        //     "paysightSession"=>null,
        //     "partnerSession"=>"abcd".rand(1231,34343434),
        //     "card"=>[
        //         "name"=> "John Smith",
        //         "pan"=> "4111111111111118",
        //         "expiryMonth"=> 12,
        //         "expiryYear"=> 2029,
        //         "cvv"=> "333"
        //     ],
        //     "email"=> "yousaf.itpro8@gmail.com",
        //     "amount"=> 1.00
        // ];
        // $base_url=$base_url.'/'.$product_id;
        // $http=Http::withHeaders($headers)->post($base_url,$request_body);
        // dd($base_url,$headers,$request_body,$http->json());
         $result= create_paysight_payment_intent($input['amount'],$input['currency'],$input['type'],$affiliateLink->user_id,'affiliate_link',$affiliateLink->id,$product->name);
        $payment=Payment::find($result['id']);
        $payment->name=$request->name;
        $payment->amount=$input['amount'];
        $payment->local_amount=$input['local_amount'];
        $payment->usd_amount=$input['usd_amount'];
        $payment->email=$request->email;
        $payment->city=$request->city;
        $payment->country=$request->country??'';
        $payment->postalcode=$request->postal_code;
        $payment->state=$request->state;
        $payment->phone=$request->phone;
        $payment->quantity=$request->quantity;
        $payment->address=$request->address;
        $payment->save();

        $success_url=route('frontend.product.thankyou',product_encrypt($result['id']));
        return response()->json(['code'=>1,'new_payment_id'=>unique_encrypt($payment->id),'success_url'=>$success_url,'product_id'=>(int)$product_id,'message'=>"Order successfully Created",'payment'=>$payment,'product_name'=>$product->name,'currency'=>'usd','country'=>'US']);


    }
     public function viewProduct(Request $request,$id)
     {
        $ref_trans=null;
         $product = PMMProduct::with(['images'])->find(product_decrypt($id));
        $affiliateLink = $afl=get_affiliate_link($product->user_id,$product->id);
        if (!$affiliateLink) {
            return back()->withErrors(['Invalid affiliate link.']);
        }

        // Get the associated product


        if (empty($product) || $product->status=='inactive') {
            return redirect(route('frontend.product.notfound'));
        }

        // Calculate commission
        $commission = ($product->price / 100) * $product->commission;

        // Calculate total amount (price + commission)
        $input['amount'] = $product->price ;
        $input['currency']="USD";
        $input['type']="product";
        $data['product']=$product;
        $data['link']=$affiliateLink;


        return view(theme_url().'product.detail',$data);
     }
     public function productUrl(Request $request,$id)
    {
       $product=PMMProduct::find(product_decrypt($id));
        $url=affiliate_link($product->user_id,$product->id);
        return redirect($url);
    }
       public function terms(Request $request)
    {
        return view(theme_url().'terms');
    }
           public function refundPolicy(Request $request)
    {
        return view(theme_url().'refund-policy');
    }
           public function privacy(Request $request)
    {
        return view(theme_url().'privacy');
    }
    public function signup(Request $request)
    {
        return view('frontend.signup');
    }
        public function signupPost(Request $request)
    {
       $input=$request->all();

        $score=(new AppGoogleRecaptchaController())->getScore($input['g-recaptcha-response']);
        if($score<0.7)
        {
           return redirect()->back()->withInput()->with([
                'toast' => [
                    'heading' => 'Message',
                    'message' => 'Invalid recaptcha',
                    'type' => 'danger',
                ]
            ]);
        }
      $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&]).+$/'
            ],
            ], [
                'password.regex' => 'Password must contain at least one lowercase letter, one uppercase letter, one number, and one special character.',
                'password.min' => 'Password must be at least 8 characters long.',
            ]);

         DB::beginTransaction();
        // Create user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'type'    => "User",
            'password' => Hash::make($request->password),
            'email_verified_at'=>null
        ]);

      
     $setting = UserSetting::firstOrCreate(
                ['user_id' => $user->id],
                ['is_two_step_enabled' => 'false'] // default value if new record is created
            );

        // Auto-login the user
        (new WebAuthController())->createEmailVerification($user->id);
        DB::commit();
        return redirect(url('please-verify-account'));
    }

}
