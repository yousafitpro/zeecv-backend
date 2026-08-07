<?php

namespace App\Http\Controllers\PMM\Connect;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PMM\Product\PMMProductController;
use App\Models\Connect\ConnectLink;
use App\Models\Connect\CustomDomain;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CONCustomDomainController extends Controller
{


    public function index(Request $request)
    {

        $data['domain'] =auth()->user()->customdomain;
        return view('connect.customdomain.index',$data);
    }
    public function update(Request $request,$product_id)
    {
        $product=(new PMMProductController())->process()->find(product_decrypt($product_id));

        if($request->has('domain') && $product)
        {
            $affiliate_link=get_affiliate_link(auth_user_id(),$product->id);
         CustomDomain::where('link_id',$affiliate_link->id)->update([
            'domain'=>$request->domain,
            'order_tracking'=>$request->has('order_tracking')?'true':false,
            'order_comeback'=>$request->has('order_comeback')?'true':false,
            'order_checkout'=>$request->has('order_checkout')?'true':false,
        ]);
        }

        return response()->json(['code'=>1,'message'=>"Updated successfully"]);
    }


}
