<?php

namespace App\Models\PMM\Paymentprofile;

use App\Models\App\AppFile;
use App\Models\PMM\AffiliateLink\PMMAffiliateLink;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AppTrait;
use App\Traits\PM\PMTrait;

class PMMPaymentprofile extends Model
{
    use  AppTrait,HasFactory,SoftDeletes;

    public $table = 'pmm_payment_profiles';

   protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function profileidentity()
    {
        return $this->belongsTo(AppFile::class,'document_identity');
    }


}
