<?php

namespace App\Http\Controllers\PMM\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\AppLog;
use App\Models\HR\Post\HRPost;
use App\Models\PM\Project\PMMyTask;
use App\Models\PM\Project\PMpost;
use App\Models\PMM\AffiliateLink\PMMAffiliateLink;
use App\Models\PMM\Affiliate\PMMAffiliate;
use App\Models\PMM\Merchant\PMMMerchant;
use App\Models\PMM\Product\PMMProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PMMAffiliateController extends Controller
{
        public function index()
    {

       $data['list']=$this->process()
       ->latest()->paginate(50);
        return view('pmm.affiliate.index',$data);

    }

    public function search(Request $request)
    {
       $input=$request->all();
       $data['list']=$this->process()
        ->when(!empty($input['status']),function($q)use($input){
        $q->where('status',$input['status']);
       })
        ->when(!empty($input['name']), function ($q) use ($input) {
            $q->whereHas('product', function ($q2) use ($input) {
                $q2->where('name', 'like', '%' . $input['name'] . '%');
            });
        })
       ->latest()
       ->get();
        return view('pmm.affiliate.ajax.main_list',$data);

    }
    public function process()
    {

      return PMMAffiliate::query();
    }




   public function add()
    {

        return view('pmm.affiliate.add');
    }


    public function update(Request $request,$id)
    {
        $data['item']=PMMAffiliate::isAdmin()->find($id);
        return view('pmm.affiliate.update',$data);
    }
    public function logs(Request $request,$id)
    {
        $data['list']=AppLog::where([
            'type'=>'project',
            'reference'=>$id
        ])->with(['user'])->get();
         return view('pmm.affiliate.logs.index',$data);
    }
    public function updatePost(Request $request,$id)
    {
        $data=$request->except(['_token']);

        $product = PMMAffiliate::find($id);
        $attachment = $request->file('attachment');

                if ($attachment) {
                    $data['attachment']=fun_save_file($attachment,'uploads');
                    $product->app_file_id=$data['attachment']->id;
                    $product->save();
                }
        $Payload['old'] = $product->replicate();
        $product->update([
                'name'=>$data['name'],
                'description'=>$data['description'],
                'status'=>$data['status']
            ]);



        $Payload['updated'] = $product->fresh('user');
        app_log(auth_user_id(),'product',$id,"product Updated",$Payload);
        return response()->json(['code'=>1,'message'=>"product updated successfully!",'item_url'=>$product->attachment->file_url??'']);
    }

    public function remove(Request $request,$id)
    {
       try{
        DB::beginTransaction();
       PMMAffiliate::hasPermission('pm.products.full_control')->find($id)->user->delete();
       PMMAffiliate::hasPermission('pm.products.full_control')->find($id)->delete();
       DB::commit();
       return response()->json(['code'=>1,'message'=>"Employee deleted successfully!"]);
       }catch(\Exception $e)
       {
        DB::rollBack();
         return response()->json(['code'=>0,'message'=>"Project cannot be deleted successfully!"]);
       }

    }

}
