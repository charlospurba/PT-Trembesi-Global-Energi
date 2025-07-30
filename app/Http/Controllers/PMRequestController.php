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
        $requests = PMRequest::where('user_id', Auth::id())->get();
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
            'item' => 'required|string',
            'specification' => 'required|string',
            'unit' => 'required|string',
            'qty' => 'required|integer',
            'eta' => 'required|date',
            'remark' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);

        $validated['project_name'] = Auth::user()->project_name;
        $validated['user_id'] = Auth::id(); // ⬅️ ini bagian pentingnya

        PMRequest::create($validated);

        return redirect()->route('projectmanager.addrequest')->with('success', 'Request berhasil ditambahkan.');
    }

    public function showAll()
    {
        $requests = PMRequest::where('user_id', Auth::id())->get();
        return view('projectmanager.addrequest', compact('requests'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        // Ambil nama proyek dari user login, bisa disesuaikan dengan relasi user-project
        $projectName = Auth::user()->project_name ?? 'Unknown Project';

        Excel::import(new PMRequestImport($projectName, Auth::id()), $request->file('file'));

        return redirect()->route('projectmanager.addrequest')->with('success', 'Data berhasil diimport dari Excel.');
    }

    public function downloadTemplate()
    {
        $path = public_path('templates/template-pm-request.xlsx');
        return response()->download($path, 'Template_Request_Barang.xlsx');
    }

}