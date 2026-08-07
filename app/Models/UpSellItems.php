<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UpSellItems extends Model
{
    //
    protected $guarded = [];
     public $table = 'up_sell_items';

         public function upsell()
    {
        return $this->belongsTo(UppSell::class, 'upp_sell_id');
    }
}
