<?php

namespace App\Models;

use App\Http\Controllers\Job\Models\UploadedResume;
use App\Models\App\AppFile;
use App\Models\Connect\CustomDomain;
use App\Models\Merchant\merchantCompany;
use App\Models\MyRole\MyUserRole;
use App\Models\PMM\PMMAddress;
use App\Traits\AppTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use AppTrait, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $appends=['image_url'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function getImageUrlAttribute($value)
    {
        return asset('images/profile/' . ($this->avatar ?: 'user-default.png'));
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function appfile()
    {
        return $this->belongsTo(AppFile::class, 'avatar');
    }
    public function avatar()
    {
            return $this->appfile->cache_file_url ?? asset('app-icons/avatar.jpg');
    }

    public function avatar_path()
    {
        return 'images/profile/'.$this->avatar;
    }

    public function balance()
    {
        return floatval($this->balance);
    }
   public function notificationSetting()
   {
       return $this->hasMany(notificationSetting::class);
   }
    public function lender()
    {
        return $this->belongsTo(self::class, 'lender_id');
    }
    public function company()
    {
        return $this->hasOne(merchantCompany::class);
    }
    public function uploadedresume()
    {
        return $this->hasOne(UploadedResume::class);
    }
    public function primaryaddress()
    {
        return $this->hasOne(PMMAddress::class,'user_id')->where('is_primary',1);
    }
    public function customdomain()
    {
        if(!CustomDomain::where('user_id',$this->id)->exists())
        {
          CustomDomain::create(['user_id' => $this->id]);
        }

        return $this->hasOne(CustomDomain::class);
    }
    public function branch()
    {
        return $this->hasOne(branch::class);
    }
    public function myRoles()
    {
        return $this->hasMany(MyUserRole::class, 'user_id','id');
    }
    public function lenderEmail()
    {
        return $this->lender ? $this->lender->email : 'N/A';
    }

    public function myUsers()
    {
        return $this->hasMany(self::class, 'lender_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function paidBills()
    {
        return $this->hasMany(PaidBill::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function myApplications()
    {
        return $this->hasMany(UserApplication::class, 'user_id');
    }

    public function scopeNotDeleted($q, $value = 0)
    {
        return $q->where('is_deleted', $value);
    }
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *bbbbb
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function routeNotificationForNexmo($notification)
    {
        return $this->phone;
    }
}
