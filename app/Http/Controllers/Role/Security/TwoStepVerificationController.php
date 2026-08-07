<?php

namespace App\Http\Controllers\Role\Security;

use App\Http\Controllers\Controller;
use App\Models\packageTransaction;
use App\Models\sms_message;
use App\Notifications\twostepverificationcode;
use App\Notifications\Role\twostepverificationcodeonemail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TwoStepVerificationController extends Controller
{

    public function email_2FA()
    {
        $user=auth()->user();
        $data['user']=$user;
        if (Request::capture()->expectsJson())
        {

            $user=auth()->user();
            $data['user']=$user;

            $data['code']=rand(10000,20000);
            $user->code=$data['code'];

            $user->notify(new twostepverificationcodeonemail($data));

            $user->save();
            return response()->json(['message'=>'Code successfully Sent to registered email.']);
        }
        if (session('login_try',0)>3)
        {
            Session::put('login_try',0);
        }
        if (session('login_try',0)==0)
        {
            $data['code'] =str_random(20);

            $user=auth()->user();
            $data['user']=$user;
            $data['code']=rand(10000,20000);
            Session::put('Code_email2FA',$data['code']);

            $user->notify(new twostepverificationcodeonemail($data));
        }


        return view('Security.verifyemail2FACode',$data);
    }
    public function index()
    {

        if(!auth()->user()->phone)
        {
            Session::put('login_email_2FA',true);
        }
        $phone=auth()->user()->phone;
        $random=random_int(1000,9999);
        $user = auth()->user();
        $user->save();
        $otp=new sms_message();
        $otp->message="Zpayd Verification Code For Admin is :".$random.".\nValid for 5 minutes";
        $otp->otp=encrypt($random);
        $otp->type='otp';
        $otp->email=auth()->user()->email;
        $otp->user_id=auth()->user()->id;
        $otp->date=today_date();
        $otp->receiver_phone=$phone;

        $otp->identifier_token=app_get_ip(\request());
        $otp->save();

        $data['otp']=zpayd_encrypt($otp->id);
        $data['o_otp']=$random;
        $data2['user']=$user;

        $data2['code']=$random;
        if (nexmo_send_sms(strval($phone),$otp->message) &&  $phone!=null)
        {
            //$otp->save();
           // return response()->json(['code'=>1,'message'=>'One Time Code successfully sent','otp'=>zpayd_encrypt($otp->id)]);
        }else
        {
            //adasd
           // return response()->json(['code'=>0,'message'=>'One Time Code cannot be sent']);
        }
        $user->notify(new twostepverificationcodeonemail($data2));
//        if (nexmo_send_sms(strval($phone),$otp->message) &&  $phone!=null)
//        {
//            $otp->save();
            return view('Security.verify2FACode',$data);
//        }else
//        {
//            //adasd
//            return response()->json(['code'=>0,'message'=>'One Time Code cannot be sent']);
//        }
    }
    public function Verify2FACode(Request $request)
    {
//        if (Request::capture()->expectsJson())
//        {
//            $user=auth()->user();
//            if ($user->code==null || $user->code!=$request->code)
//            {
//                   return response()->json(['code'=>409,'message'=>'Code is not correct']);
//            }
//
//            $user->code=null;
//            $user->save();
//            return response()->json(['code'=>200,'message'=>'Two Step verification Process Completed']);
//
//        }
//
//        if (session('Code_2FA')!=$request->code)
//        {
//            Session::put('login_try',\session('login_try',0)+1);
//
//            if (session('login_try')>3)
//            {
//                auth()->logout();
//                return redirect('login')->with([
//                    'toast' => [
//                        'heading' => 'Message',
//                        'message' => 'Sorry Login Again',
//                        'type' => 'error',
//                    ]
//                ]);
//            }
//            else
//            {
//
//                return back() ->with([
//                    'toast' => [
//                        'heading' => 'Message',
//                        'message' => 'Code is incorrect',
//                        'type' => 'error',
//                    ]
//                ]);
//            }
//
//        }
//        else
//        {
        $sms=sms_message::find(zpayd_decrypt($request->otp));
        $sms->tries=$sms->tries+1;
        $sms->save();

        if ($sms->tries>3)
        {

            if(Request::capture()->expectsJson())
            {
                auth()->logout();
                return response()->json(['code'=>'2','message'=>'Sorry! Tries Limit reached']);
            }
        }
        if(decrypt($sms->otp)!=$request->code)
        {
            if(Request::capture()->expectsJson())
            {
                return response()->json(['code'=>'0','message'=>'Sorry! OTP is not valid']);
            }
        }
        else{
            Session::put('login_2FA',true);
            return response()->json(['code'=>'1','message'=>'Successfull']);
        }
       // }

    }
    public function VerifyEmail2FACode(Request $request)
    {
        if (Request::capture()->expectsJson())
        {
            $user=auth()->user();
            if ($user->code==null || $user->code!=$request->code)
            {
                return response()->json(['code'=>409,'message'=>'Code is not correct']);
            }

            $user->code=null;
            $user->save();
            return response()->json(['code'=>200,'message'=>'Two Step verification Process Completed']);

        }

        if (session('Code_email2FA')!=$request->code)
        {
            Session::put('login_try',\session('login_try',0)+1);

            if (session('login_try')>3)
            {
                auth()->logout();
                return redirect('login')->with([
                    'toast' => [
                        'heading' => 'Message',
                        'message' => 'Sorry Login Again',
                        'type' => 'error',
                    ]
                ]);
            }
            else
            {

                return back() ->with([
                    'toast' => [
                        'heading' => 'Message',
                        'message' => 'Code is incorrect',
                        'type' => 'error',
                    ]
                ]);
            }

        }
        else
        {

            Session::put('login_email_2FA',true);

            return redirect('dashboard');
        }

    }
}
