<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PMRequest;

class ProcurementNotesController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil semua request dengan procurement_kode yang sama
        $requests = PMRequest::where('procurement_kode', $user->procurement_kode)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('procurement.notes', compact('requests'));
    }

    public function detailNote($id)
    {
        $request = PMRequest::findOrFail($id);

        // Validasi keamanan
        if ($request->procurement_kode !== Auth::user()->procurement_kode) {
            abort(403);
        }

        return view('procurement.detail', compact('request'));
    }

}
