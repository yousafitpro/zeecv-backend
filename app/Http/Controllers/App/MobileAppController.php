<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\Resume\Resume;
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
    public function loginUsingToken($token)
    {
      $user=User::where('login_token',$token)->first();
      if($user){
        auth()->login($user);
        $resumes=Resume::where('user_id',$user->id)->get();
        if(count($resumes)>0){
           $resu=$resumes->first();
           return redirect()->route('resume.edit',unique_encrypt($resu->id));
         
        }else{
            return redirect()->route('resume.create');
        }
      }
      return response()->json(['message'=>"unauthorized"]);
    }
}
