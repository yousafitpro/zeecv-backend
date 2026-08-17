<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Job\Models\JobQuestionaire;

class QuestionaireController extends Controller
{
    public function process(){
        return JobQuestionaire::where('user_id',auth_user_id());
    }
    
}
