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
        $jobQuery   = JobCareer::query()->with(['visits']);

        if ($start_date && $end_date) {
            $visitQuery->whereBetween('created_at', [$start_date, $end_date]);
            // $jobQuery->whereHas('visits', function ($query) use ($start_date, $end_date) {
            //     $query->whereBetween('created_at', [$start_date, $end_date]);
            // });
        }

        $data['total_visit_count'] = (clone $visitQuery)->count();
        $data['sources'] = Visit::whereNotNull('utm_source')
                        ->select('utm_source', DB::raw('count(*) as count'))
                        ->groupBy('utm_source')
                        ->get();



        // Trend data: daily signups for the last 30 days (if no date filter)
        $days = 30;
        $visitsByHour = Visit::whereDate('created_at', today())
            ->select(
                DB::raw('HOUR(created_at) as hour'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy(DB::raw('HOUR(created_at)'))
            ->orderBy('hour')
            ->get()
            ->keyBy('hour');

        $visits_graph_hour_labels = [];
        $visits_graph_hour_data   = [];

        for ($hour = 0; $hour < 24; $hour++) {

            $time = Carbon::today()->setHour($hour);

            $visits_graph_hour_labels[] = $time->format('h A');
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
        // $data['jobs_visits'] = (clone $jobQuery)
        //             ->withCount(['visits' => function ($q) use ($start_date, $end_date) {
        //                 // Only count visits that fall within the date range (if any)
        //                 if ($start_date && $end_date) {
        //                     $q->whereBetween('created_at', [$start_date, $end_date]);
        //                 }
        //             }])
        //             ->orderByDesc('visits_count')
        //             ->take(2)   // ← place the limit here, after sorting
        //             ->get();
          $data['jobs_visits']=[];
        // Keep the selected dates for the form
        $data['start_date'] = $start_date;
        $data['end_date']   = $end_date;
        $data['input']=$input;

        return view('admin.visit.visitor_dashboard', $data);
    }
}