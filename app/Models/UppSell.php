<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PMM\Product\PMMProduct;
use App\Models\UpSellItems;
class UppSell extends Model
{
    //
    protected $guarded = [];
     public $table = 'product_upp_sell';
     public function product() {
    return $this->belongsTo(PMMProduct::class, 'product_id');
}
public function items() {
    return $this->hasMany(UpSellItems::class);
}
}
