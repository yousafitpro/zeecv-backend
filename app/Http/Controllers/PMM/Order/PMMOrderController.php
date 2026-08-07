<?php

namespace App\Http\Controllers\PMM\Order;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SMS\SMSController;
use App\Models\Payment\Payment;
use Carbon\Carbon;

class PMMOrderController extends Controller
{
        public function track($order_id)
    {

       $data['order']=Payment::find(unique_decrypt($order_id));
        return view(theme_url().'order.track',$data);

    }
    public function sendComebacks()
    {

        $duration = 5; // minutes
        $thresholdTime = Carbon::now()->subMinutes($duration);

        $list = Payment::where('status', 'Pending')
            ->where('is_comeback_notified', 0)
            ->where('created_at', '<=', $thresholdTime)
            ->get();
        foreach ($list as $item) {
            $item->is_comeback_notified = 1;
            $item->save();

            $message = "Hi! Your order #" . unique_encrypt($item->id) .
                    " for " . $item->link->product->name .
                    " is still awaiting confirmation. Complete it now using this link: " .
                    get_comebackurl_link($item->id);
            (new SMSController())->sendSms($message, $item->phone, 'order_comeback', $item->id, $item->user_id);
        }

    }


}
