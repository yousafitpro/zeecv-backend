<?php

namespace App\Models\Resume;

use Illuminate\Database\Eloquent\Model;
use App\Models\PMM\Product\PMMProduct;
use App\Models\UpSellItems;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resume extends Model
{
    use SoftDeletes;
    //
    protected $guarded = [];
     public $table = 'resumes';
    public function contact()
    {
        return $this->hasOne(Contact::class, 'resume_id');
    }
    public function summary()
    {
        return $this->hasOne(Summary::class, 'resume_id');
    }
    public function template()
    {
        return $this->hasOne(Template::class, 'resume_id');
    }
    public function experiences()
    {
        return $this->hasMany(Experience::class, 'resume_id');
    }
    public function educations()
    {
        return $this->hasMany(Education::class, 'resume_id');
    }
    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'resume_id');
    }
    public function languages()
    {
        return $this->hasMany(ResumeLanguage::class, 'resume_id');
    }
    public function skills()
    {
        return $this->hasMany(Skill::class, 'resume_id');
    }

}
