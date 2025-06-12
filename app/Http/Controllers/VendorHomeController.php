<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VendorHomeController extends Controller
{
     public function index()
    {
        return view('vendor.dashboardvendor');
    }
}
