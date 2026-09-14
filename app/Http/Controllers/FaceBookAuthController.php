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
      $input=$request->all();
              $facebookId = $input['credential']['id'];
        $email = $input['credential']['email'];
        $name = $input['credential']['name'] ?? '';
        $avatar = $payload['picture'] ?? null;

        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'signup_type'=>'facebook',
                'signup_ip'=>$request->ip(),
                'facebook_id'=>$facebookId,
                'type'=>'User',
                'password' => bcrypt(Str::random(32)),
            ]);
        }

        $user->last_login_ip=$request->ip();
        $user->save();
        Auth::login($user, true);
        $redirect_url=route('home.jobs');
        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'redirect' => $redirect_url,
        ]);
     return redirect($url);
   }
}