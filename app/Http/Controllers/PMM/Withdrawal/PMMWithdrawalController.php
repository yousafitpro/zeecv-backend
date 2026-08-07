<?php

namespace App\Http\Controllers\PMM\Withdrawal;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PMM\Transactions\PMMTransactionsController;
use App\Models\AppLog;
use App\Models\HR\Post\HRPost;
use App\Models\Payment\Ledger;
use App\Models\Payment\Payment;
use App\Models\PM\Project\PMMyTask;
use App\Models\PM\Project\PMpost;
use App\Models\PMM\Affiliate\PMMAffiliate;
use App\Models\PMM\AffiliateLink\PMMAffiliateLink;
use App\Models\PMM\Paymentprofile\PMMPaymentprofile;
use App\Models\PMM\Withdrawal\PMMWithdrawal;
use App\Models\PMM\Product\PMMProduct;
use App\Models\PMM\Product\PMMProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PMMWithdrawalController extends Controller
{
        public function index()
    {

       $data['list']=$this->process()
       ->latest()->paginate(50);

        return view('pmm.withdrawal.index',$data);

    }

    public function search(Request $request)
    {

       $input=$request->all();
       $data['list']=$this->process()
        ->when(!empty($input['status']),function($q)use($input){
        $q->where('status',$input['status']);
       })
        ->when(!empty($input['name']), function ($q) use ($input) {
            $q->where('name', 'like', '%' . $input['name'] . '%');
        })
       ->latest()
       ->get();
        return view('pmm.withdrawal.ajax.main_list',$data);

    }
    public function process()
    {

      return PMMWithdrawal::query()->isAdmin();



    }
   public function add()
    {
        $data['methods']=PMMPaymentprofile::where('user_id',auth_user_id())->get();
        return view('pmm.withdrawal.add',$data);
    }
    public function addPost(Request $request)
    {
        $data=$request->except('_token');
         $balance=my_balance(auth_user_id());
         if($balance['available']<=0 || $balance['available'] <$data['amount'])
         {
          return response()->json(['code'=>0,'message'=>"Oops! You don’t have enough balance. Your available balance is $".$balance['available']]);
         }
        try{
            DB::beginTransaction();
            $profile=PMMWithdrawal::isAdmin()->create([
                'payment_profile_id'=>$data['payment_profile_id'],
                'amount'=>$data['amount'],
                'user_id'=>auth_user_id(),
                'created_by_id'=>auth_user_id(),
                'status'=>"Pending"
            ]);
            $invoice = $request->file('invoice');
            if ($invoice) {
                    $data['invoice']=fun_save_file($invoice,'uploads');
                    $profile->invoice_id=$data['invoice']->id;
                    $profile->save();
                }
        DB::commit();
         return response()->json(['code'=>1,'message'=>"Withdrawal added successfully!"]);
        }catch(\Exception $e)
        {
            DB::rollBack();
           return response()->json(['code'=>0,'message'=>$e->getMessage()]);
        }

    }

    public function update(Request $request,$id)
    {
      $data['item'] = PMMWithdrawal::isAdmin()->find($id);
       $data['methods']=PMMPaymentprofile::where('user_id',auth_user_id())->get();
        return view('pmm.withdrawal.update',$data);
    }




    public function logs(Request $request,$id)
    {
        $data['list']=AppLog::where([
            'type'=>'project',
            'reference'=>$id
        ])->with(['user'])->get();
         return view('pmm.withdrawal.logs.index',$data);
    }
    public function updatePost(Request $request,$id)
    {
        $data=$request->except(['_token']);


        $withdrwal = PMMWithdrawal::isAdmin()->find($id);
        $attachment = $request->file('document_identity');

                if ($attachment) {
                    $data['document_identity']=fun_save_file($attachment,'uploads');
                    $withdrwal->document_identity=$data['document_identity']->id;
                    $withdrwal->save();
                }
        $Payload['old'] = $withdrwal->replicate();
        $withdrwal->update([
                'status'=>$data['status'],
                'note'=>$data['note']
            ]);

        if($data['status']=="Approved")
        {
            if(!Ledger::where([
                'reference_type'=>'withdrawal',
                'reference'=>$withdrwal->id,
                'user_id'=>$withdrwal->user_id
            ])->exists())
            {
                Ledger::create([
                'reference_type'=>'withdrawal',
                'reference'=>$withdrwal->id,
                'user_id'=>$withdrwal->user_id,
                'debit'=>$withdrwal->amount
            ]);
            }

        }

        $Payload['updated'] = $withdrwal->fresh('user');
        app_log(auth_user_id(),'profile',$id,"profile Updated",$Payload);
        return response()->json(['code'=>1,'message'=>"profile updated successfully!",'item_url'=>$withdrwal->documentidentity->file_url??'']);
    }

    public function remove(Request $request,$id)
    {
       try{
        DB::beginTransaction();
       PMMWithdrawal::hasPermission('pm.profiles.full_control')->find($id)->user->delete();
       PMMWithdrawal::hasPermission('pm.profiles.full_control')->find($id)->delete();
       DB::commit();
       return response()->json(['code'=>1,'message'=>"Employee deleted successfully!"]);
       }catch(\Exception $e)
       {
        DB::rollBack();
         return response()->json(['code'=>0,'message'=>"Project cannot be deleted successfully!"]);
       }

    }

}
