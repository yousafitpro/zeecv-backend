<?php

namespace App\Http\Controllers\Resume;

use App\Http\Controllers\Controller;
use App\Models\Resume\Certificate;
use App\Models\Resume\Education;
use App\Models\Resume\Experience;
use App\Models\Resume\Resume;
use Illuminate\Http\Request;

class CertificateController extends Controller
{

    public function process(){
       return Certificate::query()->where('user_id',auth_user_id());
    }
    public function save(Request $request){
      $input=$request->all();
      $item=Certificate::where('id',$input['item_id'])->first();
      $item->update(
         [
            'degree'=>$input['degree'],
            'institution'=>$input['institution'],
            'location'=>$input['location'],
            'country'=>$input['country'],
            'start_month'=>$input['start_month'],
            'start_year'=>$input['start_year'],
            'end_month'=>$input['end_month'],
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
      $item=Certificate::where('id',$id)->delete();
      return response()->json([
         'code'=>'1',
         'item'=>$item,
         'message'=>"Experience Deleted successfully"
      ]);
    }
    public function add(Request $request){
      $input=$request->all();
      $item=Certificate::create([
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
       return view('zeecv.resume.ajax.certificate-list',$data);
    }
 

}
