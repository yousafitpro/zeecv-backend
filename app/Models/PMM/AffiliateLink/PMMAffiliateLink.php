<?php

namespace App\Models\PMM\AffiliateLink;

use App\Models\App\AppFile;
use App\Models\Connect\CustomDomain;
use App\Models\PMM\Product\PMMProduct;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AppTrait;
use App\Traits\PM\PMTrait;

class PMMAffiliateLink extends Model
{
    use  AppTrait,HasFactory,SoftDeletes;

    public $table = 'pmm_affiliate_links';

   protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function product()
    {
        return $this->belongsTo(PMMProduct::class,'product_id');
    }
        public function attachment()
    {
        return $this->belongsTo(AppFile::class,'product_image');
    }
        public function customdomain()
    {
        if(!CustomDomain::where(['link_id'=>$this->id])->exists())
        {
          CustomDomain::create(['link_id' => $this->id]);
        }

         return $this->hasOne(CustomDomain::class,'link_id');
    }
}
