<?php

namespace App\Models\PMM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PMMProductCategory extends Model
{
    //
     use SoftDeletes;
     public $table = 'pmm_product_categories';
          protected $fillable = ['user_id', 'category_id', 'product_id', 'user_id'];
}
