<?php

namespace App\Http\Controllers\Resume;

use App\Http\Controllers\Controller;
use App\Models\Resume\Contact;
use App\Models\Resume\Experience;
use App\Models\Resume\Resume;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    public function process(){
       return Contact::query()->where('user_id',auth_user_id());
    }
    public function save(Request $request){
      $input=$request->all();
      $item=$this->process()->where('resume_id',unique_decrypt($request->resume_id))->first();
      $item->update(
         [
            'desired_job_title'=>$input['desired_job_title'],
            'first_name'=>$input['first_name'],
            'last_name'=>$input['last_name'],
            'location'=>$input['location'],
            'zip_code'=>$input['zip_code'],
            'country'=>$input['country'],
            'phone'=>$input['phone'],
            'email'=>$input['email'],
            'profile_link'=>$input['profile_link'],
         ]
      );
      return response()->json([
         'code'=>'1',
         'item'=>$item,
         'message'=>"Experience Updated successfully"
      ]);
    }
 

}
