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
        $mysub=my_subscription();
        $data['invoices']=Payment::where('user_id',auth_user_id())->get();
        if(!empty($mysub)){
            $data['subscription']=$mysub['sub'];
            $data['is_expired']=$mysub['is_expired'];
        }else{
            $data['subscription']=null;
            $data['is_expired']=true;
        }

        return view('account.index',$data);
    }
}
