<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\AppLog;
use App\Models\Blog\Post\BlogPost;
use App\Models\MyRole\UserSetting;
use App\Models\SP\SPTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingAppController extends Controller
{
    public function updateSupportActor(Request $request)
    {
        $data = $request->only([
                'support_actor_name',
                'support_actor_email',
                'support_actor_telegram',
                'paysigh_product_id',
                'paysigh_test_product_id',
                'support_actor_description',
                'support_actor_skype'
            ]);

            $setting = UserSetting::firstOrCreate([
                'user_id' => auth()->id()
            ]);
            // Handle attachment
            if ($request->hasFile('support_actor_image')) {
                $attachment = $request->file('support_actor_image');
                $saved = fun_save_file($attachment, 'uploads');

                if ($saved) {
                    $setting->support_actor_image = $saved->id;
                }
            }

            $setting->support_actor_telegram=$request->support_actor_telegram;
            $setting->support_actor_name=$request->support_actor_name;
            $setting->support_actor_email=$request->support_actor_email;
            $setting->support_actor_skype=$request->support_actor_skype;
            $setting->paysigh_product_id=$request->paysigh_product_id;
            $setting->paysigh_test_product_id=$request->paysigh_test_product_id;
            $setting->support_actor_telegram=$request->support_actor_telegram;
            $setting->support_actor_description=$request->support_actor_description;
            $setting->save();

    return response()->json(['code'=>1,'message'=>"Support Acter updated successfully!",'item_url'=>$setting->actordp?$setting->actordp->file_url:'']);

    }


        public function index()
    {
       $data['item']=UserSetting::where('user_id',auth_user_id())->first();
        return view('system.setting.app.index',$data);

    }


}
