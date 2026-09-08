<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Payment\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $data['invoices']=Payment::where('user_id',auth_user_id())->get();
        $data['subscription']=Subscription::where('user_id',auth_user_id())->latest()->first();
        return view('account.index',$data);
    }
}
