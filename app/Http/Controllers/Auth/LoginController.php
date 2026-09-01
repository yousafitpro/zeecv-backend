<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ENVController;
use App\Http\Controllers\railzController;
use App\Models\MerchantCase;
use App\Models\merchantCaseApplication;
use App\Models\MyRole\UserSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function __construct()
    {
        view()->share([
            'url' => url('login'),
            'title' => 'Login'
        ]);
    }

    public function index()
    {
        if (auth()->check()) {
            return redirect('dashboard');
        }
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        // if (merchantCaseApplication::where('email',$request->email)->where('deleted_at',null)->exists())
        // {
        //     $app=merchantCaseApplication::where('email',$request->email)->where('deleted_at',null)->first();
        //     $case=MerchantCase::find($app->case_id);
        //     if(MerchantCase::where('id',$app->case_id)->where('deleted_at',null)->exists() && $case->status=='Pending')
        //     {
        //         return back()
        //             ->withInput()
        //             ->with([
        //                 'message' =>'Your Application is under review'
        //             ]);

        //     }
        // }

        $message = 'Wrong Credentials';
        $data = $request->only('email', 'password');
        $email = $request->email;
        $user = User::where('email', $email)->first();

        if ($user) {


//            if ($user->email_verified_at) {
                if (auth()->attempt($data)) {
                     if($user->status=='inactive' || empty($user->email_verified_at))
                    {
                          $message='Your account deleted or blocked';
                        Auth::logout();
                                 if(empty($user->email_verified_at))
                                {
                                    $message = 'Almost done! Please check your email to verify your account.';
                                }

                        return redirect('/login',)->with([
                        'toast' => [
                            'heading' => 'Sorry',
                            'message' => $message,
                            'type' => 'danger',
                        ]
                    ]);
                    }
                    my_permissions($user->id,null,true);
                    event(new \App\Events\userLogged());
                         $setting = UserSetting::firstOrCreate(
                                ['user_id' => $user->id] );

                    return redirect('dashboard',)->with([
                        'toast' => [
                            'heading' => 'Hello',
                            'message' => 'Welcome Back!',
                            'type' => 'success',
                        ]
                    ]);
                }
//            } else {
//                $message = 'Email is not verified';
//            }
        }
        return back()
            ->withInput()
            ->with([
                'message' => $message
            ]);
    }

    public function logout()
    {
        Session::flush();
        Session::put('login_2FA',false);
        Session::put('login_email_2FA',false);
        Session::put('login_try',0);
        auth()->logout();
        Session::regenerate();
        return redirect()->route('login');
    }
}
