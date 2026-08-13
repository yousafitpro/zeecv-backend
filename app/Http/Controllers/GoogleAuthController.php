<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
                'password' => bcrypt(Str::random(32)),
            ]);
        }

        Auth::login($user, true);

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'redirect' => route('dashboard'),
        ]);
    }
}