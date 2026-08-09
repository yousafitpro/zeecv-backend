<?php

namespace App\Http\Controllers\Resume;

use App\Http\Controllers\Controller;
use App\Models\Resume\Education;
use App\Models\Resume\Experience;
use App\Models\Resume\Resume;
use App\Models\Resume\ResumeLanguage;
use App\Models\Resume\Skill;
use Illuminate\Http\Request;

class LanguageController extends Controller
{

    public function process(){
       return ResumeLanguage::query()->where('user_id',auth_user_id());
    }
    public function save(Request $request){
      $input=$request->all();
      $item=ResumeLanguage::create(
         [
            'skill'=>$input['skill'],
            'user_id'=>auth_user_id(),
            'resume_id'=>unique_decrypt($input['resume_id']),
            
         ]
      );
      return response()->json([
         'code'=>'1',
         'item'=>$item,
         'message'=>"Experience Updated successfully"
      ]);
    }
    public function delete(Request $request,$id){
      $input=$request->all();
      $item=ResumeLanguage::where('id',$id)->delete();
      return response()->json([
         'code'=>'1',
         'item'=>$item,
         'message'=>"Experience Deleted successfully"
      ]);
    }
    public function add(Request $request){
      $input=$request->all();
      $item=ResumeLanguage::create([
         'status'=>"Created",
         'user_id'=>auth_user_id(),
         'resume_id'=>unique_decrypt($request->resume_id),
      ]);
      return response()->json([
         'code'=>'1',
         'item'=>$item,
         'message'=>"Experience Added successfully"
      ]);
    }
    public function list()
    {
       $data['list']=$this->process()->get()->where('resume_id',unique_decrypt(request('resume_id')));
       $data['resume_id']=request('resume_id');
       return view('zeecv.resume.ajax.language-list',$data);
    }
 

}
