<?php

namespace App\Http\Controllers;

use App\Http\Controllers\App\AppGoogleRecaptchaController;
use App\Models\ContactQuery;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('home.index');
    }
    public function features(){
        return view('home.features');
    }
    public function templates(){
        return view('home.templates');
    }
    public function about(){
        return view('home.about');
    }
    public function contact(){
        return view('home.contact');
    }
    public function postAJob(){
        return view('home.post-a-job');
    }
    public function contactPost(Request $request){
        $input=$request->all();
        $score=(new AppGoogleRecaptchaController())->getScore($input['g-recaptcha-response']);
        // dd($score,$input);
        if($score<0.7)
        {
           return redirect()->back()->withInput()->with([
                'toast' => [
                    'heading' => 'Message',
                    'message' => 'Invalid recaptcha',
                    'type' => 'danger',
                ]
            ]);
        }
        ContactQuery::create([
            'email'=>$input['email'],
            'payload'=>json_encode($input),
            'type'=>'contact'
        ]);
        return redirect('/')->with([
                'toast' => [
                    'heading' => 'Message',
                    'message' => 'Your query has been submitted successfully. We’ll get back to you within 24 hours.',
                    'type' => 'success',
                ]
            ]);
    }
    public function postAJobProcess(Request $request){
        $input=$request->all();
        $input=$request->all();

        $score=(new AppGoogleRecaptchaController())->getScore($input['g-recaptcha-response']);
        if($score<0.7)
        {
           return redirect()->back()->withInput()->with([
                'toast' => [
                    'heading' => 'Message',
                    'message' => 'Invalid recaptcha',
                    'type' => 'danger',
                ]
            ]);
        }
        ContactQuery::create([
            'email'=>$input['company_email'],
            'payload'=>json_encode($input),
            'type'=>'post-a-job'
        ]);
        
        return redirect('/')->with([
                'toast' => [
                    'heading' => 'Message',
                    'message' => 'Your query has been submitted successfully. We’ll get back to you within 24 hours.',
                    'type' => 'success',
                ]
            ]);
    }
    public function pricing(){
        return view('home.pricing');
    }
    public function pleaseVerifyAccount(){
        return view('zeecv.notes.please_verify_email');
    }

}
