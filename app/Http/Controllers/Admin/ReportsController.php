<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ReportsExport;
use App\Http\Controllers\Controller;
use App\Models\ItemCheck;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{
    public function showItemChecks(Request $request)
    {
        // Store filters in session
        if ($request->has('status') || $request->has('start_date') || $request->has('end_date')) {
            session([
                'filter_status' => $request->status,
                'filter_start_date' => $request->start_date,
                'filter_end_date' => $request->end_date,
            ]);
        }
    
        $query = ItemCheck::with(['user', 'inventory', 'location']);
    
        // Apply status filter if set
        if (session('filter_status') && session('filter_status') !== 'all') {
            $query->where('status', session('filter_status'));
        }
    
        // Apply date range filter if set
        if (session('filter_start_date') && session('filter_end_date')) {
            $query->whereBetween('created_at', [
                session('filter_start_date') . ' 00:00:00',
                session('filter_end_date') . ' 23:59:59'
            ]);
        }
    
        // Fetch the filtered data
        $itemChecks = $query->orderBy('created_at', 'asc')->get();
    
        return view('admin.reports.item_checks', compact('itemChecks'));
    }
    
    public function exportPdf(Request $request)
    {
        // Fetch the filtered data from session
        $query = ItemCheck::with(['user', 'inventory', 'location']);
    
        // Apply status filter if set
        if (session('filter_status') && session('filter_status') !== 'all') {
            $query->where('status', session('filter_status'));
        }
    
        // Apply date range filter if set
        if (session('filter_start_date') && session('filter_end_date')) {
            $query->whereBetween('created_at', [
                session('filter_start_date') . ' 00:00:00',
                session('filter_end_date') . ' 23:59:59'
            ]);
        }
    
        // Fetch the filtered data for PDF
        $itemChecks = $query->orderBy('created_at', 'asc')->get();
    
        // Generate PDF
        $pdf = PDF::loadView('admin.reports.item_checks_pdf', compact('itemChecks'));
    
        session()->forget(['filter_status', 'filter_start_date', 'filter_end_date']);

        // Return the PDF download


        return $pdf->download('Laporan Pengecekan Inventaris.pdf');
    }

    public function exportExcel(Request $request)
{
    // Apply the filters and fetch the filtered data
    $query = ItemCheck::with(['user', 'inventory', 'location']);

    // Apply status filter if set
    if (session('filter_status') && session('filter_status') !== 'all') {
        $query->where('status', session('filter_status'));
    }

    // Apply date range filter if set
    if (session('filter_start_date') && session('filter_end_date')) {
        $query->whereBetween('created_at', [
            session('filter_start_date') . ' 00:00:00',
            session('filter_end_date') . ' 23:59:59'
        ]);
    }

    // Fetch the filtered data for the export
    $itemChecks = $query->orderBy('created_at', 'asc')->get();

    // Clear the session data for filters
    session()->forget(['filter_status', 'filter_start_date', 'filter_end_date']);

    // Export the data to Excel
    return Excel::download(new ReportsExport($itemChecks), 'Laporan Pengecekan Inventaris.xlsx');
}
}
