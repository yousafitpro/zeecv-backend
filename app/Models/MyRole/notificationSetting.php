<?php

namespace App\Models\MyRole;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notificationSetting extends Model
{
    use HasFactory;
    protected $fillable=['name','title','sms','email','user_id'];
}
