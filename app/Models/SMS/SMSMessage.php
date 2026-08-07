<?php

namespace App\Models\SMS;

use App\Traits\AppTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SMSMessage extends Model
{
    use AppTrait, HasFactory;

    public $table = 'sms_messages';

    protected $guarded=[];
}
