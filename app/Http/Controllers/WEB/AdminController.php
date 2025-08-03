<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Passenger;
use App\Models\Payment;
use App\Models\Route;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $data = [
            'total_bus' => Bus::count(),
            'total_rute' => Route::count(),
            'total_user' => Passenger::count(),
            'total_revenue' => Payment::whereIn('transaction_status', ['settlement', 'capture'])->sum('amount')
        ];
        return view('pages.admin.index', compact('data'));
    }
}
