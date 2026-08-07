<?php

namespace App\Http\Controllers\PMM\PaymentProfile;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PMM\Transactions\PMMTransactionsController;
use App\Models\AppLog;
use App\Models\HR\Post\HRPost;
use App\Models\Payment\Payment;
use App\Models\PM\Project\PMMyTask;
use App\Models\PM\Project\PMpost;
use App\Models\PMM\Affiliate\PMMAffiliate;
use App\Models\PMM\AffiliateLink\PMMAffiliateLink;
use App\Models\PMM\Paymentprofile\PMMPaymentprofile;
use App\Models\PMM\Product\PMMProduct;
use App\Models\PMM\Product\PMMProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PMMPaymentProfileController extends Controller
{
        public function index()
    {

       $data['list']=$this->process()
       ->with(['profileidentity'])
       ->latest()->paginate(50);

        return view('pmm.paymentprofile.index',$data);

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
        return view('pmm.paymentprofile.ajax.main_list',$data);

    }
    public function process()
    {

      return PMMPaymentprofile::query()->isAdmin()
      ->with(['profileidentity']);



    }
   public function add()
    {

        return view('pmm.paymentprofile.add');
    }
    public function addPost(Request $request)
    {
        $data=$request->except('_token');

        try{
            DB::beginTransaction();
            $profile=PMMPaymentprofile::isAdmin()->create([
                'payment_method'=>$data['payment_method'],
                'address_address'=>$data['address_address'],
                'address_zipcode'=>$data['address_zipcode'],
                'address_province'=>$data['address_province'],
                'payment_iban'=>$data['payment_iban'],
                'address_city'=>$data['address_city'],
                'address_country'=>$data['address_country'],
                'business_name'=>$data['business_name'],
                'vat'=>$data['vat'],
                'legal_entity'=>$data['legal_entity'],
                'user_id'=>auth_user_id(),
                'created_by_id'=>auth_user_id(),
                'status'=>"Created"
            ]);
            $document_identity = $request->file('document_identity');
            if ($document_identity) {
                    $data['document_identity']=fun_save_file($document_identity,'uploads');
                    $profile->document_identity=$data['document_identity']->id;
                    $profile->save();
                }
        DB::commit();
         return response()->json(['code'=>1,'message'=>"profile added successfully!"]);
        }catch(\Exception $e)
        {
            DB::rollBack();
           return response()->json(['code'=>0,'message'=>$e->getMessage()]);
        }

    }

    public function update(Request $request,$id)
    {
      $data['item'] = PMMPaymentprofile::isAdmin()->with(['profileidentity'])->find($id);
        return view('pmm.paymentprofile.update',$data);
    }




    public function logs(Request $request,$id)
    {
        $data['list']=AppLog::where([
            'type'=>'project',
            'reference'=>$id
        ])->with(['user'])->get();
         return view('pmm.paymentprofile.logs.index',$data);
    }
    public function updatePost(Request $request,$id)
    {
        $data=$request->except(['_token']);

        $profile = PMMPaymentprofile::isAdmin()->find($id);
        $attachment = $request->file('document_identity');

                if ($attachment) {
                    $data['document_identity']=fun_save_file($attachment,'uploads');
                    $profile->document_identity=$data['document_identity']->id;
                    $profile->save();
                }
        $Payload['old'] = $profile->replicate();
        $profile->update([
                'payment_method'=>$data['payment_method'],
                'address_address'=>$data['address_address'],
                'address_zipcode'=>$data['address_zipcode'],
                'address_province'=>$data['address_province'],
                'payment_iban'=>$data['payment_iban'],
                'address_city'=>$data['address_city'],
                'address_country'=>$data['address_country'],
                'business_name'=>$data['business_name'],
                'vat'=>$data['vat'],
                'legal_entity'=>$data['legal_entity'],
                'status'=>"Created"
            ]);



        $Payload['updated'] = $profile->fresh('user');
        app_log(auth_user_id(),'profile',$id,"profile Updated",$Payload);
        return response()->json(['code'=>1,'message'=>"profile updated successfully!",'item_url'=>$profile->documentidentity->file_url??'']);
    }

    public function remove(Request $request,$id)
    {
       try{
        DB::beginTransaction();
       PMMPaymentprofile::hasPermission('pm.profiles.full_control')->find($id)->user->delete();
       PMMPaymentprofile::hasPermission('pm.profiles.full_control')->find($id)->delete();
       DB::commit();
       return response()->json(['code'=>1,'message'=>"Employee deleted successfully!"]);
       }catch(\Exception $e)
       {
        DB::rollBack();
         return response()->json(['code'=>0,'message'=>"Project cannot be deleted successfully!"]);
       }

    }

}
