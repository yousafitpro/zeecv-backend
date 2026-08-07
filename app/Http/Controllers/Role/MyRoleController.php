<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\MyRole\MyPermission;
use App\Models\MyRole\MyRole;
use App\Models\MyRole\MyRolePermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class MyRoleController extends Controller
{
    public function index()
    {

        $data['list']=MyRole::query()->when(!is_admin(),function($q){

        $q->where('user_id',root_user_id());
        })->get();

        return view('myroles.my_roles',$data);

    }
    public function add(Request $request)
    {
        $data=$request->except('_token');
        $data['user_id']=auth()->id();
        if(MyRole::where('name',$data['name'])->where('user_id',auth()->id())->exists())
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
        MyRole::create($data);
        return redirect()->back()
            ->with([
                'toast' => [
                    'heading' => 'Success!',
                    'message' =>"successfully Added",
                    'type' => 'success',
                ]
            ]);
    }
    public function permissions(Request $request,$id)
    {
        $data['myrole']=MyRole::find($id);
        $data['permissions']=MyPermission::query()
                             ->leftJoin('my_role_permissions',function($q)use($id){
                                $q->on('my_role_permissions.my_permission_id','my_permissions.id')
                                ->where('my_role_permissions.deleted_at',null)
                                ->where('my_role_permissions.my_role_id',$id);
                             })
                             ->when(!is_admin(),function($query2)use($id){
                                $query2->whereIn('my_permissions.slug',Arr::pluck(my_permissions(),'slug'));
                             })
                             ->select('my_permissions.*','my_role_permissions.id as has_permission')
                             ->orderByRaw("CASE WHEN tag IS NULL THEN 1 ELSE 0 END, tag ASC")
                             ->get();
        return view('myroles.my_role_permissions',$data);
    }
    public function add_permissions($role_id, Request $request)
    {
        $permission = $request->input('permission');
        $flag =$request->input('flag');

        if($flag=="false")
        {
            MyRolePermissions::where(['my_role_id'=>$role_id])->where('my_permission_id',$permission)->delete();
            return response()->json(['message' => 'Permissions removed successfully!']);
        }else
        {
            MyRolePermissions::where('deleted_at',null)->updateOrCreate(['my_permission_id'=>$permission,'my_role_id'=>$role_id],
            ['my_permission_id'=>$permission,
            'my_role_id'=>$role_id,
            'created_by_id'=>root_user_id()
        ]);
        return response()->json(['message' => 'Permissions added successfully!']);
        }

    }


    public function update(Request $request,$id)
    {
        $data=$request->except('_token');
        if(MyRole::where('name',$data['name'])->when(!is_admin(),function($q){
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
        MyRole::where('id',$id)->update($data);

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
        MyRole::where('id',$id)->when(!is_admin(),function($q){
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
