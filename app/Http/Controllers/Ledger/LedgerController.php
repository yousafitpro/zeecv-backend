<?php

namespace App\Http\Controllers\Ledger;

use App\Http\Controllers\Controller;
use App\Models\Payment\Ledger;

class LedgerController extends Controller
{

    public function process()
    {

      return Ledger::query();



    }


}
