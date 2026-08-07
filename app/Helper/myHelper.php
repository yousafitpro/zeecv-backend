<?php

namespace App\Helper;

use App\Models\BankAccount;
use App\Models\Bill;
use App\Models\etransfer;
use App\Models\LocBankAccount;
use App\Models\mypayee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
//sadasdasd
class myHelper
{

 public static function createSimpleString($str)
 {
     $str= str_ireplace(array(' ','@'),'',$str);
     $str=strtolower($str);
     return $str;
 }
}
