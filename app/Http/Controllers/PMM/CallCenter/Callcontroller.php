<?php

namespace App\Http\Controllers\PMM\CallCenter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\SMS\SMSController;
use App\Jobs\PMM\Product\PMMProductPaymentCompletedJob;
use App\Models\AppLog;
use App\Models\HR\Post\HRPost;
use App\Models\Payment\Payment;
use App\Models\PM\Project\PMMyTask;
use App\Models\PM\Project\PMpost;
use App\Models\PMM\Affiliate\PMMAffiliate;
use App\Models\PMM\AffiliateLink\PMMAffiliateLink;
use App\Models\PMM\Product\PMMProduct;
use App\Models\PMM\Product\PMMProductImage;
use App\Models\SMS\SMSMessage;
use Illuminate\Support\Facades\DB;
use App\Models\PMM\CC\PmmOrderNote;
use Carbon\Carbon;
use App\Models\PMM\Order\PMMOrder;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PaymentReportExport;
use App\Models\UppSell;
class Callcontroller extends Controller
{
    //
          public function index(Request $request)
    {
        $input=$request->all();
        if(empty($input['payment_method']))
        {
            $input['payment_method']="COD";
        }
       $data['list']=$this->process();
           $data['list']=$data['list']->when(!empty($input['payment_method']), function ($q2) use ($input) {
        $q2->whereHas('link.product', function ($q) use ($input) {
            $q->where('payment_method',$input['payment_method']);
        });
    });
   $data['list']= $data['list']->when(!empty($input['cc_status']), function ($q2) use ($input) {
        $q2->whereHas('order', function ($q) use ($input) {
            $q->where('cc_status',$input['cc_status']);
        });
    });
   $data['list']= $data['list']->when(!empty($input['order_status']), function ($q) use ($input) {
        $q->where('order_status', $input['order_status']);
    });
       $data['list']=$data['list']->latest()->paginate(50);
        return view('pmm.callcenter.index',$data);

    }

    
    public function updateDetails(Request $request, $id)
{
    $order = PMMOrder::where('payment_id', $id)->first();

    if ($order) {

        $BASE=new PmmOrderNote;
        $BASE->payment_id=$request->payment_id;
        $BASE->type=$request->order_status;
        $BASE->note=$request->order_status.'-'.$request->shipping_note;
        $BASE->user_id=auth_user_id();
        $BASE->save();
        $order->cc_status = $request->order_status;
        $order->save();
            $notes = PmmOrderNote::with('user') 
                ->where('payment_id', $request->payment_id)
                ->orderBy('id', 'desc')
                ->get()
                ->map(function ($note) {
                    if ($note->call_start && $note->call_end) {
                        $start = Carbon::parse($note->call_start);
                        $end = Carbon::parse($note->call_end);
                        $note->call_duration = $end->diff($start)->format('%H:%I:%S');
                    } else {
                        $note->call_duration = null;
                    }
                    return $note;
                });

        return response()->json([
            'code' => 1,
            'message' => "Order details updated successfully!",
            'notes' => $notes
        ]);
    } else {
        return response()->json([
            'code' => 0,
            'message' => "Order not found!"
        ]);
    }
}
public function search(Request $request)
{
    if(empty($input['payment_method']))
        {
            $input['payment_method']="COD";
        }
    $input = $request->all();
    $query = $this->process();

    $query->when(!empty($input['name']), function ($q2) use ($input) {
        $q2->whereHas('link.product', function ($q) use ($input) {
            $q->where('name', 'like', '%' . $input['name'] . '%');
        });
    });

    $query->when(!empty($input['payment_method']), function ($q2) use ($input) {
        $q2->whereHas('link.product', function ($q) use ($input) {
            $q->where('payment_method',$input['payment_method']);
        });
    });
    $query->when(!empty($input['cc_status']), function ($q2) use ($input) {
        $q2->whereHas('order', function ($q) use ($input) {
            $q->where('cc_status',$input['cc_status']);
        });
    });
    $query->when(!empty($input['order_status']), function ($q) use ($input) {
        $q->where('order_status', $input['order_status']);
    });


    $query->when(!empty($input['status']), function ($q) use ($input) {
        $q->where('status', $input['status']);
    });


    $query->when(!empty($input['from_date']) && !empty($input['to_date']), function ($q) use ($input) {
        $q->whereBetween('created_at', [
            $input['from_date'] . ' 00:00:00',
            $input['to_date'] . ' 23:59:59'
        ]);
    });

    $data['list'] = $query->latest()->get();

    // Attach payment + notes info
    foreach ($data['list'] as $item) {
        if (!empty($item->payment_id)) {
            $payment = Payment::find($item->payment_id);
            if ($payment) {
                $payment->notes = PmmOrderNote::with('user')
                    ->where('payment_id', $payment->id)
                    ->orderBy('id', 'desc')
                    ->get();
            }
            $item->payment = $payment;
        }
    }

    // ✅ If you want to download Excel for one payment (e.g., first one)
    if (!empty($data['list']->first()->payment)) {
        $payment = $data['list']->first()->payment;
        $filename = 'Payment_Report_' . $payment->id . '.xlsx';
        return Excel::download(new PaymentReportExport($payment), $filename);
    }

    // ✅ Otherwise show the results view
    return view('pmm.callcenter.ajax.main_list', $data);
}
public function updateDelivery(Request $request, $id)
{
    $order = Payment::find($request->payment_id);
   $Payload['old']=$order->replicate();
    if ($order) {
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->city = $request->city;
        $order->address = $request->address;
        $order->postalcode = $request->postal_code;
        $order->country = $request->country;
        $order->save();
        $Payload['updated']=$order->fresh();
        app_log(auth_user_id(),'order',$id,"order Updated",$Payload);
        return response()->json([
            'code' => 1,
            'message' => "Order details updated successfully!",
            'details' => $order  
        ]);
    } else {
        return response()->json([
            'code' => 0,
            'message' => "Order not found!"
        ]);
    }
}
 public function completeTransaction(Request $request,$id)
    {
        $payment=$this->process()->where('id',unique_decrypt($id))->first();
        if(!empty($payment) && $payment->status!="Completed")
        {
            $mailData['payment_id']=$payment->id;
            $mailData['amount']=$payment->amount;
            PMMProductPaymentCompletedJob::dispatch($mailData);
            return response()->json(['code'=>1,'message'=>"order details updated successfully!"]);
        }else
        {
        return response()->json(['code'=>0,'message'=>"unable to complete payments"]);
        }

    }
public function detail(Request $request, $id)
{ 
    
    $data = $request->only(['order_status','note']);
   
 
    $decryptedId = (int) unique_decrypt($id);
      $data['status']=PMMOrder::where('payment_id', $decryptedId)->first();
  
    $data['item'] = $this->process()
        ->where('id', $decryptedId)
        ->first();
  $data['link']=$data['item']->link;
  $data['product']=$data['link']->product;
  $data['user']=$data['product']->user;
  $data['user_primary_address']=$data['product']->user->primaryaddress;
    $prduct=$data['product'];
    $data['UpSells']=UppSell::where('product_id',$prduct->id)->get();

    
$data['notes'] = PmmOrderNote::where('payment_id', $decryptedId)
    ->orderBy('id', 'desc')
    ->get();
   
    if(!$data['item']){
        abort(404); 
    }

    $data['domain'] = $data['item']->link->customdomain ?? null;

    return view('pmm.callcenter.detail', $data);
}

