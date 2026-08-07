<?php

namespace App\Models\PMM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PMMCategory extends Model
{
    //
    use SoftDeletes;
    protected $table="pmm_categories";
     protected $fillable = ['user_id', 'name', 'status'];
}
