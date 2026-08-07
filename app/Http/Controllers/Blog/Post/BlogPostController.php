<?php

namespace App\Http\Controllers\Blog\Post;

use App\Http\Controllers\Controller;
use App\Models\AppLog;
use App\Models\Blog\Post\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class BlogPostController extends Controller
{
    public function departments()
    {
      return ['My Account','Payments'];
    }
        public function index()
    {

       $data['list']=$this->processList()
       ->with(['attachment'])
       ->latest()->paginate(50);
        return view('blog.post.index',$data);

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
        return view('blog.post.ajax.main_list',$data);

    }
    public function tutorials(Request $request)
    {
        $data['tutorials']=BlogPost::where('placement','Website')->get();
         return view(theme_url().'tutorials.index',$data);
    }
    public function showTutorial(Request $request,$slug=null)
    {
        $data['tutorial']=BlogPost::where('slug',$slug)->first();
         return view(theme_url().'tutorials.show',$data);
    }
    public function processList()
    {

      return BlogPost::query();
    }




   public function add()
    {
         $data['departments']=$this->departments();
        return view('blog.post.add',$data);
    }
    public function addPost(Request $request)
    {
        $data=$request->except('_token');

        try{
            DB::beginTransaction();
            $post=BlogPost::create([
                'title'=>$data['title'],
                'placement'=>$data['placement'],
                'slug'=> Str::slug($data['title']),
                'user_id'=>auth_user_id(),
                'created_by_id'=>auth_user_id(),
                'exp_date'=>$data['exp_date'],
                'department'=>$data['department'],
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
        $data['departments']=$this->departments();
        $data['item']=BlogPost::find($id);
        return view('blog.post.update',$data);
    }
    public function logs(Request $request,$id)
    {
        $data['list']=AppLog::where([
            'type'=>'project',
            'reference'=>$id
        ])->with(['user'])->get();
         return view('blog.post.logs.index',$data);
    }
    public function updatePost(Request $request,$id)
    {
        $data=$request->except(['_token']);

        $post = BlogPost::isAdmin()->find($id);
        $attachment = $request->file('attachment');

                if ($attachment) {
                    $data['attachment']=fun_save_file($attachment,'uploads');
                    $post->app_file_id=$data['attachment']->id;
                    $post->save();
                }
        $Payload['old'] = $post->replicate();
        $post->update([
                'title'=>$data['title'],
                'slug'=> Str::slug($data['title']),
                'placement'=>$data['placement'],
                'exp_date'=>$data['exp_date'],
                 'department'=>$data['department'],
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
        $post = BlogPost::isAdmin()->find($id);
        $post->delete();
       return response()->json(['code'=>1,'message'=>"Post deleted successfully!"]);
       }catch(\Exception $e)
       {
        DB::rollBack();
         return response()->json(['code'=>0,'message'=>"Project cannot be deleted successfully!"]);
       }

    }

}
