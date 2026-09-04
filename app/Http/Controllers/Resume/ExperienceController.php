<?php

namespace App\Http\Controllers\Resume;

use App\Http\Controllers\Controller;
use App\Models\Resume\Experience;
use App\Models\Resume\Resume;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{

    public function process(){
       return Experience::query()
       ->when(!is_admin(),function ($query) {
         return $query->where('user_id',auth_user_id());
       });
    }
    public function save(Request $request){
      $input=$request->all();
      $item=Experience::where('id',$input['item_id'])->first();
      $item->update(
         [
            'job_title'=>$input['job_title'],
            'company'=>$input['company'],
            'location'=>$input['location'],
            'country'=>$input['country'],
            'start_month'=>$input['start_month'],
            'start_year'=>$input['start_year'],
            'end_month'=>$input['end_month'],
            'is_present'=>isset($input['is_present'])?1:0,
            'end_year'=>$input['end_year'],
            'description'=>$input['description'],
            
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
      $item=Experience::where('id',$id)->delete();
      return response()->json([
         'code'=>'1',
         'item'=>$item,
         'message'=>"Experience Deleted successfully"
      ]);
    }
    public function add(Request $request){
      $input=$request->all();
      $latestExp=Experience::where(['resume_id'=>unique_decrypt($request->resume_id)])->latest('sort_order')->first();
      $item=Experience::create([
         'status'=>"Created",
         'user_id'=>auth_user_id(),
         'resume_id'=>unique_decrypt($request->resume_id),
         'sort_order'=>$latestExp->sort_order
      ]);
      return response()->json([
         'code'=>'1',
         'item'=>$item,
         'message'=>"Experience Added successfully"
      ]);
    }
    public function list()
    {
       $data['list']=$this->process()
                           ->where('resume_id',unique_decrypt(request('resume_id')))
                           ->orderBy('sort_order', 'ASC')->get();
       $data['resume_id']=request('resume_id');
       return view('zeecv.resume.ajax.experience-list',$data);
    }
 

}
