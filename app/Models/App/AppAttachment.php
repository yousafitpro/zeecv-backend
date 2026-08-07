<?php

namespace App\Models\App;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AppTrait;
use Illuminate\Support\Facades\Storage;

class AppAttachment extends Model
{
    use AppTrait,HasFactory,SoftDeletes;

    public $table = 'app_attachments';
   protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function appfile()
    {
        return $this->belongsTo(AppFile::class, 'app_file_id');
    }


}
