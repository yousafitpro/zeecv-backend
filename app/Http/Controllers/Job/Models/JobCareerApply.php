<?php

namespace App\Http\Controllers\Job\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AppTrait;
class JobCareerApply extends Model
{
    use AppTrait,HasFactory,SoftDeletes;

    public $table = 'careers_applies';

   protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function job()
    {
        return $this->belongsTo(JobCareer::class,'job_id');
    }
    
}
