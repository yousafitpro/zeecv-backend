<?php

namespace App\Http\Controllers\Callcenter;

use App\Http\Controllers\Controller;
use App\Models\APIKey;
use App\Models\Callcenter\Operator;
use App\Models\MyRole\MyRole;
use App\Models\MyRole\MyUserRole;
use App\Models\User;
use App\Models\MyRole\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OperatorController extends Controller
{
    public function index()
    {
        
        $data['list']=Operator::query()
        ->when(!is_admin(),function($query){
            $query->where('created_by_id',auth()->user()->id);
        })
        ->get();

        return view('callcenter.operator.operators',$data);

    }

    public function add(Request $request)
    {
        $data=$request->except('_token');
        DB::beginTransaction();
        $userData['email']=$data['email'];
        $userData['name']=$data['name'];
        $userData['type']="User";
        $userData['password']=bcrypt($data['password']);
        $userData['email_verified_at']=now();
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
        $user=User::create($userData);
        $setting = UserSetting::firstOrCreate(
                                ['user_id' => $user->id]);
        $operator['created_by_id']=auth()->user()->id;
        $operator['user_id']=$user->id;
        $op_role=MyRole::where('unique_key','call_center_operator')->first();
        MyUserRole::where('deleted_at',null)->updateOrCreate(['my_role_id'=>$op_role->id,'user_id'=>$user->id],
            ['my_role_id'=>$op_role->id,
            'created_by_id'=>auth()->user()->id,
            'user_id'=>$user->id,

        ]);
        Operator::create($operator);
        DB::commit();
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
        $op=Operator::find($id);
        if($request->has('password'))
        {
            $data['password']=bcrypt($data['password']);
        }
        $user=User::where('id',$op->user_id)->update($data);
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
