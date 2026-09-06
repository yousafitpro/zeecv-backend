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

class LinkedinAuthController extends Controller
{
    public function callback(Request $request)
   {
     return response()->json(['message'=>'success']);
   }
}