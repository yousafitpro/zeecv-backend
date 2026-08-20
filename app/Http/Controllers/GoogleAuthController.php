<?php

namespace App\Http\Controllers;

use App\Http\Controllers\App\MobileAppController;
use App\Http\Controllers\Controller;
use App\Models\Resume\Resume;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Google\Client as GoogleClient;

class GoogleAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'credential' => 'required|string',
        ]);

        $client = new GoogleClient([
            'client_id' => config('services.google.client_id'),
        ]);
        $payload = $client->verifyIdToken($request->credential);

        if (!$payload) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Google token.',
            ], 401);
        }

        $googleId = $payload['sub'];
        $email = $payload['email'];
        $name = $payload['name'] ?? '';
        $avatar = $payload['picture'] ?? null;

        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'type'=>'User',
                'password' => bcrypt(Str::random(32)),
            ]);
        }

        Auth::login($user, true);
        $redirect_url=route('home.jobs');
        // $resumes=Resume::where('user_id',$user->id)->get();
        // if(count($resumes)>0){
        //    $resu=$resumes->first();
        //    $redirect_url=route('resume.edit',unique_encrypt($resu->id));
         
        // }else{
        //     $redirect_url=route('resume.create');
        // }
        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'redirect' => $redirect_url,
        ]);
    }
    public function appSignup(Request $request)
    {
        $input=$request->all();
        // $request->validate([
        //     'credential' => 'required|string',
        // ]);

        // $client = new GoogleClient([
        //     'client_id' => config('services.google.client_id'),
        // ]);
        // $payload = $client->verifyIdToken($request->credential);

        // if (!$payload) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Invalid Google token.',
        //     ], 401);
        // }

        // $googleId = $payload['sub'];
        $email = $input['email'];
        $name = $input['name'] ?? '';
        $password = $input['password'] ?? '';

        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'type'=>'User',
                'password' => $password,
            ]);
        }

        // Auth::login($user, true);
        // $redirect_url=route('home.jobs');
        // $resumes=Resume::where('user_id',$user->id)->get();
        // if(count($resumes)>0){
        //    $resu=$resumes->first();
        //    $redirect_url=route('resume.edit',unique_encrypt($resu->id));
         
        // }else{
        //     $redirect_url=route('resume.create');
        // }


       
        $user=User::where('email',$request->email)->first();
        $token = auth('api')->login($user);
        return response()->json([
            'success' => true,
            'token' => $token,
            'loginToken'=>(new MobileAppController())->generateLoginTokenProcess($user),
            'name' => $user->name,
            'email' => $user->email,
            'id' => $user->id,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Login successful.'
        ]);
    }
}