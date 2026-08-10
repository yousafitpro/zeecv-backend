<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MobileAppController extends Controller
{
    public function generateLoginToken()
    {
      $token = bin2hex(random_bytes(32));
      $user=auth()->user();
      $user->login_token=$token;
      $user->save();
      return response()->json(['login_token'=>$token]);
    }
}
