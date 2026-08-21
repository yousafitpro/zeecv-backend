<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MobileAppRequestTypeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $request->merge([
            'request-type' => 'mobile-app'
        ]);

        return $next($request);
    }
}