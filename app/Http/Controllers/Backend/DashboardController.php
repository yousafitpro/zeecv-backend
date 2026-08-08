<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Ledger\LedgerController;
use App\Http\Controllers\PMM\Graph\PMMGraphController;
use App\Http\Controllers\PMM\Product\PMMProductController;
use App\Http\Controllers\PMM\Transactions\PMMTransactionsController;
use App\Models\PMM\Product\PMMProduct;
use App\Models\PMM\Product\PMMProductClick;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
           $user=auth()->user();
           if($user->type=="User"){
             return $this->userDasboard($request);
           }
        $data['products'] = (new PMMProductController())->process()->where('status','active')->latest()->take(4)->get();
        $data['orders']=(new PMMTransactionsController())->process()
        ->whereDate('created_at', Carbon::today())
        ->when(!is_admin(),function($q2){
            $q2->where('user_id',auth_user_id())
                    ->orWhereHas('link.product', function ($q) {
                        $q->where('user_id', auth_user_id());
                    });
                })->latest()->take(10)->get();
        return view('dashboard.index',$data);
    }

    public function userDasboard(Request $request){
        return view('zeecv.dashboard');
    }
public function getMonthlyProductStats(Request $request)
{
    return response()->json((new PMMGraphController())->ProductInsigts($request));
}
public function getMonthlyProductClicks(Request $request)
 {
    return response()->json((new PMMGraphController())->ProductClicksInsights($request));
 }


public function monthlyTransactionStats(Request $request)
{
    return response()->json((new PMMGraphController())->ProductTransactionsInsights($request));
}
public function clicksAndLeads(Request $request)
{
    return response()->json((new PMMGraphController())->clicksAndLeads($request));
}
}
