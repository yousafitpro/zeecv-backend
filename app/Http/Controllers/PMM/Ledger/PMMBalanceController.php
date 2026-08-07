<?php

namespace App\Http\Controllers\PMM\Ledger;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PMM\Transactions\PMMTransactionsController;
use App\Models\AppLog;
use App\Models\Payment\Ledger;
use App\Models\PMM\Paymentprofile\PMMPaymentprofile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PMMBalanceController extends Controller
{
        public function index()
    {

       $data['list']=$this->process()
       ->latest()->paginate(50);

        return view('pmm.ledger.balance.index',$data);

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
        return view('pmm.ledger.balance.ajax.main_list',$data);

    }
    public function process()
    {

      return Ledger::query()->isAdmin();



    }
   public function add()
    {
        $data['users']=User::query()->get();
        return view('pmm.ledger.balance.add',$data);
    }
    public function addPost(Request $request)
    {
        $data=$request->except('_token');

        try{
            DB::beginTransaction();
            $payload=[];
            $payload['user_id']=$data['user_id'];
            $payload['narration']=$data['narration'];
            $payload['created_at']=$data['created_at'];
            $payload['internal_note']=$data['internal_note'];
            $payload['message']=$data['message'];
            if($data['type']=='credit')
            {
                $payload['credit']=$data['amount'];
            }
            if($data['type']=='debit')
            {
                $payload['debit']=$data['amount'];
            }
            Ledger::create($payload);
            DB::commit();
         return response()->json(['code'=>1,'message'=>"balance added successfully!"]);
        }catch(\Exception $e)
        {
            DB::rollBack();
           return response()->json(['code'=>0,'message'=>$e->getMessage()]);
        }

    }

    public function update(Request $request,$id)
    {
          $data['users']=User::query()->get();
      $data['item'] =$this->process()->find($id);
        return view('pmm.ledger.balance.update',$data);
    }




    public function logs(Request $request,$id)
    {
        $data['list']=AppLog::where([
            'type'=>'project',
            'reference'=>$id
        ])->with(['user'])->get();
         return view('pmm.ledger.balance.logs.index',$data);
    }
    public function updatePost(Request $request,$id)
    {
        $data=$request->except(['_token']);

        $balance = Ledger::isAdmin()->find($id);

        $Payload['old'] = $balance->replicate();
        $balance->update([
                'internal_note'=>$data['internal_note'],
                'created_at'=>$data['created_at']
            ]);



        $Payload['updated'] = $balance->fresh('user');
        app_log(auth_user_id(),'balance',$id,"balance Updated",$Payload);
        return response()->json(['code'=>1,'message'=>"Balance updated successfully!"]);
    }

    public function remove(Request $request,$id)
    {
       try{
        DB::beginTransaction();
       Ledger::hasPermission('pm.profiles.full_control')->find($id)->user->delete();
       Ledger::hasPermission('pm.profiles.full_control')->find($id)->delete();
       DB::commit();
       return response()->json(['code'=>1,'message'=>"Employee deleted successfully!"]);
       }catch(\Exception $e)
       {
        DB::rollBack();
         return response()->json(['code'=>0,'message'=>"Project cannot be deleted successfully!"]);
       }

    }

}
