<?php

namespace App\Models\PMM\Withdrawal;

use App\Models\App\AppFile;
use App\Models\PMM\AffiliateLink\PMMAffiliateLink;
use App\Models\PMM\Paymentprofile\PMMPaymentprofile;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AppTrait;
use App\Traits\PM\PMTrait;

class PMMWithdrawal extends Model
{
    use  AppTrait,HasFactory,SoftDeletes;

    public $table = 'pmm_widrawl_requests';

   protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function method()
    {
        return $this->belongsTo(PMMPaymentprofile::class,'payment_profile_id');
    }

}
