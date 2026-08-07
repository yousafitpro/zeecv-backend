<?php

namespace App\Models\MyRole;

use App\Models\App\AppFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    use HasFactory;
    protected $fillable=['user_id','is_two_step_enabled','is_phone_verified'];
        public function actordp()
    {
        return $this->belongsTo(AppFile::class,'support_actor_image');
    }

}
