<?php

namespace App\Models\Resume;

use Illuminate\Database\Eloquent\Model;
use App\Models\PMM\Product\PMMProduct;
use App\Models\UpSellItems;
class Resume extends Model
{
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
    public function experiences()
    {
        return $this->hasMany(Experience::class, 'resume_id');
    }

}
