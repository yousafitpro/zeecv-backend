<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AppGoogleRecaptchaController extends Controller
{
    public function getScore($recaptcha_response)
    {
        $score=0;
        try{
            $recap_data=[
            'event'=>[
                'siteKey'   => config('myconfig.Recap.site_key'),
                'token' => $recaptcha_response
        ]
        ];
         // Step 2: Verify with Google
        $response = Http::post('https://recaptchaenterprise.googleapis.com/v1/projects/zeecv-505109/assessments?key='.config('myconfig.Recap.secret_key'),
        $recap_data);

        $result = $response->json();
        if(isset($result['riskAnalysis']) && isset($result['riskAnalysis']['score']))
        {
        $score=$result['riskAnalysis']['score'];
        }
        }catch(\Exception $e){}
        return $score;

    }

}
