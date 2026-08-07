<?php

namespace App\Models\MyRole;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
class MyUserRole extends Model
{
    use HasFactory,SoftDeletes;

    protected $table="my_user_roles";
    protected $guarded=[];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