    public function process()
    {

      return Payment::query();



    }
public function addCallLog(Request $request)
{
    $validated = $request->validate([
        'payment_id' => 'required|integer',
        'call_type' => 'required|string',
        'note' => 'nullable|string',
        'start_time' => 'nullable',
        'end_time' => 'nullable',
    ]);

    $get_user = Payment::find($request->payment_id);
    $get_user_id = $get_user->user_id;
   
    PmmOrderNote::create([
        'payment_id' => $validated['payment_id'],
        'type' => $validated['call_type'],
        'call_start' => $validated['start_time'],
        'call_end' => $validated['end_time'],
        'note' => $validated['note'],
        'status' => 'active',
        'user_id' =>auth_user_id(),
    ]);

$notes = PmmOrderNote::with('user') // include user relation
    ->where('payment_id', $validated['payment_id'])
    ->orderBy('id', 'desc')
    ->get()
    ->map(function ($note) {
        if ($note->call_start && $note->call_end) {
            $start = Carbon::parse($note->call_start);
            $end = Carbon::parse($note->call_end);
            $note->call_duration = $end->diff($start)->format('%H:%I:%S');
        } else {
            $note->call_duration = null;
        }
        return $note;
    });

    return response()->json([
        'success' => true,
        'message' => 'Call log added successfully!',
        'notes' => $notes
    ]);
}
public function downloadReport(Request $request)
{
    $input = $request->all();

    // Default: last 30 days
    $from = now()->subDays(30);
    $to = now();

    // If user selects dates
    if (!empty($input['from_date']) && !empty($input['to_date'])) {
        $from = \Carbon\Carbon::parse($input['from_date']);
        $to = \Carbon\Carbon::parse($input['to_date']);

        // Check if range > 30 days
        if ($from->diffInDays($to) > 30) {
            return back()->with('error', 'You can only download reports for a maximum of 30 days range.');
        }
    }

    // Fetch orders
    $orders = $this->process();
      $orders=$orders->when(!empty($input['payment_method']), function ($q2) use ($input) {
        $q2->whereHas('link.product', function ($q) use ($input) {
            $q->where('payment_method',$input['payment_method']);
        });
    });
    $orders=$orders->when(!empty($input['cc_status']), function ($q2) use ($input) {
        $q2->whereHas('order', function ($q) use ($input) {
            $q->where('cc_status',$input['cc_status']);
        });
    });
    $orders=$orders->when(!empty($input['order_status']), function ($q) use ($input) {
        $q->where('order_status', $input['order_status']);
    });
        $orders=$orders->when(!empty($input['name']), function ($q2) use ($input) {
            $q2->whereHas('link.product', function ($q) use ($input) {
                $q->where('name', 'like', '%' . $input['name'] . '%');
            });
        })
        ->when(!empty($input['status']), fn($q) => $q->where('status', $input['status']))
        ->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()])
        ->latest()
        ->get();

    // Attach related notes
    foreach ($orders as $order) {
        if (!empty($order->payment_id)) {
            $notes = \App\Models\PMM\CC\PmmOrderNote::with('user')
                ->where('payment_id', $order->payment_id)
                ->get();

            $order->notes = $notes;
        }
    }

    if ($orders->count() > 0) {
        $filename = 'Orders_Report_' . now()->format('Ymd_His') . '.xlsx';
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\PaymentReportSimpleExport($orders),
            $filename
        );
    }

    return back()->with('error', 'No records found.');
}



