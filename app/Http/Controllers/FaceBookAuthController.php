<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

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
       $input=$request->all();
       
        try {
            $fbUser = Socialite::driver('facebook')->user();
        } catch (Throwable $e) {
            logger()->error('Facebook login failed: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Facebook login failed. Please try again.');
        }

        // Facebook may not return email if user denied permission or has no email
        $email = $fbUser->getEmail();

        if (!$email) {
            return redirect()->route('login')
                ->with('error', 'We could not retrieve your email from Facebook. Please grant email permission.');
        }

     dd($email);


   }
    public function auth(Request $request)
   {
      return Socialite::driver('facebook')
            ->scopes(['email']) // request email permission
            ->redirect();
   }
    public function oldauth(Request $request)
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