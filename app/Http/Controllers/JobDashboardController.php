<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Job\Models\JobCareer;
use App\Http\Controllers\Job\Models\JobCareerApply;
use App\Http\Controllers\Job\Models\JobCareerSaved;
use App\Models\JobPosting;
use App\Models\User;
use App\Services\GoogleIndexingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class JobDashboardController extends Controller
{
    public function index(Request $request)
    {
        $input = $request->all();
        if(empty($input['start_date']) || empty($input['end_date'])){
           $start_date=Carbon::now()->subDay()->format('Y-m-d');
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
        $userQuery = User::query();
        $applyQuery = JobCareerApply::query();
        $saveQuery = JobCareerSaved::query();

        if ($start_date && $end_date) {
            $userQuery->whereBetween('created_at', [$start_date, $end_date]);
            $applyQuery->whereBetween('created_at', [$start_date, $end_date]);
            $saveQuery->whereBetween('created_at', [$start_date, $end_date]);
        }

        $data['google_user_count'] = (clone $userQuery)->where('signup_type', 'google')->count();
        $data['custom_user_count'] = (clone $userQuery)->whereNull('signup_type')->count();
        $data['apply_count']       = (clone $applyQuery)->count();
        $data['save_count']        = (clone $saveQuery)->count();

        // Additional metrics for the dashboard
        $data['total_users'] = (clone $userQuery)->count();

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

        // Recent applications (last 5)
        $data['recent_applies']= JobCareerApply::with(['user','job'])
            ->orderBy('created_at', 'desc')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->limit(50)
            ->get();
        $data['recent_users']= User::with(['resume'])
            ->orderBy('created_at', 'desc')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->limit(50)
            ->get();
        $data['recent_saved']= JobCareerSaved::with('user','job')
            ->orderBy('created_at', 'desc')
            // ->whereBetween('created_at', [$start_date, $end_date])
            ->limit(50)
            ->get();

        // Keep the selected dates for the form
        $data['start_date'] = $start_date;
        $data['end_date']   = $end_date;
        $data['input']=$input;

        return view('admin.job.dashboard', $data);
    }
}