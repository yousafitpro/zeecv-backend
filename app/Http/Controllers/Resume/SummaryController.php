<?php

namespace App\Http\Controllers\Resume;

use App\Http\Controllers\Controller;
use App\Models\Resume\Contact;
use App\Models\Resume\Experience;
use App\Models\Resume\Resume;
use App\Models\Resume\Summary;
use Illuminate\Http\Request;

class SummaryController extends Controller
{

    public function process(){
       return Summary::query()->where('user_id',auth_user_id());
    }
    public function save(Request $request){
      $input=$request->all();
      $item=$this->process()->first();
      $item->update(
         [
            'summary'=>$input['summary']
         ]
      );
      return response()->json([
         'code'=>'1',
         'item'=>$item,
         'message'=>"Experience Updated successfully"
      ]);
    }
 

}
