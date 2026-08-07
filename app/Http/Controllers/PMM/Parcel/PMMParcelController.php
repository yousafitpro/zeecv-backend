<?php

namespace App\Http\Controllers\PMM\Parcel;
//aasd
use App\Http\Controllers\Controller;
use App\Models\Parcel;
use App\Models\PMM\Product\PMMProduct;
use Illuminate\Http\Request;
class PMMParcelController extends Controller
{
        public function index()
    {

       $data['list']=$this->process()
    //    ->when(!is_admin() && !is_has_role('Marketer'),function($q2){
    //             $q2->where('user_id',auth()->user()->id);
    //         })
       ->latest()->paginate(50);
        return view('pmm.parcel.index',$data);

    }
public function shopSearch(Request $request)
{
    $input = $request->all();

    $products = $this->process()
        ->when(!empty($input['status']), function($q) use ($input) {
            $q->where('status', $input['status']);
        })
        ->when(!empty($input['name']), function ($q) use ($input) {
            $q->where('name', 'like', '%' . $input['name'] . '%');
        })
        ->when(!empty($input['price']), function ($q) use ($input) {
            $q->where('price', '<=', $input['price']);
        })
        ->latest()
        ->get();

    // Pass products as an array key
   return view('frontend.themes.eshoper.ajax.products', ['products' => $products]);
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
        return view('pmm.product.ajax.main_list',$data);

    }
    public function process()
    {

     return Parcel::query();


    }
}

