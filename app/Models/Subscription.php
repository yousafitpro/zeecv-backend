<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Payment\Payment;

class Subscription extends Model
{
    //
      protected $guarded = [];
      protected $table='susbcriptions';
       public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
       public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
       public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
