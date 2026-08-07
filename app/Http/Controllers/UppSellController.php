<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UppSell;
use App\Models\UpSellItems;
use App\Models\PMM\Product\PMMProduct;
use Symfony\Component\HttpFoundation\Response;

class UppSellController extends Controller
{



public function fetchaupsell($id)
{
    $getUpSell = UppSell::where('product_id', $id)
                        ->where('type', 'custom')
                        ->first();

    return response()->json($getUpSell); 
}
public function store(Request $request){
    
    $upsell = UppSell::create([
        'name' => $request->title,
        'price' => $request->price,
        'product_id' => $request->product_id,
            'type'  =>$request->type
        ]);
     
    // Return JSON with data + message
    return response()->json([
        'code' => 1,
        'message' => 'Up Sell added  successfully in this product !',
        'upsell' => $upsell
    ]);
}

 function store_item(Request $request){
   

    $upsell = UpSellItems::create([
        'name' => $request->title,
       
        'upp_sell_id' => $request->product_id,
    ]);

    // Return JSON with data + message
    return response()->json([
        'code' => 1,
        'message' => 'Added Item successfully in this Up Sell !',
        'upsell' => $upsell
    ]);
}
public function edit($id){
    $upsell = UppSell::findOrFail($id);
    return response()->json($upsell);
}
public function update(Request $request)
{
    
   
  
    $upsell = UppSell::findOrFail($request->id);
    $upsell->update([
        'name' => $request->title,
        'price' => $request->price
    ]);
     
    return response()->json([
        'success' => true,
        'message' => 'Up Sell updated successfully!',
        'id' => $upsell->id,
        'name' => $upsell->name,
        'price' => $upsell->price
    ]);
}
 function item_update(Request $request)
{
    
   
  
    $upsell = UpSellItems::findOrFail($request->id);
    $upsell->update([
        'name' => $request->title,
      
    ]);
     
    return response()->json([
        'success' => true,
        'message' => 'Up Sell updated successfully!',
        'id' => $upsell->id,
        'name' => $upsell->name,
       
    ]);
}
public function destroy($id)
{
    $upsell = UppSell::findOrFail($id);
    $upsell->delete();

    return response()->json([
        'success' => true,
        'message' => 'Up Sell deleted successfully!'
    ]);
}
function item_destroy($id){
      $upsell = UpSellItems::findOrFail($id);
    $upsell->delete();

    return response()->json([
        'success' => true,
        'message' => 'Up Sell deleted successfully!'
    ]);
}

  function upsell_items($id){
           $item=UppSell::find($id);
       
         $upsells=UpSellItems::where('upp_sell_id',$id)->get();
        
          return view('pmm.product.upp_sell.items', compact('upsells','item'));
  }
public function deleteUpsell(Request $request)
{
    $id = $request->upsell_id;

    $upsell = UppSell::find($id);

    if ($upsell) {
        $upsell->delete();
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false], 404);
}
public function deleteCustomUpsell(Request $request)
{
 
    $upsell = UpSellItems::where('upp_sell_id',$request->upsell_id);

    if (!$upsell) {
        return response()->json([
            'status' => false,
            'message' => 'UpSell not found'
        ]);
    }

    $upsell->delete();

    return response()->json([
        'status' => true,
        'message' => 'UpSell deleted successfully'
    ]);
}

}
