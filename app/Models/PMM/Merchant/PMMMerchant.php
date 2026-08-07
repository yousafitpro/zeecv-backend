<?php

namespace App\Models\PMM\Merchant;

use App\Models\App\AppFile;
use App\Models\PMM\Product\PMMProduct;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AppTrait;
use App\Traits\PM\PMTrait;

class PMMMerchant extends Model
{
    use  AppTrait,HasFactory,SoftDeletes;

    public $table = 'pmm_merchants';

   protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
