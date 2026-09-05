<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Job\Models\JobCareer;
use App\Http\Controllers\Job\Models\JobCareerApply;
use App\Http\Controllers\Job\Models\JobCareerSaved;
use App\Models\ContactQuery;
use App\Models\JobPosting;
use App\Models\Resume\Contact;
use App\Models\User;
use App\Models\Visit;
use App\Services\GoogleIndexingService;
use Carbon\Carbon;
use Google\Service\AnalyticsData\OrderBy;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class VisitorDashboardController extends Controller
{
    public function index(Request $request)
    {
        $input = $request->all();
        if(empty($input['start_date']) || empty($input['end_date'])){
           $start_date=Carbon::now()->format('Y-m-d');
           $end_date=Carbon::now()->addDay()->format('Y-m-d');
           $input['start_date']=$start_date;
           $input['end_date']=$end_date;
        }
        else
        {
            $start_date = $input['start_date'];
            $end_date   = $input['end_date'];
        }
        

        // Base queries with optional date filter
        $visitQuery = Visit::query();
        $jobQuery = JobCareer::query()->take(1)->with(['visits']);

        if ($start_date && $end_date) {
            $visitQuery->whereBetween('created_at', [$start_date, $end_date]);
            $jobQuery->whereHas('visits', function ($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            });
        }

        $data['total_visit_count'] = (clone $visitQuery)->count();
        $data['sources'] = Visit::whereNotNull('utm_source')
                        ->select('utm_source', DB::raw('count(*) as count'))
                        ->groupBy('utm_source')
                        ->get();



        // Trend data: daily signups for the last 30 days (if no date filter)
        $days = 30;
        // How many hours to look back
        $hours = 24;

        // Start time (12 hours ago from now)
        $start = Carbon::now()->subHours($hours);

        // Query visits within this period, grouped by hour-of-day (0-23)
        $visitsByHour = Visit::where('created_at', '>=', $start)
            ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('count(*) as count'))
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->keyBy('hour');

        // Build labels and data for each hour in the 12-hour window
        $visits_graph_hour_labels = [];
        $visits_graph_hour_data   = [];

        for ($i = $hours - 1; $i >= 0; $i--) {
            // The exact time for this hour slot, going backwards from now
            $time = Carbon::now()->subHours($i);
            $hour = (int) $time->format('H');  // hour number 0-23
            $label = $time->format('H');    // e.g. "03:00"

            $visits_graph_hour_labels[] = $label;
            $visits_graph_hour_data[]   = $visitsByHour->get($hour)?->count ?? 0;
        }

        $data['hour_labels'] = $visits_graph_hour_labels;
        $data['hour_data']   = $visits_graph_hour_data;


        $monthlyVisitLabels = [];
        $monthlyVisitData = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $monthlyVisitLabels[] = Carbon::now()->subDays($i)->format('M d');
            $count = Visit::whereDate('created_at', $date)->count();
            $monthlyVisitData[] = $count;
        }
        $data['monthly_visit_labels'] = $monthlyVisitLabels;
        $data['monthly_visit_data']   = $monthlyVisitData;
        // Recent applications (last 5)
 
        $data['recent_visits']= (clone $visitQuery)->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(500)
            ->get();
        $data['jobs_visits']= (clone $jobQuery)
            ->withCount('visits')
            ->orderByDesc('visits_count')
            ->get();

        // Keep the selected dates for the form
        $data['start_date'] = $start_date;
        $data['end_date']   = $end_date;
        $data['input']=$input;

        return view('admin.visit.visitor_dashboard', $data);
    }
}