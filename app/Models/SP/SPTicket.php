<?php

namespace App\Models\SP;

use App\Models\App\AppFile;
use App\Models\PMM\AffiliateLink\PMMAffiliateLink;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AppTrait;
use App\Traits\PM\PMTrait;

class SPTicket extends Model
{
    use  AppTrait,HasFactory,SoftDeletes;

    public $table = 'sp_tickets';

   protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function members()
    {
        return $this->hasMany(SPTicketMember::class,'ticket_id');
    }


}
