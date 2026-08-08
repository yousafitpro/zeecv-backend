<?php

namespace App\Http\Controllers\Resume;

use App\Http\Controllers\Controller;
use App\Models\Resume\Education;
use App\Models\Resume\Experience;
use App\Models\Resume\Resume;
use App\Models\Resume\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{

    public function process(){
       return Skill::query()->where('user_id',auth_user_id());
    }
    public function save(Request $request){
      $input=$request->all();
      $item=Skill::where('id',$input['item_id'])->first();
      $item->update(
         [
            'skill'=>$input['skill']
            
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
      $item=Skill::where('id',$id)->delete();
      return response()->json([
         'code'=>'1',
         'item'=>$item,
         'message'=>"Experience Deleted successfully"
      ]);
    }
    public function add(Request $request){
      $input=$request->all();
      $item=Skill::create([
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
       $data['list']=$this->process()->get();
       return view('zeecv.resume.ajax.skill-list',$data);
    }
 

}
