<?php

namespace App\Models\Pages\Page;

use App\Models\App\AppFile;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AppTrait;
use App\Traits\PM\PMTrait;

class Page extends Model
{
    use  AppTrait,HasFactory,SoftDeletes;

    public $table = 'pages';

   protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function attachment()
    {
        return $this->belongsTo(AppFile::class,'app_file_id');
    }
     public function thumbnail()
    {
        return $this->belongsTo(AppFile::class, 'thumbnail_file_id');
    }
     public function headerimg()
    {
        return $this->belongsTo(AppFile::class, 'header_img_file_id');
    }

}
