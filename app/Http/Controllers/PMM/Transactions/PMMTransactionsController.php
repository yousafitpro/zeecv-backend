<?php

namespace App\Http\Controllers\PMM\Transactions;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SMS\SMSController;
use App\Jobs\PMM\Product\PMMProductPaymentCompletedJob;
use App\Models\AppLog;
use App\Models\HR\Post\HRPost;
use App\Models\Payment\Payment;
use App\Models\PM\Project\PMMyTask;
use App\Models\PM\Project\PMpost;
use App\Models\PMM\Affiliate\PMMAffiliate;
use App\Models\PMM\AffiliateLink\PMMAffiliateLink;
use App\Models\PMM\Product\PMMProduct;
use App\Models\PMM\Product\PMMProductImage;
use App\Models\SMS\SMSMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PMMTransactionsController extends Controller
{
    //asdasd
        public function index()
    {

       $data['list']=$this->process()
       ->when(!is_admin(),function($q2){
         $q2->where('user_id',auth_user_id())
                ->orWhereHas('link.product', function ($q) {
                    $q->where('user_id', auth_user_id());
                });
            })
       ->latest()->paginate(50);
        return view('pmm.transactions.index',$data);

    }

    public function search(Request $request)
    {

       $input=$request->all();
       $data['list']=$this->process()
       ->when(!is_admin(), function ($q2) {
        $q2->where(function ($q3) {
            $q3->where('user_id', auth_user_id())
                ->orWhereHas('link.product', function ($q) {
                    $q->where('user_id', auth_user_id());
                });
        });
    })
    ->when(!empty($input['name']), function ($q2) use ($input) {
        $q2->whereHas('link.product', function ($q) use ($input) {
            $q->where('name', 'like', '%' . $input['name'] . '%');
        });
    })
    ->when(!empty($input['status']), function ($q) use ($input) {
        $q->where('status', $input['status']);
    })
       ->latest()
       ->get();
        return view('pmm.transactions.ajax.main_list',$data);

    }
    public function updateDetails(Request $request,$id)
    {

        $data=$request->only(['order_status','note']);

     $item=$this->process()
     ->when(!is_admin(),function($q2){
         $q2->orWhereHas('link.product', function ($q) {
                    $q->where('user_id', auth_user_id());
                });
            })
     ->where('id',$id)->first();
      (clone $item)->update($data);

        $user_id=auth()->user()->id;

        if($data['order_status']=="Dispatched" && !SMSMessage::where(['reference_type'=>'order_dispatched','reference'=>$item->id])->exists())
        {
            $message = "Dear customer, your order #" . unique_encrypt($item->id) . " for " . $item->link->product->name . " has been dispatched and is on its way. Thank you for choosing us!";
            (new SMSController())->sendSms($message, $item->phone,'order_dispatched',$item->id,$user_id);

        }



        return response()->json(['code'=>1,'message'=>"order details updated successfully!"]);

    }
 public function completeTransaction(Request $request,$id)
    {
        $payment=$this->process()->where('id',unique_decrypt($id))->first();
        if(!empty($payment) && $payment->status!="Completed")
        {
            $mailData['payment_id']=$payment->id;
            $mailData['amount']=$payment->amount;
            PMMProductPaymentCompletedJob::dispatch($mailData);
            return response()->json(['code'=>1,'message'=>"order details updated successfully!"]);
        }else
        {
        return response()->json(['code'=>0,'message'=>"unable to complete payments"]);
        }

    }
 public function detail(Request $request,$id)
    {

        $data=$request->only(['order_status','note']);

     $data['item']=$this->process()
     ->with(['paymentlogs'])
     ->where('id',unique_decrypt($id))
             // ->when(!is_admin(),function($q2){
        //  $q2->where('user_id',auth_user_id())
        //         ->orWhereHas('link.product', function ($q) {
        //             $q->where('user_id', auth_user_id());
        //         });
        //     })
        ->first();
     $data['domain']= $data['item']->link->customdomain;
      return view('pmm.transactions.detail',$data);

    }
    public function process()
    {

      return Payment::query();



    }


}
