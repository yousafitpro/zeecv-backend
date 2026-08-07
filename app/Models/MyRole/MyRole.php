<?php

namespace App\Models\MyRole;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MyRole extends Model
{
    use HasFactory,SoftDeletes;

    protected $table='my_roles';
    protected $guarded=[];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
