<?php

namespace App\Models\PMM\Product;

use App\Models\App\AppFile;
use App\Models\PMM\AffiliateLink\PMMAffiliateLink;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AppTrait;
use App\Traits\PM\PMTrait;
use App\Models\PMM\PMMProductTag;
use App\Models\PMM\PMMProductCategory;
class PMMProduct extends Model
{
    use  AppTrait,HasFactory,SoftDeletes;

    public $table = 'pmm_products';

   protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function attachment()
    {
        return $this->belongsTo(AppFile::class,'app_file_id');
    }
        public function images()
    {
        return $this->hasMany(PMMProductImage::class,'product_id');
    }

    public function subscriber()
    {
        return $this->hasOne(PMMProductSubscriber::class,'product_id')->where('user_id',auth_user_id())->where('status','active');
    }
public function categories()
{
    return $this->belongsToMany(
        \App\Models\PMM\PMMCategory::class, 
        'pmm_product_categories',           
        'product_id',                      
        'category_id'                     
    );
}
    public function tags()
    {
        return $this->hasMany(PMMProductTag::class, 'product_id', 'id');
    }

}
