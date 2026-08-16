<?php

namespace App\Http\Controllers;

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
    public function contactPost(Request $request){
        $input=$request->all();
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
