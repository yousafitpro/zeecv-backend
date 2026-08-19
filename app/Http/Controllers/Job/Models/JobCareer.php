<?php

namespace App\Http\Controllers\Job\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AppTrait;
class JobCareer extends Model
{
    use AppTrait,HasFactory,SoftDeletes;

    public $table = 'careers';

   protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function getCompanyNameAttribute($value)
    {
        return $this->user ? $this->user->name : $value;
    }
    // public function getDescriptionAttribute()
    // {
    //     return reset_description($this->description);
    // }
    public function getSourceAttribute($value)
    {
        return $this->user ? $this->user->name : $value;
    }
    public function applications()
    {
        return $this->hasMany(JobApplication::class,'job_id');
    }
}
