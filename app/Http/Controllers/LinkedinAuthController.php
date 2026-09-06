<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
class LinkedinAuthController extends Controller
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
        if(!empty($input['error'])){
            return redirect()->route('home.jobs');
        }
        $response = Http::asForm()->post('https://www.linkedin.com/oauth/v2/accessToken', [
        'grant_type'    => 'authorization_code',
        'code'          => $input['code'],  // The code from the callback
        'client_id'     => $this->client_id,
        'client_secret' => $this->secret,
        'redirect_uri'  => route('linkedin.callback'),
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $accessToken = $data['access_token'];
             $userInfo = Http::withToken($accessToken)
            ->get('https://api.linkedin.com/v2/userinfo')
            ->json();
        $user = User::where('email', $userInfo['email'])->first();

        if (!$user) {
            $user = User::create([
                'name' => $userInfo['name'],
                'email' => $userInfo['email'],
                'signup_type'=>'linkedin',
                'external_dp_image'=>$userInfo['picture'],
                'type'=>'User',
                'password' => bcrypt(Str::random(32)),
            ]);
        }
        Auth::login($user, true);
        $redirect_url=route('home.jobs');
        return redirect($redirect_url);
            // Store the token or use it for subsequent API calls
        }
     return redirect()->route('login');
   }
    public function auth(Request $request)
   {
     $url='https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id='.$this->client_id.'&redirect_uri='.$this->callback.'&scope=openid%20profile%20email';
     return redirect($url);
   }
}