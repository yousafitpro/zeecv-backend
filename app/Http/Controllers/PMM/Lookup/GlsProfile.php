<?php

namespace App\Http\Controllers\PMM\Lookup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PMM\gls\profile;
use App\Models\Parcel;
use App\Models\UppSell;
use App\Models\UpSellItems;
class GlsProfile extends Controller
{
    //
    function index(){
        return view('pmm.lookup.profile');
    }
public function getUpsell($id)
{
    $upsell = UppSell::with('items')->where('parcel_id', $id)->first();
     $upsellItems=UpSellItems::where('upp_sell_id',$upsell->id)->get();
    
    if (!$upsell) {
        return response()->json(['status' => 0]);
    }

  

    return response()->json([
        'status' => 1,
        'data'   => $upsell,
        'items'  =>$upsellItems
    ]);
}


    public function add(Request $request)
{
    

    $address=profile::create([
        
        'user_id' => auth()->id(),
        'sede' => $request->sede,
        'name' => $request->name,
        'customer_code' => $request->customer_code,
        'contract_code' => $request->Contract_code,
        'password' => $request->password,
       
    ]);
    
return response()->json(['success' => true, 'message' => 'GLS Profile Address added  successfully!']);

}
  public function list()
    {
        $categories = profile::where('user_id',auth()->id())->latest()->get();
        return response()->json($categories);
    }
      public function delete_gls_pro($id)
    {
        profile::findOrFail($id)->where('user_id',auth()->id())->delete();
return response()->json(['success' => true, 'message' => 'GLS Profile deleted successfully!']);

    }


        public function gls_pro_edit(Request $request,$id){
        $data['item']=profile::find($id);
        return view('pmm.lookup.edit-profile-gls',$data);
    }

        public function update(Request $request,$id){
        profile::where('id',$id)->update([
        'user_id' => auth()->id(),
        'name' => $request->name,
        'sede' => $request->sede,
        'customer_code' => $request->customer_code,
        'Contract_code' => $request->Contract_code,
        'password' => $request->password,
       
    ]);
        return  redirect()->back()->with('success', 'Your GLS Profile Updated');
    }
}
