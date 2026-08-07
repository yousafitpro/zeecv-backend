<?php

namespace App\Models\App;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AppTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AppFile extends Model
{
    use AppTrait,HasFactory,SoftDeletes;

    public $table = 'app_files';

   protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    protected $appends = ['temp_file_url','file_url','cache_file_url'];

    // Accessor for 'file_url'
    public function getTempFileUrlAttribute()
    {
        if (!$this->path) {
            return null;
        }

        $disk = $this->disk ?? config('filesystems.default');

        if ($disk === 's3') {
            // Generate temporary URL (valid for 5 minutes)
            return Storage::disk($disk)->temporaryUrl($this->path, now()->addMinutes(5));
        }

        // Local or other disk
        return Storage::disk($disk)->url($this->path);
    }
    public function getFileUrlAttribute()
    {
        if (!$this->path) {
            return null;
        }

        $sessionKey = 'appfile-' . $this->id;
        $cache = session($sessionKey);
        $exp_time=$cache['exp_time']??0;
        // If cache exists and not expired (within 40 minutes)
        if ($cache && isset($cache['url'], $cache['exp_time'])) {
            $diffrence=time() - $exp_time;
            if ($diffrence < 600) {
                return $cache['url'];
            }
        }
        $disk = $this->disk ?? config('filesystems.default');

        if ($disk === 's3') {
            $url = Storage::disk($disk)->temporaryUrl($this->path, now()->addMinutes(50));
        } else {
            $url = Storage::disk($disk)->url($this->path);
        }
        app_update_session($sessionKey,[
            'url' => $url,
            'exp_time' => time()
        ]);
        return $url;
    }
    public function getCacheFileUrlAttribute()
    {

        if (!$this->path) {
            return null;
        }

        $sessionKey = 'appfile-' . $this->id;
        $cache = session($sessionKey);
        $exp_time=$cache['exp_time']??0;
        // If cache exists and not expired (within 40 minutes)
        if ($cache && isset($cache['url'], $cache['exp_time'])) {
            $diffrence=time() - $exp_time;
            if ($diffrence < 600) {
                return $cache['url'];
            }
        }
        $disk = $this->disk ?? config('filesystems.default');

        if ($disk === 's3') {
            $url = Storage::disk($disk)->temporaryUrl($this->path, now()->addMinutes(50));
        } else {
            $url = Storage::disk($disk)->url($this->path);
        }
        app_update_session($sessionKey,[
            'url' => $url,
            'exp_time' => time()
        ]);
        return $url;
    }

}
