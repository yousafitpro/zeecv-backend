<?php

namespace App\Http\Controllers\SMS;


use App\Http\Controllers\Controller;
use App\Http\Controllers\SMS\SNSController;
use Aws\Sns\SnsClient;
use Aws\Exception\AwsException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\SMS\SMSMessage;
class SMSController extends Controller
{

    public function sendSms($message, $phoneNumber,$reference_type,$reference,$user_id=null)
    {
            $sms=SMSMessage::create([
                    'user_id'=>$user_id,
                    'reference'=>$reference,
                    'reference_type'=>$reference_type,
                    'message'=>$message,
                ]);
             if($this->isValidate($phoneNumber))
             {
               (new SNSController())->sendSms($message, $phoneNumber,$sms->id);
             }

    }
    public function isValidate($phone)
    {
       try{
                $validator = Validator::make(
                ['phone' => $phone],
                ['phone' => ['required', 'regex:/^\+?[1-9]\d{1,14}$/']]
                );

                return !$validator->fails();
       }catch(\Exception $e){
         Log::channel('error_log')->error($e->getMessage());
        return false;
    }

    }

}
