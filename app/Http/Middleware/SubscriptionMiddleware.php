<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ENVController;
use App\Models\Subscription;
use App\Models\UserSetting;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class SubscriptionMiddleware
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
      $subscription=my_subscription();
      if(empty($subscription)){
        return redirect()->route('packages.subscribe');
      }
      if( !empty($subscription['is_expired']) && $subscription['is_expired'] && $subscription['sub']->status!='processing'){
        $url=route('account.index');
        return redirect($url.'?tab=subscription');
      }
      if(!empty($subscription) && $subscription['sub']->status=='processing'){
        return redirect()->route('packages.waitingpayment',unique_encrypt($subscription['sub']->id));
      }
   
      return $next($request);
    }
}
