<?php

namespace App\Http\Controllers\Job\Models;

use App\Models\App\AppFile;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AppTrait;
class UploadedResume extends Model
{
    use AppTrait,HasFactory,SoftDeletes;

    public $table = 'uploaded_resumes';

   protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
        public function attachment()
    {
        return $this->belongsTo(AppFile::class,'resume_file_id');
    }
}
