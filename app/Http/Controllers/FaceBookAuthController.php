<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
class FaceBookAuthController extends Controller
{
    public $client_id;
    public $secret;
    public $callback;
    public function __construct()
    {
       $this->client_id=config('services.linkedin.client_id');
       $this->secret=config('services.linkedin.secret');
       $this->callback=route('linkedin.callback');
    }
    public function callback(Request $request)
   {
       return response()->json(['message'=>'success']);
   }
    public function auth(Request $request)
   {
     $url='https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id='.$this->client_id.'&redirect_uri='.$this->callback.'&scope=openid%20profile%20email';
     return redirect($url);
   }
}