<?php

namespace App\Models\Resume;

use Illuminate\Database\Eloquent\Model;
use App\Models\PMM\Product\PMMProduct;
use App\Models\UpSellItems;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResumeLanguage extends Model
{
    use SoftDeletes;
    //
    protected $guarded = [];
     public $table = 'resume_languages';

}
