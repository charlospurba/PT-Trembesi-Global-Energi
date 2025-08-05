<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\PurchaseRequest;
use App\Http\Controllers\OrderController; // Import OrderController
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardPMController extends Controller
{
  /**
   * Display the Project Manager dashboard.
   *
   * @return \Illuminate\View\View
   */
  public function index()
  {
    $user = Auth::user();

    // 1. Fetch data for the summary cards
    $requests = PurchaseRequest::where('project_manager_id', $user->id)->get();
    $summary = [
      'pending' => $requests->where('status', 'Pending')->count(),
      'approved' => $requests->where('status', 'Approved')->count(),
      'rejected' => $requests->where('status', 'Rejected')->count(),
    ];

    // 2. Fetch data for Material Status
    // Asumsi: Ada relasi atau kolom di tabel users yang menunjukkan ID pengguna procurement
    // yang bekerja untuk PM ini. Jika tidak ada, Anda perlu menyesuaikan logika ini.
    $procurementUser = \App\Models\User::where('role', 'procurement')
      ->where('project_name', $user->project_name)
      ->first();

    $materialStatus = [
      'awaiting_shipment' => 0,
      'shipped' => 0,
      'completed' => 0,
      'cancelled' => 0
    ];

    if ($procurementUser) {
      $orderController = new OrderController();
      $materialStatus = $orderController->getProcurementOrderCounts($procurementUser->id);
    }

    // 3. Fetch data for recent requests
    $recentRequests = PurchaseRequest::with(['product', 'user'])
      ->where('project_manager_id', $user->id)
      ->latest()
      ->take(5)
      ->get();

    // 4. Fetch data for monthly chart
    $monthlyData = PurchaseRequest::select(
      DB::raw('EXTRACT(MONTH FROM created_at) as month'),
      DB::raw('EXTRACT(YEAR FROM created_at) as year'),
      DB::raw('status'),
      DB::raw('COUNT(*) as count')
    )
      ->where('project_manager_id', $user->id)
      ->where('created_at', '>=', Carbon::now()->subMonths(6))
      ->groupBy(DB::raw('EXTRACT(YEAR FROM created_at)'), DB::raw('EXTRACT(MONTH FROM created_at)'), 'status')
      ->orderBy(DB::raw('EXTRACT(YEAR FROM created_at)'), 'asc')
      ->orderBy(DB::raw('EXTRACT(MONTH FROM created_at)'), 'asc')
      ->get();

    $chartLabels = [];
    $approvedData = [];
    $pendingData = [];
    $rejectedData = [];

    for ($i = 5; $i >= 0; $i--) {
      $date = Carbon::now()->subMonths($i);
      $monthYear = $date->format('M Y');
      $chartLabels[] = $monthYear;
      $approvedData[] = 0;
      $pendingData[] = 0;
      $rejectedData[] = 0;
    }

    foreach ($monthlyData as $data) {
      $date = Carbon::createFromDate($data->year, $data->month, 1);
      $monthYear = $date->format('M Y');
      $index = array_search($monthYear, $chartLabels);

      if ($index !== false) {
        if ($data->status === 'Approved') {
          $approvedData[$index] = $data->count;
        } elseif ($data->status === 'Pending') {
          $pendingData[$index] = $data->count;
        } elseif ($data->status === 'Rejected') {
          $rejectedData[$index] = $data->count;
        }
      }
    }

    $chartData = [
      'labels' => $chartLabels,
      'approved' => $approvedData,
      'pending' => $pendingData,
      'rejected' => $rejectedData,
    ];

    return view('projectmanager.dashboardpm', compact('summary', 'recentRequests', 'chartData', 'materialStatus'));
  }
}