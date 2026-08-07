<?php

namespace App\Connections;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ZpaydConnection extends Controller
{


    public function __construct() {

    }

    public static function create_post($endpoint='',$data=array())
    {
        $url=config('myconfig.ZPAYD_API_URL').$endpoint.'&api_key='.config('myconfig.ZPAYD_API_KEY');
        return Http::withHeaders(['Content-Type'=>'application/json'])->get($url);
    }
    public static function create_get($endpoint='')
    {
        $url=config('myconfig.ZPAYD_API_URL').$endpoint.'&api_key='.config('myconfig.ZPAYD_API_KEY');

        $res= Http::withHeaders(['Content-Type'=>'application/json'])->get($url);
        return $res;
    }
}
