<?php

namespace App\Models\Payment;

use App\Models\PMM\AffiliateLink\PMMAffiliateLink;
use App\Models\User;
use App\Traits\AppTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Ledger extends Model
{
    use AppTrait,HasFactory;

    public $table = 'ledger';
    protected $guarded=[];
    public function user()
    {
       return $this->belongsTo(User::class,'user_id');
    }


}
