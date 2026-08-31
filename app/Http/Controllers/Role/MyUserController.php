<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\APIKey;
use App\Models\MyRole\MyPermission;
use App\Models\MyRole\MyRole;
use App\Models\MyRole\MyRolePermissions;
use App\Models\MyRole\MyUserRole;
use App\Models\notificationSetting;
use App\Models\User;
use App\Models\MyRole\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MyUserController extends Controller
{
    public function index()
    {
        $user_id=root_user_id();
        $data['client_id']=encrypt_client_id($user_id);
        $key = APIKey::firstOrCreate(
            ['user_id' => $user_id, 'status' => 'Active',],
            [
                'status' => 'Active',
                'api_key' => Str::random(35), // Generate a short API key
            ]
        );
        $data['api_key']=$key->api_key;
        $data['list']=User::query()->where('type','!=','admin')->where('id','!=',auth()->user()->id)
        ->when(!is_admin(),function($query){
            $query->where('root_user_id',root_user_id());
        })
        ->latest('id')
        ->get();

        return view('myroles.my_users',$data);

    }

    public function add(Request $request)
    {
        $data=$request->except('_token');
        $data['created_by_id']=auth()->user()->id;
        $data['root_user_id']=root_user_id();
        $data['password']=bcrypt($data['password']);
        $data['email_verified_at']=now();
        if(auth()->user()->type=='Company'){
            $data['type']='User';
        }

        if(User::withTrashed()->where('email',$data['email'])->exists())
        {
            return redirect()->back()->withInput()
            ->with([
                'toast' => [
                    'heading' => 'Error!',
                    'message' =>$data['email']." Already Existed",
                    'type' => 'danger',
                ]
            ]);
        }
        $user=auth()->user();
        $setting = UserSetting::firstOrCreate(
                                ['user_id' => $user->id]);
        Log::channel('slack')->info("New User Added by ".$user->email,['User Data'=>$data]);
        User::create($data);
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
        $data=$request->except('_token','email');
        if($request->has('password'))
        {
            $data['password']=bcrypt($data['password']);
        }
        if(auth()->user()->type=='Company'){
            $data['type']='User';
        }
        User::where('id',$id)->update($data);
        $user=auth()->user();
        Log::channel('slack')->info("New User Added by ".$user->email,['User Data'=>User::where('id',$id)->first()]);
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
        User::where('id',$id)->when(!is_admin(),function($q){
            $q->where('root_user_id',root_user_id());
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
    public function settings($user_id)
    {
        $data['user']=User::where('id',$user_id)
        ->when(!is_admin(),function($query){
            $query->where('root_user_id',root_user_id());
        })
        ->get()->first();
        if(empty($data['user'])){
            return '';
        }
        $data['setting']=user_settings($user_id);
        $data['notification_settings']=notificationSetting::where(['user_id'=>$user_id])->get();

        return view('user.setting',$data);

    }


    public function add_roles($user_id, Request $request)
    {
        $role = $request->input('permission'); // Array of permission IDs
        $flag = $request->input('flag'); // Array of permission IDs

        if($flag=="false")
        {
            MyUserRole::where(['user_id'=>$user_id])->where('my_role_id',$role)->delete();
            return response()->json(['message' => 'Role removed successfully!']);
        }else
        {
            MyUserRole::where('deleted_at',null)->updateOrCreate(['my_role_id'=>$role,'user_id'=>$user_id],
            ['my_role_id'=>$role,
            'created_by_id'=>root_user_id(),
            'user_id'=>$user_id,

        ]);
        return response()->json(['message' => 'Role added successfully!']);
        }
    }



    public function add_direct_permissions($user_id, Request $request)
    {
        $permission_id = $request->input('permissions', []); // Array of permission IDs
        $flag = $request->input('flag', 'false'); // Array of permission IDs



            if($flag=='true')
              {
                MyRolePermissions::where('deleted_at',null)->updateOrCreate(['my_permission_id'=>$permission_id,'user_id'=>$user_id],
                ['my_permission_id'=>$permission_id,
                'root_user_id'=>root_user_id(),
                'user_id'=>$user_id,

                ]);
                return response()->json(['code'=>'1','message' => 'Permission added successfully!']);
            }else
            {
                MyRolePermissions::where('deleted_at',null)->where(['my_permission_id'=>$permission_id,'user_id'=>$user_id])->delete();
                return response()->json(['code'=>'1','message' => 'Permission removed successfully!']);
            }



        return response()->json(['message' => 'Role not found'], 400);
    }
    public function roles(Request $request,$id)
    {
        $data['user']=User::find($id);
        $data['roles']=MyRole::query()
                             ->leftJoin('my_user_roles',function($q)use($id){
                                $q->on('my_user_roles.my_role_id','my_roles.id')
                                ->where('my_user_roles.deleted_at',null)
                                ->where('my_user_roles.user_id',$id);
                             })
                             ->when(!is_admin(),function($q){
                                $q->where('my_roles.user_id',root_user_id());
                                })
                             ->select('my_roles.*','my_user_roles.id as has_role')
                             ->get();
        return view('myroles.user_roles',$data);
    }
    public function direct_permissions(Request $request,$id)
    {
        $data['user']=User::find($id);
        $data['permissions']=MyPermission::query()
                             ->leftJoin('my_role_permissions',function($q)use($id){
                                $q->on('my_role_permissions.my_permission_id','my_permissions.id')
                                ->where('my_role_permissions.deleted_at',null)
                                ->where('my_role_permissions.user_id',$id);
                             })
                             ->when(!is_admin(),function($query2)use($id){
                                $query2->whereIn('my_permissions.slug',Arr::pluck(my_permissions(),'slug'));
                             })
                             ->select('my_permissions.*','my_role_permissions.id as has_permission')
                             ->orderByRaw("CASE WHEN tag IS NULL THEN 1 ELSE 0 END, tag ASC")
                             ->get();
        return view('myroles.user_permissions',$data);
    }

}
