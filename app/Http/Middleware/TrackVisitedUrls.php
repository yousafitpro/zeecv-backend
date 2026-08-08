<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visit;
use Illuminate\Support\Facades\Auth;

class TrackVisitedUrls
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Store the visit data
        $this->storeVisit($request);

        return $next($request);
    }

    /**
     * Store the visited URL, IP, and timestamp.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function storeVisit($request)
    {
        Visit::create([
            'url' => $request->fullUrl(),
            'path' => $request->path(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'user_id' => Auth::id(),
            'method' => $request->method(),
            'referer' => $request->header('referer'),
            'created_at' => now(),
        ]);
    }
}