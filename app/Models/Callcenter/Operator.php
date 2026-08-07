<?php

namespace App\Models\Callcenter;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AppTrait;

class Operator extends Model
{
    use AppTrait,HasFactory,SoftDeletes;

    public $table = 'pmm_operators';

   protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
