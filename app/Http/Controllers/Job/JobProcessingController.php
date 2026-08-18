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
        $list=JobCareer::where('remote','!=',1)
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
        return response()->json(['message'=>"processed successfully"]);
    }
}
