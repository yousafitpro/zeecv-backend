<?php

namespace App\Http\Controllers\SMS;


use App\Http\Controllers\Controller;
use App\Models\SMS\SMSMessage;
use Aws\Sns\SnsClient;
use Aws\Exception\AwsException;
use Illuminate\Support\Facades\Log;

class SNSController extends Controller
{

    public function sendSms($message, $phoneNumber,$sms_id)
        {
            try {
                $sns = new SnsClient([
                    'region'  => env('AWS_DEFAULT_REGION', 'us-east-1'),
                    'version' => '2010-03-31',
                    'credentials' => [
                        'key'    => env('AWS_ACCESS_KEY_ID'),
                        'secret' => env('AWS_SECRET_ACCESS_KEY'),
                    ],
                ]);
                $sms=SMSMessage::find($sms_id);
                $result = $sns->publish([
                    'Message' => $message,
                    'PhoneNumber' => $phoneNumber, // E.164 format (e.g., +923001234567)
                ]);
                $sms->processor_id=$result->get('MessageId');
                $sms->save();
                return $result->get('MessageId');
            } catch (AwsException $e) {
                Log::channel('error_log')->error("SNS SMS Error  ".$e->getMessage());
                return $e->getMessage();

            }
        }
}
