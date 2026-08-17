<?php

namespace App\Http\Controllers\Job\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AppTrait;
class JobQuestionaire extends Model
{
    use AppTrait,HasFactory,SoftDeletes;

    public $table = 'job_questionaires';

   protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function getCompanyNameAttribute($value)
    {
        return $this->user ? $this->user->name : $value;
    }
    public function getSourceAttribute($value)
    {
        return $this->user ? $this->user->name : $value;
    }
}
