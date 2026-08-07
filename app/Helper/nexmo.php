<?php

if ( ! function_exists('nexmo_init')) {
    function nexmo_init()
    {

            $basic = new \Vonage\Client\Credentials\Basic(config('myconfig.Nexmo.key'), config('myconfig.Nexmo.secret'));
            $client = new \Vonage\Client($basic);
            return $client;
    }
}
if ( ! function_exists('nexmo_send_sms')) {
    function nexmo_send_sms($phone,$message)
    {

        try {
            $client=nexmo_init();
            $response = $client->sms()->send(
                new \Vonage\SMS\Message\SMS($phone, '15815301607', $message)
            );

            $message = $response->current();

            if ($message->getStatus() == 0) {
                return true;
            } else {

                return false;
            }
        }catch (\Exception $e)
        {

            return false;
        }
    }
}
