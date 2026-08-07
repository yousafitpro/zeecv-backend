<?php

namespace App\Http\Controllers\PMM\Lookup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PMM\PMMCategory;
class lookupController extends Controller
{
    //
    public function index(){
        return view('pmm.lookup.category');
    }
     public function list()
    {
        $categories = PMMCategory::latest()->get();
        return response()->json($categories);
    }
public function add(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);
 $exists = PMMCategory::where('user_id', auth()->id())
                ->where('name', $request->name)
                ->exists();

    if ($exists) {
        return response()->json([
            'success' => false,
            'message' => 'Category already exists!'
        ]);
    }
    PMMCategory::create([
        'user_id' => auth()->id(),
        'name' => $request->name,
        'status' => 1,
    ]);

return response()->json(['success' => true, 'message' => 'Category added successfully!']);

}
      public function delete($id)
    {
        PMMCategory::findOrFail($id)->delete();
return response()->json(['success' => true, 'message' => 'Category deleted successfully!']);

    }

}
