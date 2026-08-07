<?php

namespace App\Models;

use App\Traits\AppTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataLogs extends Model
{
    use AppTrait, HasFactory;

    public $table = 'data_logs';

    protected $guarded=[];
}
