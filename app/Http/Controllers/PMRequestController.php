<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\PMRequest;
use Illuminate\Http\Request;
use App\Imports\PMRequestImport;
use Maatwebsite\Excel\Facades\Excel;

class PMRequestController extends Controller
{
    public function index()
    {
        $requests = PMRequest::all();
        return view('projectmanager.addrequest', compact('requests'));
    }

    public function create()
    {
        $pmRequest = null;
        $projectName = Auth::user()->project_name; // ambil dari user yang login
        return view('projectmanager.formadd', compact('pmRequest', 'projectName'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'qty' => 'required|integer',
            'unit' => 'required|string',
            'commcode' => 'nullable|string',
            'description' => 'required|string',
            'specification' => 'nullable|string',
            'required_delivery_date' => 'nullable|date',
            'remarks' => 'nullable|string',
        ]);

         // Tambahkan project_name manual dari Auth
         $validated['project_name'] = Auth::user()->project_name;

        PMRequest::create($validated);

        return redirect()->route('projectmanager.addrequest')->with('success', 'Request berhasil ditambahkan.');
    }

    public function showAll()
    {
        $requests = PMRequest::all();
        return view('projectmanager.addrequest', compact('requests'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new PMRequestImport, $request->file('file'));

        return redirect()->route('projectmanager.addrequest')->with('success', 'Data berhasil diimport dari Excel.');
    }

    public function downloadTemplate()
    {
        $path = public_path('templates/template-pm-request.xlsx');
        return response()->download($path, 'Template_Request_Barang.xlsx');
    }

}