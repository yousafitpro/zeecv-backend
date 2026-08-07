<?php

namespace App\Models\PMM\Product;

use App\Models\App\AppFile;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AppTrait;
use Illuminate\Support\Facades\Storage;

class PMMProductSubscriber extends Model
{
    use AppTrait,HasFactory,SoftDeletes;

    public $table = 'pmm_product_subscribers';
   protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function product()
    {
        return $this->belongsTo(PMMProduct::class,'product_id');
    }


}
