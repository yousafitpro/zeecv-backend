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
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
class APIKeyController extends Controller
{
    public function index($id)
    {

        $data['client_id']=encrypt_client_id($id);
        $key = APIKey::firstOrCreate(
            ['user_id' => $id, 'status' => 'Active',],
            [
                'status' => 'Active',
                'api_key' => Str::random(35), // Generate a short API key
            ]
        );
        $data['api_key']=$key->api_key;
        $data['list']=APIKey::query()->when(!is_admin(),function($query)use($id){
            $query->where('user_id',$id);
        })->latest()->get();

        return view('myroles.api_keys',$data);

    }


    public function update(Request $request,$user_id)
    {

        $user=User::find($user_id);
        Log::channel('slack')->info("API Keys Refreshed for ".$user->email);
        APIKey::where('user_id',$user_id)->update(['status'=>'Inactive']);
        $api_key=new APIKey();
        $api_key->status="Active";
        $api_key->user_id=$user_id;
        $api_key->api_key = Str::random(35);
        $api_key->save();


        return redirect()->back()
            ->with([
                'toast' => [
                    'heading' => 'Success!',
                    'message' =>"Successfully Updated",
                    'type' => 'success',
                ]
            ]);
    }



}
