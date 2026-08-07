<?php

namespace App\Http\Controllers\HR\Post;

use App\Http\Controllers\Controller;
use App\Models\AppLog;
use App\Models\HR\Post\HRPost;
use App\Models\PM\Project\PMMyTask;
use App\Models\PM\Project\PMpost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HRPostController extends Controller
{
        public function index()
    {

       $data['list']=$this->processList()
       ->with(['attachment'])
       ->latest()->paginate(50);
        return view('hr.post.index',$data);

    }

    public function search(Request $request)
    {
       $input=$request->all();
       $data['list']=$this->processList()
        ->when(!empty($input['status']),function($q)use($input){
        $q->where('status',$input['status']);
       })
       ->latest()
       ->with(['attachment'])
       ->get();
        return view('hr.post.ajax.main_list',$data);

    }
    public function processList()
    {

      return HRPost::query();
    }




   public function add()
    {

        return view('hr.post.add');
    }
    public function addPost(Request $request)
    {
        $data=$request->except('_token');

        try{
            DB::beginTransaction();
            $post=HRPost::create([
                'title'=>$data['title'],
                'user_id'=>auth_user_id(),
                'created_by_id'=>auth_user_id(),
                'exp_date'=>$data['exp_date'],
                'description'=>$data['description'],
                'status'=>$data['status']
            ]);
            $attachment = $request->file('attachment');
            if ($attachment) {
                    $data['attachment']=fun_save_file($attachment,'uploads');
                    $post->app_file_id=$data['attachment']->id;
                    $post->save();
                }
        DB::commit();
         return response()->json(['code'=>1,'message'=>"post added successfully!"]);
        }catch(\Exception $e)
        {
            DB::rollBack();
           return response()->json(['code'=>0,'message'=>$e->getMessage()]);
        }

    }

    public function update(Request $request,$id)
    {
        $data['item']=HRPost::find($id);
        return view('hr.post.update',$data);
    }
    public function logs(Request $request,$id)
    {
        $data['list']=AppLog::where([
            'type'=>'project',
            'reference'=>$id
        ])->with(['user'])->get();
         return view('hr.post.logs.index',$data);
    }
    public function updatePost(Request $request,$id)
    {
        $data=$request->except(['_token']);

        $post = HRPost::find($id);
        $attachment = $request->file('attachment');

                if ($attachment) {
                    $data['attachment']=fun_save_file($attachment,'uploads');
                    $post->app_file_id=$data['attachment']->id;
                    $post->save();
                }
        $Payload['old'] = $post->replicate();
        $post->update([
                'title'=>$data['title'],
                'exp_date'=>$data['exp_date'],
                'description'=>$data['description'],
                'status'=>$data['status']
            ]);



        $Payload['updated'] = $post->fresh('user');
        app_log(auth_user_id(),'post',$id,"post Updated",$Payload);
        return response()->json(['code'=>1,'message'=>"post updated successfully!",'item_url'=>$post->attachment->file_url??'']);
    }

    public function remove(Request $request,$id)
    {
       try{
        DB::beginTransaction();
       HRPost::hasPermission('pm.posts.full_control')->find($id)->user->delete();
       HRPost::hasPermission('pm.posts.full_control')->find($id)->delete();
       DB::commit();
       return response()->json(['code'=>1,'message'=>"Employee deleted successfully!"]);
       }catch(\Exception $e)
       {
        DB::rollBack();
         return response()->json(['code'=>0,'message'=>"Project cannot be deleted successfully!"]);
       }

    }

}
