<?php

namespace App\Http\Controllers;



class HomeController extends Controller
{
    public function index(){
        return view('home.index');
    }
    public function pleaseVerifyAccount(){
        return view('zeecv.notes.please_verify_email');
    }

}
