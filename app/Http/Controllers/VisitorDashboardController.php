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
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
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

        if ($start_date && $end_date) {
            $visitQuery->whereBetween('created_at', [$start_date, $end_date]);
        }

        $data['total_visit_count'] = (clone $visitQuery)->count();



        // Trend data: daily signups for the last 30 days (if no date filter)
        $days = 30;
        $trendLabels = [];
        $trendData = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $trendLabels[] = Carbon::now()->subDays($i)->format('M d');
            $count = User::whereDate('created_at', $date)->count();
            $trendData[] = $count;
        }
        $data['trend_labels'] = $trendLabels;
        $data['trend_data']   = $trendData;
        $appliedLabels = [];
        $appliedData = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $appliedLabels[] = Carbon::now()->subDays($i)->format('M d');
            $count = JobCareerApply::whereDate('created_at', $date)->count();
            $appliedData[] = $count;
        }
        $data['applied_labels'] = $appliedLabels;
        $data['applied_data']   = $appliedData;
        // Recent applications (last 5)
        $data['recent_applies']= JobCareerApply::with(['user','job'])
            ->orderBy('created_at', 'desc')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->limit(50)
            ->get();
        $data['recent_users']= User::with(['resume','contact','clicks'])
            ->orderBy('created_at', 'desc')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->limit(50)
            ->get();
        $data['recent_saved']= JobCareerSaved::with('user','job')
            ->orderBy('created_at', 'desc')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->limit(50)
            ->get();
        $data['recent_visits']= (clone $visitQuery)->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5000)
            ->get();

        // Keep the selected dates for the form
        $data['start_date'] = $start_date;
        $data['end_date']   = $end_date;
        $data['input']=$input;

        return view('admin.visit.visitor_dashboard', $data);
    }
}