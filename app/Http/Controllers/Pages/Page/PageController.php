<?php

namespace App\Http\Controllers\Pages\Page;

use App\Http\Controllers\Controller;
use App\Models\AppLog;
use App\Models\Blog\Post\BlogPost;
use App\Models\Pages\Page\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class PageController extends Controller
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
        return view('page.page.index',$data);

    }
    public function blogs()
    {

       $data['list']=Page::query()
       ->where('type','blog')
       ->where('status','active')
       ->latest()->paginate(50);
        return view('home.blogs.index',$data);

    }
    public function blogDetail($slug)
    {

       $data['blog']=Page::where('slug',$slug)->first();
        return view('home.blogs.detail',$data);

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
        return view('page.page.ajax.main_list',$data);

    }
    public function processList()
    {

      return Page::isAdmin();
    }




   public function add()
    {
         $data['departments']=$this->departments();
        return view('page.page.add',$data);
    }
    public function addPost(Request $request)
    {
        $data=$request->except('_token');
        try{
            DB::beginTransaction();

            $page=Page::create([
                'title'=>$data['title'],
                'slug'=> Str::slug($data['title']),
                'user_id'=>auth_user_id(),
                'created_by_id'=>auth_user_id(),
                'metadata'=>$data['description'],
                'long_description'=>$data['long_description'],
                'meta_tags'=>$data['meta_tags'],
                'status'=>$data['status'],
                'type'=>$data['type']
            ]);
            $thumbnail = $request->file('thumbnail');
            if ($thumbnail) {
                    $data['thumbnail']=fun_save_file($thumbnail,'zeecv/uploads');
                    $page->thumbnail_file_id=$data['thumbnail']->id;
                    $page->save();
                }
            $header_img = $request->file('header_img');
            if ($header_img) {
                    $data['header_img']=fun_save_file($header_img,'zeecv/uploads');
                    $page->header_img_file_id=$data['header_img']->id;
                    $page->save();
                }

        DB::commit();
         return response()->json(['code'=>1,'message'=>"Page added successfully!",'url'=>route('pages.page.update',$page->id)]);
        }catch(\Exception $e)
        {
            DB::rollBack();
           return response()->json(['code'=>0,'message'=>$e->getMessage()]);
        }

    }

    public function update(Request $request,$id)
    {
        $data['departments']=$this->departments();
        $data['item']=Page::find($id);
        return view('page.page.update',$data);
    }
        public function pageview(Request $request,$slug)
    {

        $data['item']=Page::where('slug',$slug)->first();
        return view('page.page.view',$data);
    }
    public function logs(Request $request,$id)
    {
        $data['list']=AppLog::where([
            'type'=>'project',
            'reference'=>$id
        ])->with(['user'])->get();
         return view('page.page.logs.index',$data);
    }
    public function updatePost(Request $request,$id)
    {
        $data=$request->except(['_token']);

        $post = Page::isAdmin()->find($id);

        $Payload['old'] = $post->replicate();
        $post->update([
                'title'=>$data['title'],
                // 'slug'=> Str::slug($data['title']),
                'metadata'=>html_entity_decode($data['description']),
                'meta_tags'=>html_entity_decode($data['meta_tags']),
                'long_description'=>html_entity_decode($data['long_description']),
                'status'=>$data['status'],
                'type'=>$data['type']
            ]);
                    $thumbnail = $request->file('thumbnail');
            if ($thumbnail) {
                    $data['thumbnail']=fun_save_file($thumbnail,'zeecv/uploads');
                    $post->thumbnail_file_id=$data['thumbnail']->id;
                    $post->save();
                }
            $header_img = $request->file('header_img');
            if ($header_img) {
                    $data['header_img']=fun_save_file($header_img,'zeecv/uploads');
                    $post->header_img_file_id=$data['header_img']->id;
                    $post->save();
                }



        $Payload['updated'] = $post->fresh('user');
        app_log(auth_user_id(),'post',$id,"page Updated",$Payload);
        return response()->json(['code'=>1,'message'=>"Page updated successfully!",'item_url'=>$post->attachment->file_url??'']);
    }

    public function remove(Request $request,$id)
    {
       try{
        $post = Page::isAdmin()->find($id);
        $post->delete();
       return response()->json(['code'=>1,'message'=>"Post deleted successfully!"]);
       }catch(\Exception $e)
       {
        DB::rollBack();
         return response()->json(['code'=>0,'message'=>"Project cannot be deleted successfully!"]);
       }

    }

}
