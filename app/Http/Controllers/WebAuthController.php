<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetLinkMaill;
use App\Mail\RegisterMail;
use App\Models\User;
use App\Notifications\passwordChangedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;


class WebAuthController extends Controller
{
    public function reset_email()
    {

        return view('auth.passwords.email');
    }
    public function reset_email_send(Request $request)
    {
   

        if (!User::where('email',$request->email)->exists() && !is_api())
        {

            return redirect(url('login'))
                ->with([
                    'toast' => [
                        'heading' => 'Message',
                        'message' => 'Mail Sent! Check your Inbox to reset password',
                        'type' => 'success',
                    ]
                ]);
        }

        $data['token'] = str_random(80);
        User::where('email',$request->email)->update([
            'token'=>$data['token']
        ]);
        $data['user']=User::where('email',$request->email)->first();
        // try {
            Mail::to($request->email)->send(new PasswordResetLinkMaill($data));

        // }
        // catch (\Exception $e)
        // {

        //     return redirect(url('login'))
        //         ->with([
        //             'toast' => [
        //                 'heading' => 'Message',
        //                 'message' => 'Something Going Wrong',
        //                 'type' => 'error',
        //             ]
        //         ]);
        // }
        if(is_api()){
            return response()->json(['success'=>true,'message'=>'Mail Sent! Check your Inbox to reset password']);
        }
        return redirect(url('login'))
            ->with([
                'toast' => [
                    'heading' => 'Message',
                    'message' => 'Mail Sent! Check your Inbox to reset password',
                    'type' => 'success',
                ]
            ]);
    }
       public function createEmailVerification($user_id)
    {

        $data['token'] = str_random(80);
        $user=User::find($user_id);
        $user->token=$data['token'];
        $user->save();
        $data['user']=$user;
        try {
            Mail::to($user->email)->send(new RegisterMail($data));

        }
        catch (\Exception $e)
        {
            return redirect(url('login'))
                ->with([
                    'toast' => [
                        'heading' => 'Message',
                        'message' => 'Something Going Wrong',
                        'type' => 'error',
                    ]
                ]);
        }
        return redirect(url('login'))
            ->with([
                'toast' => [
                    'heading' => 'Message',
                    'message' => 'Mail Sent! Check your Inbox to activate account',
                    'type' => 'success',
                ]
            ]);
    }
    public function verify_email_address(Request $request,$token)
    {
        $user = User::where('token', $token)->first();

        if ($user) {
            $user->update([
                'token' => '12121h1h2h1h20',
                'email_verified_at' => now(),
            ]);
            
            // Login using specific guard (if you have multiple guards)
            Auth::guard('web')->login($user);
            
            // Or if using custom guard
            // Auth::guard('user')->login($user);
            return redirect(route('resume.create'))->with([
                'toast' => [
                    'heading' => 'Message',
                    'message' => 'Congrats! Account has been verified successfully',
                    'type' => 'success',
                ]
            ]);
        }

        // Handle case where user not found
        return redirect()->route('login')->with([
            'toast' => [
                'heading' => 'Error',
                'message' => 'Invalid verification token',
                'type' => 'error',
            ]
        ]);
    }
       public function verify_email(Request $request,$token)
    {
        return view('auth.passwords.reset',['token'=>$token]);
    }
    public function update_password(Request $request)
    {

        $request->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        $data['user']=User::where('token',$request->token)->first();

        // Notification::send(User::where('token',$request->token)->get(),new passwordChangedNotification($data));
        User::where('token',$request->token)->update([
            'token'=>'12121h1h2h1h20',
            'email_verified_at'=>now(),
            'password'=>bcrypt($request->password)
        ]);
        return redirect(url('login'))->with([
                'toast' => [
                    'heading' => 'Message',
                    'message' => 'Congs! password updated successfully',
                    'type' => 'success',
                ]
            ]);

    }
    public function verifyEmailAddress(Request $request)
    {


        $data['user']=User::where('token',$request->token)->first();

        // Notification::send(User::where('token',$request->token)->get(),new passwordChangedNotification($data));
        User::where('token',$request->token)->update([
            'token'=>'12121h1h2h1h20',
            'email_verified_at'=>now(),
        ]);
        return redirect(url('login'))->with([
                'toast' => [
                    'heading' => 'Message',
                    'message' => 'Congs! Account has been verified successfully',
                    'type' => 'success',
                ]
            ]);

    }
}
