<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MyRole\MyPermission;
use App\Models\MyRole\MyRole;
use App\Models\MyRole\MyRolePermissions;
use App\Models\MyRole\MyUserRole;
use App\Models\notificationSetting;
use App\Models\User;
use App\Models\MyRole\UserSetting;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $data['list']=User::query()->where('type','!=','admin')->get();

        return view('myroles.my_users',$data);

    }
    public function card()
    {
       $data['user']=User::find(request('user_id'));

        return view('app.widgets.userModalContent',$data);

    }
    public function add(Request $request)
    {
        $data=$request->except('_token');
        $data['created_by_id']=auth()->user()->id;
        $data['root_user_id']=root_user_id();
        $data['password']=bcrypt($data['password']);
        $data['type']='User';
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

        public function updateSetting(Request $request)
    {
       $data=$request->only('sidebar_status');
        UserSetting::where('user_id',auth_user_id())->update($data);
        return response()->json(['code'=>'1','message'=>'successfully updated']);
    }
    public function update(Request $request,$id)
    {
        $data=$request->except('_token','email');
        if($request->has('password'))
        {
            $data['password']=bcrypt($data['password']);
        }
        User::where('id',$id)->update($data);

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
}
