<?php

namespace App\Models\PMM\Affiliate;

use App\Models\App\AppFile;
use App\Models\PMM\Product\PMMProduct;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AppTrait;
use App\Traits\PM\PMTrait;

class PMMAffiliate extends Model
{
    use  AppTrait,HasFactory,SoftDeletes;

    public $table = 'pmm_affiliates';

   protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
