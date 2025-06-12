<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProcurementHomeController extends Controller
{
    public function index()
    {
        return view('procurement.dashboardproc'); // pastikan view-nya ada
    }
}
