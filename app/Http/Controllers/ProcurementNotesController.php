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

        // Fetch all requests with the same procurement_kode
        $requests = PMRequest::where('procurement_kode', $user->procurement_kode)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('procurement.notes', compact('requests'));
    }

    public function detailNote($id)
    {
        // Fetch the specific request
        $request = PMRequest::findOrFail($id);

        // Validate that the user has access to this request
        if ($request->procurement_kode !== Auth::user()->procurement_kode) {
            abort(403, 'Unauthorized access to this procurement request.');
        }

        // Optionally fetch related user data if needed
        $user = $request->user;

        return view('procurement.detailnote', compact('request', 'user'));
    }
}