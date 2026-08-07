<?php

namespace App\Http\Middleware;

use App\Models\MyRole\notificationSetting;
use App\Models\User;
use App\Models\MyRole\UserSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TwoStepVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {


         // Define URLs or prefixes to exclude
        $excludedUrls = [
            'login',
            'logout',
            'register',
            'security/*',
            'zpayd-cron-jobs/*',
        ];

        // Check if the current URL matches any excluded URL or prefix
        foreach ($excludedUrls as $url) {
            if ($request->is($url)) {
                return $next($request); // Skip middleware and continue request processing
            }
        }
        if (auth()->check())
        {
            $setting = UserSetting::firstOrCreate(
                ['user_id' => auth()->user()->id],
                ['is_two_step_enabled' => 'true'] // default value if new record is created
            );
            if ($setting->is_two_step_enabled == "false") {
                Session::put("login_2FA", true);
                Session::put("login_email_2FA", true);
            }
            $notification = notificationSetting::firstOrCreate(
                [
                    'name' => 'two_step_verification',
                    'user_id' => auth()->user()->id,
                ],
                [
                    'sms' => 'no', // default value if new record is created
                    'email' => 'no' // default value if new record is created
                ]
            );

            if (!session('login_2FA', false) && $notification->sms === 'yes') {
                return redirect('security/2FA');
            }
            if (!session('login_email_2FA',false) && $notification->email=='yes')
            {
                return redirect('security/email/2FA');
            }



        }



        return $next($request);
    }
}
