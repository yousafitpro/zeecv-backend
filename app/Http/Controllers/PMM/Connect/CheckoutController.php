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

class CheckoutController extends Controller
{



    public function updateFields(Request $request,$product_id)
    {
        $product=(new PMMProductController())->process()->find(product_decrypt($product_id));
            $affiliate_link=get_affiliate_link(auth_user_id(),$product->id);
            $affiliate_link->update([
                'fields_address'=>$request->has('fields_address')?1:0,
                'fields_city'=>$request->has('fields_city')?1:0,
                'fields_zip'=>$request->has('fields_zip')?1:0,
                'fields_state'=>$request->has('fields_state')?1:0,
                'fields_quantity'=>$request->has('fields_quantity')?1:0,
                'fields_country'=>$request->has('fields_country')?1:0,
                'fields_email'=>$request->has('fields_email')?1:0,
            ]);

        return response()->json(['code'=>1,'message'=>"Updated successfully"]);
    }


}
