<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Payment\Payment;

class Parcel extends Model
{
    //
      protected $guarded = [];
       public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
       public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
