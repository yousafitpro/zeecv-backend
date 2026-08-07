<?php

namespace App\Http\Controllers\SP;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PMM\Transactions\PMMTransactionsController;
use App\Models\AppLog;
use App\Models\Blog\Post\BlogPost;
use App\Models\HR\Post\HRPost;
use App\Models\MyRole\UserSetting;
use App\Models\Payment\Payment;
use App\Models\PM\Project\PMMyTask;
use App\Models\PM\Project\PMpost;
use App\Models\PMM\Affiliate\PMMAffiliate;
use App\Models\PMM\AffiliateLink\PMMAffiliateLink;
use App\Models\PMM\Merchant\PMMMerchant;
use App\Models\PMM\Paymentticket\PMMPaymentticket;
use App\Models\PMM\Product\PMMProduct;
use App\Models\PMM\Product\PMMProductImage;
use App\Models\SP\SPTicket;
use App\Models\SP\SPTicketMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SPController extends Controller
{
    public function myusers()
    {
        if (is_admin()) {
        // Returns id => name, excluding self
        $users = User::query()
            ->where('id', '!=', auth_user_id())
            ->pluck('name', 'id');
        } elseif (is_has_role('marketer')) {
            // Get marketers with user info, excluding self
            $users = PMMMerchant::with('user')
                ->get()
                ->reject(fn($merchant) => $merchant->user_id == auth_user_id())
                ->mapWithKeys(fn($merchant) => [$merchant->user_id => $merchant->user->name ?? '']);
        } elseif (is_has_role('Merchant')) {
            // Get users who have affiliate links on this merchant's products, excluding self
            $users = PMMAffiliateLink::whereHas('product', function ($query) {
                    $query->where('user_id', auth_user_id());
                })
                ->with('user')
                ->get()
                ->reject(fn($link) => $link->user_id == auth_user_id())
                ->mapWithKeys(fn($link) => [$link->user_id => $link->user->name ?? '']);
        } else {
            $users = collect(); // return empty collection if no match
        }


        return $users;
    }

     public function tickets()
    {

       $data['list']=$this->process()
       ->latest()->paginate(50);
        $data['myusers']=$this->myusers();
        return view('sp.tickets.index',$data);

    }
        public function index()
    {
        $data['myaccount']=BlogPost::where('department','My Account')->where('placement','Support')->get();
        $data['payments']=BlogPost::where('department','Payments')->where('placement','Support')->get();
               $data['setting']=UserSetting::firstOrCreate([
                'user_id' =>who_is_admin()
            ]);
        return view('sp.index',$data);

    }
    public function chat($id)
    {
        $data['item']=$this->process()->where('id',unique_decrypt($id))->first();
        return view('sp.tickets.chat',$data);

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
        return view('sp.tickets.ajax.main_list',$data);

    }
    public function process()
    {
       $user_id= auth_user_id();
      return SPTicket::query()
        ->when(!is_admin(), function ($query) use ($user_id) {
            $query->where(function ($q) use ($user_id) {
                $q->where('user_id', $user_id)
                ->orWhereHas('members', function ($has) use ($user_id) {
                    $has->where('user_id', $user_id);
                });
            });
        });
    }
   public function add()
    {
          $data['myusers']=$this->myusers();
        return view('sp.tickets.add',$data);
    }
    public function addPost(Request $request)
    {
        $data=$request->except('_token');
        try{
            DB::beginTransaction();
            $ticket=SPTicket::isAdmin()->create([
                'subject'=>$data['subject'],
                'priority'=>$data['priority'],
                'user_id'=>auth_user_id(),
                'created_by_id'=>auth_user_id(),
                'description'=>$data['description'],
                'status'=>"Created"
            ]);
        SPTicketMember::updateOrCreate(
            ['ticket_id'=>$ticket->id,'user_id'=>who_is_support()],[]);
            if(!empty($data['users']))
            {
                foreach($data['users'] as $user_id)
                {
                SPTicketMember::updateOrCreate(
                    ['ticket_id'=>$ticket->id,'user_id'=>$user_id],[]);
                }
            }

        DB::commit();
         return response()->json(['code'=>1,'message'=>"ticket added successfully!",'url'=>route('sp.tickets.chat',unique_encrypt($ticket->id))]);
        }catch(\Exception $e)
        {
            DB::rollBack();
           return response()->json(['code'=>0,'message'=>$e->getMessage()]);
        }

    }

    public function update(Request $request,$id)
    {
      $data['item'] = SPTicket::isAdmin()->find($id);
        return view('sp.tickets.update',$data);
    }




    public function logs(Request $request,$id)
    {
        $data['list']=AppLog::where([
            'type'=>'project',
            'reference'=>$id
        ])->with(['user'])->get();
         return view('sp.tickets.logs.index',$data);
    }
    public function updatePost(Request $request,$id)
    {
        $data=$request->except(['_token']);

        $ticket = SPTicket::isAdmin()->find($id);
        $attachment = $request->file('document_identity');

                if ($attachment) {
                    $data['document_identity']=fun_save_file($attachment,'uploads');
                    $ticket->document_identity=$data['document_identity']->id;
                    $ticket->save();
                }
        $Payload['old'] = $ticket->replicate();
        $ticket->update([
                'subject'=>$data['subject'],
                'priority'=>$data['priority'],
                'description'=>$data['description'],
                'status'=>$data['status']
            ]);



        $Payload['updated'] = $ticket->fresh('user');
        app_log(auth_user_id(),'ticket',$id,"ticket Updated",$Payload);
        return response()->json(['code'=>1,'message'=>"ticket updated successfully!",'item_url'=>$ticket->documentidentity->file_url??'']);
    }

    public function remove(Request $request,$id)
    {
       try{
        DB::beginTransaction();
       SPTicket::hasPermission('pm.tickets.full_control')->find($id)->user->delete();
       SPTicket::hasPermission('pm.tickets.full_control')->find($id)->delete();
       DB::commit();
       return response()->json(['code'=>1,'message'=>"Employee deleted successfully!"]);
       }catch(\Exception $e)
       {
        DB::rollBack();
         return response()->json(['code'=>0,'message'=>"Project cannot be deleted successfully!"]);
       }

    }

}
