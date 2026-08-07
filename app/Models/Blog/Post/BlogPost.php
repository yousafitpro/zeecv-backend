<?php

namespace App\Models\Blog\Post;

use App\Models\App\AppFile;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AppTrait;
use App\Traits\PM\PMTrait;

class BlogPost extends Model
{
    use  AppTrait,HasFactory,SoftDeletes;

    public $table = 'blog_posts';

   protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function attachment()
    {
        return $this->belongsTo(AppFile::class,'app_file_id');
    }

}
