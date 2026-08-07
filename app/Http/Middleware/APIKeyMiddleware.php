<?php

namespace App\Http\Middleware;

use App\Models\APIKey;
use Closure;
use Illuminate\Http\Request;

class APIKeyMiddleware
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

        if(!request()->header(config('myconfig.PLATFORM.API_HEADER_PREFIX')."api-key") || !get_user_by_api_key())
        {

            return response()->json(['message'=>'Unauthorized','code'=>401],401);

        }
        return $next($request);
    }
}
