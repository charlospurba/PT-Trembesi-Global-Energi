<?php

namespace App\Http\Controllers;

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
        $pmRequest = null; // Supaya form tidak error saat create
        return view('projectmanager.formadd', compact('pmRequest'));
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
        $path = public_path('templates/pm_template.xlsx');
        return response()->download($path, 'Template_Request_Barang.xlsx');
    }

}