<?php

namespace App\Http\Controllers\Resume;

use App\Http\Controllers\Controller;
use App\Models\Resume\Contact;
use App\Models\Resume\Resume;
use App\Models\Resume\Summary;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function preview(Request $request){
         Contact::updateOrCreate(
         [
            'resume_id'=>unique_decrypt($request->resume_id),
            'user_id'=>auth_user_id()
         ]
      );
      $data['cv']=Resume::where('user_id',auth_user_id())->first();
      return view('zeecv.resume.components.preview',$data);
    }
    public function create()
    {
       $res= Resume::create([
        'status'=>'In Progress',
        'user_id'=>auth_user_id()
       ]);
       return redirect()->route('resume.edit',unique_encrypt($res->id));
    }
    public function edit($id)
    {
      $data['contact']=Contact::updateOrCreate(
         [
            'resume_id'=>unique_decrypt($id),
            'user_id'=>auth_user_id()
         ]
      );
      $data['summary']=Summary::updateOrCreate(
         [
            'resume_id'=>unique_decrypt($id),
            'user_id'=>auth_user_id()
         ]
      );
       return view('zeecv.resume.edit',$data);
    }
 

}
