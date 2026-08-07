<?php

namespace App\Http\Controllers\PMM\Lookup;

use App\Http\Controllers\Controller;
use App\Models\PMM\PMMAddress;
use Illuminate\Http\Request;
use App\Models\PMM\PMMCategory;
class AddressController extends Controller
{
    //
    public function index(){
        
        return view('pmm.lookup.address');
    }
    public function edit(Request $request,$id){
        $data['item']=PMMAddress::find($id);
        return view('pmm.lookup.edit-address',$data);
    }
        public function update(Request $request,$id){
        PMMAddress::where('id',$id)->update([
        'user_id' => auth()->id(),
        'name' => $request->name,
        'phone' => $request->phone,
        'city' => $request->city,
        'postal_code' => $request->postal_code,
        'province' => $request->province,
        'is_primary' => $request->has('is_primary')?1:0,
        'address' => $request->address,
        'status' => 1,
    ]);
        return  redirect()->back();
    }
     public function list()
    {
        $categories = PMMAddress::latest()->get();
        return response()->json($categories);
    }
public function add(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $address=PMMAddress::create([
        'user_id' => auth()->id(),
        'name' => $request->name,
        'phone' => $request->phone,
        'city' => $request->city,
        'postal_code' => $request->postal_code,
        'province' => $request->province,
        'is_primary' => $request->has('is_primary')?1:0,
        'address' => $request->address,
        'status' => 1,
    ]);
    if($request->has('is_primary'))
        {
    PMMAddress::where('id','!=',$address->id)->update(['is_primary'=>0]);
        }


return response()->json(['success' => true, 'message' => 'Address added successfully!']);

}
      public function delete($id)
    {
        PMMAddress::findOrFail($id)->delete();
return response()->json(['success' => true, 'message' => 'Address deleted successfully!']);

    }

}
