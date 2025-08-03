<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\PaymentExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Statistik untuk dashboard cards
        $statistics = [
            'total_payments' => Payment::count(),
            'successful_payments' => Payment::whereIn('transaction_status', ['settlement', 'capture'])->count(),
            'pending_payments' => Payment::where('transaction_status', 'pending')->count(),
            'total_revenue' => Payment::whereIn('transaction_status', ['settlement', 'capture'])->sum('amount')
        ];

        return view('pages.admin.penjualan.index', compact('statistics'));
    }

    public function indexManager()
    {
        // Statistik untuk dashboard cards
        $statistics = [
            'total_payments' => Payment::count(),
            'successful_payments' => Payment::whereIn('transaction_status', ['settlement', 'capture'])->count(),
            'pending_payments' => Payment::where('transaction_status', 'pending')->count(),
            'total_revenue' => Payment::whereIn('transaction_status', ['settlement', 'capture'])->sum('amount')
        ];

        return view('pages.manager.penjualan.index', compact('statistics'));
    }

    public function export(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'transaction_status' => 'nullable|string',
            'payment_type' => 'nullable|string',
            'bank' => 'nullable|string',
            'min_amount' => 'nullable|numeric|min:0',
        ]);

        $fileName = 'payment_report_' . $request->start_date . '_to_' . $request->end_date . '.xlsx';

        return Excel::download(new PaymentExport($request->all()), $fileName);
    }

    public function preview(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $query = $this->buildQuery($request);

        // Ambil 10 data pertama untuk preview
        $payments = $query->take(10)->get();
        $totalCount = $this->buildQuery($request)->count();

        $html = view('pages.admin.penjualan.preview', compact('payments', 'totalCount', 'request'))->render();

        return response()->json(['html' => $html]);
    }

    public function previewManager(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $query = $this->buildQuery($request);

        // Ambil 10 data pertama untuk preview
        $payments = $query->take(10)->get();
        $totalCount = $this->buildQuery($request)->count();

        $html = view('pages.admin.penjualan.preview', compact('payments', 'totalCount', 'request'))->render();

        return response()->json(['html' => $html]);
    }

    private function buildQuery(Request $request)
    {
        $query = Payment::with(['ticket.passenger', 'ticket.route.bus']);
        // Filter tanggal
        $query->whereBetween('created_at', [
            Carbon::parse($request->start_date)->startOfDay(),
            Carbon::parse($request->end_date)->endOfDay()
        ]);
        // Filter status transaksi
        if ($request->filled('transaction_status')) {
            $query->where('transaction_status', $request->transaction_status);
        }
        // Filter jenis pembayaran
        if ($request->filled('payment_type')) {
            $query->where('payment_type', $request->payment_type);
        }
        // Filter bank
        if ($request->filled('bank')) {
            $query->where('bank', $request->bank);
        }
        // Filter minimal amount
        if ($request->filled('min_amount')) {
            $query->where('amount', '>=', $request->min_amount);
        }
        return $query->orderBy('created_at', 'desc');
    }

}
