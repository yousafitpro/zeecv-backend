<?php

namespace App\Models\PMM;

use Illuminate\Database\Eloquent\Model;

class PMMRats extends Model
{
    //
    public $table = 'pmm_rates';
     protected $fillable = ['symbol', 'rate'];

}
