<?php

namespace App\Models;

use App\Traits\AppTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alert extends Model
{
    use AppTrait, HasFactory;

    public $table = 'alerts';

    protected $guarded=[];
}
