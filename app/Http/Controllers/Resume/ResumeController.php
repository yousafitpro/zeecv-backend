<?php

namespace App\Http\Controllers\Resume;

use App\Http\Controllers\Controller;
use App\Models\Resume\Contact;
use App\Models\Resume\Resume;

class ResumeController extends Controller
{
    public function create()
    {
       $res= Resume::create([
        'status'=>'In Progress'
       ]);
       return redirect()->route('resume.edit',unique_encrypt($res->id));
    }
    public function edit()
    {
      $data['contact']=Contact::updateOrCreate(
         [
            'user_id'=>auth_user_id()
         ]
      );
       return view('zeecv.resume.edit',$data);
    }
 

}
