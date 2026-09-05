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
            // Skip if admin
            if (auth()->check() && is_admin()) {
                return;
            }

            // Define allowed route names
            $allowedRoutes = [
                'home',
                'home.jobs.single',
                'home.jobs',
                'home.user.resumes',
                'home.user.profile.update',
                'home.pricing',
                'home.templates',
                'home.features',
                'home.post_a_job',
                'home.jobs.single.shot',
                'home.jobs.save',
                'home.jobs.apply.ajax',
                'home.jobs.apply',
                'home.jobs.applyProcess',
                'resume.edit',
            ];

            // Only track if current route name is in the allowed list
            if ($request->route() && $request->routeIs(...$allowedRoutes)) {
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
}