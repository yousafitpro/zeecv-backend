<?php

namespace App\Models\PMM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PMMAddress extends Model
{
    use SoftDeletes;
    protected $table="pmm_addresses";
     protected $guarded = [];
}
