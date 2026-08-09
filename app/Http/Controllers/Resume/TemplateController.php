<?php

namespace App\Http\Controllers\Resume;

use App\Http\Controllers\Controller;
use App\Models\Resume\Contact;
use App\Models\Resume\Experience;
use App\Models\Resume\Resume;
use App\Models\Resume\Summary;
use App\Models\Resume\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{

    public function process(){
       return Template::query()->where('user_id',auth_user_id());
    }
    public function save(Request $request){
      $input=$request->all();
      $item=$this->process()->where('resume_id',unique_decrypt($request->resume_id))->first();
      $item->update(
         [
            'template'=>$input['template'],
            'color'=>$input['color']
         ]
      );
      return response()->json([
         'code'=>'1',
         'item'=>$item,
         'message'=>"Experience Updated successfully"
      ]);
    }
 

}
