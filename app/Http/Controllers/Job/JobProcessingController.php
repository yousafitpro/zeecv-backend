<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\App\AppGoogleRecaptchaController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Job\Models\JobApplication;
use App\Http\Controllers\Job\Models\JobCareer;
use App\Http\Controllers\Job\Models\UploadedResume;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
class JobProcessingController extends Controller
{
    public function setRemoteOne(){
  JobCareer::where('remote','!=',1)
        ->where(
            'job_types',
            'like',
            '%remote%'
        )
        ->orWhere(
            'title',
            'like',
            '%remote%'
        )
        ->update(['remote'=>1]);
  JobCareer::where('is_internship','!=',1)
        ->where(
            'job_types',
            'like',
            '%intern%'
        )
        ->orWhere(
            'title',
            'like',
            '%intern%'
        )
        ->update(['is_internship'=>1]);
  JobCareer::where('is_part_time','!=',1)
        ->where(
            'job_types',
            'like',
            '%part time%'
        )
        ->orWhere(
            'title',
            'like',
            '%part time%'
        )
        ->update(['is_part_time'=>1]);
  JobCareer::where('is_full_time','!=',1)
        ->where(
            'job_types',
            'like',
            '%full time%'
        )
        ->orWhere(
            'title',
            'like',
            '%full time%'
        )
        ->update(['is_full_time'=>1]);
  JobCareer::where('is_contract','!=',1)
        ->where(
            'job_types',
            'like',
            '%contract%'
        )
        ->orWhere(
            'title',
            'like',
            '%contract%'
        )
        ->update(['is_contract'=>1]);
  JobCareer::where('is_permanent','!=',1)
        ->where(
            'job_types',
            'like',
            '%permanent%'
        )
        ->orWhere(
            'title',
            'like',
            '%permanent%'
        )
        ->update(['is_permanent'=>1]);
        return response()->json(['message'=>"processed successfully"]);
    }
}