public function Dashboard()
{
    // Base payment query
    $query = $this->process();

    // ✅ Calculate statistics
    $stats = [
        'pending'    => (clone $query)->where('status', 'Pending')->count(),
        'completed'  => (clone $query)->where('status', 'Completed')->count(),
        'call1'      => PMMOrder::where('cc_status', 'Try Call 1')->count(),
        'call2'      => PMMOrder::where('cc_status', 'Try Call 2')->count(),
        'call3'      => PMMOrder::where('cc_status', 'Try Call 3')->count(),
        'shipping'   => PMMOrder::where('cc_status', 'Shipping')->count(),
        'cancelled'  => PMMOrder::where('cc_status', 'Cancelled')->count(),
    ];

    // ✅ Pass all stats to Blade view
    return view('pmm.callcenter.dashboard', compact('stats'));
}
public function monthlyOrderStats(Request $request)
{
    $filter = $request->input('filter', 'Today');
    $start = now()->startOfMonth();
    $end = now()->endOfMonth();

    // Adjust range based on filter
    switch ($filter) {
        case 'Yesterday':
            $start = now()->subDay()->startOfDay();
            $end = now()->subDay()->endOfDay();
            break;
        case 'Previous Month':
            $start = now()->subMonth()->startOfMonth();
            $end = now()->subMonth()->endOfMonth();
            break;
        case 'Yearly':
            $start = now()->startOfYear();
            $end = now()->endOfYear();
            break;
        case 'All':
            $start = now()->subYears(5); // last 5 years data
            $end = now();
            break;
        default:
            $start = now()->startOfMonth();
            $end = now()->endOfMonth();
    }

    // Group orders by date
    $completed = PMMOrder::where('cc_status', 'shipping')
        ->whereBetween('created_at', [$start, $end])
        ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->groupBy('date')
        ->pluck('count', 'date');

    $cancelled = PMMOrder::where('cc_status', 'Cancelled')
        ->whereBetween('created_at', [$start, $end])
        ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->groupBy('date')
        ->pluck('count', 'date');

    // Prepare chart data
    $labels = collect();
    $dataCompleted = collect();
    $dataCancelled = collect();

    $period = \Carbon\CarbonPeriod::create($start, $end);
    foreach ($period as $date) {
        $d = $date->format('Y-m-d');
        $labels->push($d);
        $dataCompleted->push($completed[$d] ?? 0);
        $dataCancelled->push($cancelled[$d] ?? 0);
    }

    return response()->json([
        'labels' => $labels,
        'completed' => $dataCompleted,
        'cancelled' => $dataCancelled
    ]);
}
public function pendingCompletedStats(Request $request)
{
    $filter = $request->input('filter', 'Monthly');
    $start = now()->startOfMonth();
    $end = now()->endOfMonth();

    switch ($filter) {
        case 'Today':
            $start = now()->startOfDay();
            $end = now()->endOfDay();
            break;
        case 'Yesterday':
            $start = now()->subDay()->startOfDay();
            $end = now()->subDay()->endOfDay();
            break;
        case 'Previous Month':
            $start = now()->subMonth()->startOfMonth();
            $end = now()->subMonth()->endOfMonth();
            break;
        case 'Yearly':
            $start = now()->startOfYear();
            $end = now()->endOfYear();
            break;
    }

    $pending = PMMOrder::where('cc_status', 'Pending')
        ->whereBetween('created_at', [$start, $end])
        ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->groupBy('date')
        ->pluck('count', 'date');

    $completed = PMMOrder::where('cc_status', 'shipping')
        ->whereBetween('created_at', [$start, $end])
        ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->groupBy('date')
        ->pluck('count', 'date');

    $labels = collect();
    $dataPending = collect();
    $dataCompleted = collect();

    $period = \Carbon\CarbonPeriod::create($start, $end);
    foreach ($period as $date) {
        $d = $date->format('Y-m-d');
        $labels->push($d);
        $dataPending->push($pending[$d] ?? 0);
        $dataCompleted->push($completed[$d] ?? 0);
    }

    return response()->json([
        'labels' => $labels,
        'pending' => $dataPending,
        'completed' => $dataCompleted
    ]);
}
   public function updateStatus(Request $request)
{
    $order =Payment::find($request->order_id);
   
    return response()->json([
        'code' => 1,
        'order' => $order
    ]);
}
public function saveStatus(Request $request)
{
    $order = Payment::find($request->order_id);

    if(!$order){
        return response()->json([
            'code' => 0,
            'message' => 'Order not found'
        ]);
    }

    $order->order_status = $request->status; 
    $order->save();

    return response()->json([
        'code' => 1,
        'message' => 'Order status updated'
    ]);
}
}

