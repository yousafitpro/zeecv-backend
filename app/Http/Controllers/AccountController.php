<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Payment\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
class AccountController extends Controller
{
    public function invoicePdf($id){
    $items=Payment::where('id',unique_decrypt($id))->get();
    $subtotal=$items->sum('amount');
    
    $pdf = Pdf::loadView('pdfs.invoice',['items'=>$items,'subtotal'=>$subtotal,'id'=>$id]);
      $pdf->setOptions([
         'isHtml5ParserEnabled' => true,
         'isRemoteEnabled' => true,
         'defaultPaperSize' => 'a4',  // Add this line
      ]);
      //   dd($data['cv']);
      return $pdf->stream('resume.pdf');
      return $pdf->download('zeecv-'.$id.'.pdf');
    }
    public function index()
    {
        $mysub=my_subscription();
        $data['invoices']=Payment::where('user_id',auth_user_id())->latest('id')->get();
        if(!empty($mysub)){
            $data['subscription']=$mysub['sub'];
            $data['is_expired']=$mysub['is_expired'];
        }else{
            $data['subscription']=null;
            $data['is_expired']=true;
        }

        return view('account.index',$data);
    }
}
