<?php

namespace App\Http\Controllers\PMM\AffiliateLink;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PMM\Product\PMMProductController;
use App\Models\AppLog;
use App\Models\HR\Post\HRPost;
use App\Models\PM\Project\PMMyTask;
use App\Models\PM\Project\PMpost;
use App\Models\PMM\AffiliateLink\PMMAffiliateLink;
use App\Models\PMM\Product\PMMProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PMMAffiliateLinkController extends Controller
{
        public function index()
    {

       $data['list']=$this->process()
       ->latest()->paginate(50);
        return view('pmm.affiliate-link.index',$data);

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
       ->with(['product'])
       ->get();
        return view('pmm.affiliate-link.ajax.main_list',$data);

    }
    public function process()
    {

      return PMMAffiliateLink::query()->isAdmin();
    }




   public function add()
    {

        return view('pmm.affiliate-link.add');
    }
    public function updateAttribute(Request $request,$id)
    {

        $image_url='';
       $input=$request->only(['on_click','external_product_link','external_checkout_link','redirect_url','on_sale','thank_page_link','product_name','product_description']);
       $product=(new PMMProductController())->process()->where('id',$id)->first();
       $al=get_affiliate_link(auth()->user()->id,$product->id);
       $al->update($input);


        $attachment = $request->file('attachment');
        if ($attachment) {
        $data['attachment']=fun_save_file($attachment,'uploads');
        $al->product_image=$data['attachment']->id;
        $al->save();
        }
        if($al->attachment)
       {
         $image_url=$al->attachment->file_url;
       }
        return response()->json(['code'=>1,'message'=>"Updated successfully!",'image_link'=>$image_url]);

    }
     public function generate(Request $request,$id)
    {
        $data=$request->except('_token');
        $product = PMMProduct::where('id', $id)
                     ->where('status', 'active')
                     ->first();
        try{
            DB::beginTransaction();
            $al=PMMAffiliateLink::create([
                'user_id'=>auth_user_id(),
                'created_by_id'=>auth_user_id(),
                'product_id'=>$product->id,
                'status'=>'active'
            ]);
        DB::commit();
         return response()->json(['code'=>1,'message'=>"Affiliation Link Created successfully!",'link'=>route('pmm.product.purchase',product_encrypt($al->id))]);
        }catch(\Exception $e)
        {
            DB::rollBack();
           return response()->json(['code'=>0,'message'=>$e->getMessage()]);
        }

    }

    public function update(Request $request,$id)
    {
        $data['item']=PMMAffiliateLink::isAdmin()->find($id);
        return view('pmm.affiliate-link.update',$data);
    }
    public function logs(Request $request,$id)
    {
        $data['list']=AppLog::where([
            'type'=>'project',
            'reference'=>$id
        ])->with(['user'])->get();
         return view('pmm.affiliate-link.logs.index',$data);
    }
    public function updatePost(Request $request,$id)
    {
        $data=$request->except(['_token']);

        $product = PMMAffiliateLink::find($id);
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
       PMMAffiliateLink::hasPermission('pm.products.full_control')->find($id)->user->delete();
       PMMAffiliateLink::hasPermission('pm.products.full_control')->find($id)->delete();
       DB::commit();
       return response()->json(['code'=>1,'message'=>"Employee deleted successfully!"]);
       }catch(\Exception $e)
       {
        DB::rollBack();
         return response()->json(['code'=>0,'message'=>"Project cannot be deleted successfully!"]);
       }

    }

}
