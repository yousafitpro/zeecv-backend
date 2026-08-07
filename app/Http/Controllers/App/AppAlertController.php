<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use Illuminate\Http\Request;

class AppAlertController extends Controller
{
    public function index(Request $request)
    {
        return view('alerts.content');

    }
    public function read(Request $request)
    {
        $data=$request->all();
        $alert=Alert::hasAccessRaw('and',['receiver'=>auth_user_id()],'pm.alerts.full_control')
        ->find($data['alert_id'])
        ->update(['status'=>'read']);
        return response()->json(['code'=>'1','message'=>"Status successfully updated"]);

    }
      public function readAll(Request $request)
    {
        $alert=Alert::hasAccessRaw('and',['receiver'=>auth_user_id()],'pm.alerts.full_control')
        ->update(['status'=>'read']);
        return response()->json(['code'=>'1','message'=>"Status successfully updated"]);

    }

}
