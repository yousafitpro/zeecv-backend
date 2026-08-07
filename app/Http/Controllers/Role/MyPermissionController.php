<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\MyRole\MyPermission;
use Illuminate\Http\Request;

class MyPermissionController extends Controller
{
    public function index()
    {
        $data['predefined_permissions']=['add','view','update','remove','full_control','logs','delete','copy','clone','duplicate'];
        $data['list']=MyPermission::query()->when(!is_admin(),function($q){
        $q->where('user_id',auth()->id());
        })
        ->orderByRaw("CASE WHEN tag IS NULL THEN 1 ELSE 0 END, tag ASC")
        ->get();

        return view('myroles.my_permissions',$data);

    }
    public function add(Request $request)
    {
        $data=$request->except('_token','action','permissions');
        $data['user_id']=auth()->id();
        if(MyPermission::where('slug',$data['slug'])->where('user_id',auth()->id())->exists() && $request->action!='all')
        {
            return redirect()->back()->withInput()
            ->with([
                'toast' => [
                    'heading' => 'Error!',
                    'message' =>$data['name']." Already Existed",
                    'type' => 'danger',
                ]
            ]);
        }
        if( $request->action=='all' && empty($request->permissions))
        {
            return redirect()->back()->withInput()
            ->with([
                'toast' => [
                    'heading' => 'Error!',
                    'message' =>"Permissions are required.",
                    'type' => 'danger',
                ]
            ]);
        }
        if($request->action=='all')
        {
          foreach($request->permissions as $p)
          {
           $slug=$data['tag'].'.'.$p;
           if(!MyPermission::where('slug',$slug)->where('user_id',auth()->id())->exists())
           {
           MyPermission::create([
            'slug'=>$slug,
            'name'=>$data['tag'].' | '.$p,
            'user_id'=>$data['user_id'],
            'tag'=>$data['tag'],
            'group'=>$data['group'],
            'color'=>'#fada5f'
           ]);
           }

          }
        }else
        {
        MyPermission::create($data);
        }


        MyPermission::where('tag',$data['tag'])->update(['color'=>$data['color']]);
        return redirect()->back()
            ->with([
                'toast' => [
                    'heading' => 'Success!',
                    'message' =>"successfully Added",
                    'type' => 'success',
                ]
            ]);
    }
    public function update(Request $request,$id)
    {
        $data=$request->except('_token');
        if(MyPermission::where('slug',$data['slug'])->when(!is_admin(),function($q){
            $q->where('user_id',auth()->id());
            })->where('id','!=',$id)->exists())
        {
            return redirect()->back()->withInput()
            ->with([
                'toast' => [
                    'heading' => 'Error!',
                    'message' =>$data['name']." Already Existed",
                    'type' => 'danger',
                ]
            ]);
        }
        MyPermission::where('id',$id)->update($data);
        MyPermission::where('tag',$data['tag'])->update(['color'=>$data['color']]);
        return redirect()->back()
            ->with([
                'toast' => [
                    'heading' => 'Success!',
                    'message' =>"Successfully Updated",
                    'type' => 'success',
                ]
            ]);
    }


    public function delete(Request $request,$id)
    {
        $data=$request->except('_token');
        MyPermission::where('id',$id)->when(!is_admin(),function($q){
            $q->where('user_id',auth()->id());
            })->update([
            'deleted_at'=>today_date()
        ]);
        return redirect()->back()
            ->with([
                'toast' => [
                    'heading' => 'Success!',
                    'message' =>"Successfully Removed",
                    'type' => 'success',
                ]
            ]);
    }
}
