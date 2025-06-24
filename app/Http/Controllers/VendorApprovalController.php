<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VendorApprovalController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status'); // ambil filter dari dropdown (jika ada)

        $vendors = User::where('role', 'vendor')
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('superadmin.request', compact('vendors'));
    }


    public function show($id)
    {
        $vendor = User::findOrFail($id);
        return view('superadmin.view_detail', compact('vendor'));
    }

    public function accept($id)
    {
        $vendor = User::findOrFail($id);
        $vendor->status = 'approved';
        $vendor->save();

        return redirect()->route('superadmin.request')->with('success', 'Vendor berhasil diterima!');
    }

    public function reject($id)
    {
        $vendor = User::findOrFail($id);
        $vendor->status = 'rejected';
        $vendor->save();

        return redirect()->route('superadmin.request')->with('error', 'Vendor ditolak.');
    }
}
