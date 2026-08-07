<?php

namespace App\Models\PMM\CC;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class PmmOrderNote extends Model
{
    //
     protected $table = 'pmm_order_notes';

    protected $fillable = [
        'user_id',
        'status',
        'payment_id',
        'type',
        'call_start',
        'call_end',
        'note',
    ];
public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

}
