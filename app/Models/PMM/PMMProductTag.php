<?php

namespace App\Models\PMM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PMMProductTag extends Model
{
    //
     use SoftDeletes;
    protected $table="pmm_product_tags";
     protected $fillable = ['user_id', 'tag', 'product_id'];

}
