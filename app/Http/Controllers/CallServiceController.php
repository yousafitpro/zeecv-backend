<?php

namespace App\Http\Controllers\CallServiceController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CallServiceController extends Controller
{
    public function index()
    {
        return view('ppm.callcenter.index');
    }
}
