<?php

namespace App\Models\PMM\Product;

use App\Models\App\AppFile;
use App\Models\PMM\AffiliateLink\PMMAffiliateLink;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AppTrait;
use Illuminate\Support\Facades\Storage;

class PMMProductClick extends Model
{
    use AppTrait,HasFactory,SoftDeletes;

    public $table = 'pmm_product_clicks';
   protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function link()
    {
        return $this->belongsTo(PMMAffiliateLink::class,'reference')->where('reference_type','affiliate_link');
    }



}
