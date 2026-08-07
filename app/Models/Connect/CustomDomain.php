<?php

namespace App\Models\Connect;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AppTrait;

class CustomDomain extends Model
{
    use AppTrait,HasFactory,SoftDeletes;

    public $table = 'con_customdomains';

   protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
     public function link()
    {
        return $this->belongsTo(User::class,'link_id');
    }
}
