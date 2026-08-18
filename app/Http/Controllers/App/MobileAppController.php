<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\Resume\Resume;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class MobileAppController extends Controller
{
    public function generateLoginTokenProcess($user){
      $token = bin2hex(random_bytes(32));
      $user->login_token=$token;
      $user->save();
      return $token;
    }
    public function deleteAccount(){
      return response()->json([
        'message'=>"Account Successfully deleted"
      ]);
    }
    public function generateLoginToken()
    {
      $user=auth()->user();
      $token = $this->generateLoginTokenProcess($user);
      return response()->json(['login_token'=>$token]);
    }
    public function loginUsingToken($token)
    {
      $user=User::where('login_token',$token)->first();
      Session::put('is_app','yes');
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
