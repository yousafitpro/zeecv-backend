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
                'home.jobs2',
                'home.jobs3',
                'home.jobs.single2',
                'home.jobs.single2',
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
                $payload=[];
                $utmSource = null;
                if ($request->query('utm_source')) {
                    $utmSource = $request->query('utm_source');
                } else {
                    // Or parse from fullUrl if you prefer
                    parse_str(parse_url($request->fullUrl(), PHP_URL_QUERY) ?? '', $query);
                    $utmSource = $query['utm_source'] ?? null;
                }
                $routeName = $request->route() ? $request->route()->getName() : null;
                $payload=[
                    'url' => $request->fullUrl(),
                    'path' => $request->path(),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'user_id' => Auth::id(),
                    'method' => $request->method(),
                    'referer' => $request->header('referer'),
                    'route_name'=>$routeName,
                    'utm_source' => $utmSource,
                    'created_at' => now(),
                ];
                Visit::create($payload);
            }
    }
}