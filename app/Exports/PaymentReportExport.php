<?php 

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PaymentReportExport implements FromView
{
    protected $payments;

    public function __construct($orders)
    {
        $this->payments = $orders; 
    }

    public function view(): View
    {
        return view('pmm.callcenter.report', [
            'payments' => $this->payments, 
        ]);
    }
}

