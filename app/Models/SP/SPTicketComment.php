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

class SPTicketComment extends Model
{
    use  AppTrait,HasFactory,SoftDeletes;

    public $table = 'sp_ticket_comments';

   protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
          public function task()
    {
        return $this->belongsTo(SPTicket::class,'ticket_id');
    }
    public function attachment()
    {
        return $this->belongsTo(AppFile::class,'app_file_id');
    }
          public function tagged_comment()
    {
        return $this->belongsTo(SPTicketComment::class,'tagged_comment_id');
    }



}
