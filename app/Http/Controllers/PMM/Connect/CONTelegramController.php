<?php

namespace App\Http\Controllers\PMM\Connect;

use App\Http\Controllers\Controller;
use App\Models\Connect\ConnectLink;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CONTelegramController extends Controller
{


    public function index(Request $request)
    {
         $data['item']=null;
        $data['link'] = ConnectLink::updateOrCreate([
            'user_id' => auth_user_id(),
            'status' => 'active',
        ]);
        return view('connect.telegram.index',$data);
    }
    public function reconnect(Request $request)
    {
        ConnectLink::where('user_id',auth_user_id())->delete();
         $data['item']=null;
        $data['link'] = ConnectLink::updateOrCreate([
            'user_id' => auth_user_id(),
            'status' => 'active',
        ]);
        return response()->json(['code'=>1,'message'=>"Recreated successfully"]);
    }
    public function webhook(Request $request)
    {
        try{
            $payload=$request->json()->all();
            $input=$payload['message'];

            $chatId = $input['chat']['id'] ?? null;
            $input_text = $input['text'] ?? '';
            $connectId=null;
             Log::channel('error_log')->error("payload ",$payload);
             Log::channel('error_log')->error("input ",$input);
             Log::channel('error_log')->error("text ".$input_text);
            if (strpos($input_text, 'connect-') !== false) {
                $connectId = explode('connect-', $input_text)[1] ?? null;
            }

            Log::channel('error_log')->error("Connect ID ".$connectId);
            Log::channel('error_log')->error("Connect ID ".unique_decrypt($connectId));
            $link=ConnectLink::find(unique_decrypt($connectId));
            if($link && empty($link->chat_id))
            {
            $link->chat_id=$chatId;
            $link->save();
            $text="Congratulations! Bot sucessfully connected";
            $this->sendMessage($chatId,$text);
            }



        }catch(\Exception $e)
        {
            // Log::channel('error_log')->error("Telegram webhook error".$e->getMessage());
        }
    }
    public function sendMessage($chat_id,$text)
    {
    $token=config('myconfig.CON.TelegramBot.token');
    $response = Http::post(config('myconfig.CON.TelegramBot.url')."bot{$token}/sendMessage", [
        'chat_id' => $chat_id,
        'text' => $text
        ]);
    }

public function sendMessageByUserID($user_id,$text)
    {
         $link=ConnectLink::where('user_id',$user_id)->first();
         if(!empty($link) && !empty($link->chat_id))
         {
             $this->sendMessage($link->chat_id,$text);
         }

    }

}
