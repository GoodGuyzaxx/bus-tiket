<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Ticket::with(['passenger', 'route.bus'])->get();
        $statistics = [
            'total' => Ticket::count(),
            'confirmed' => Ticket::where('payment_status', 'paid')->count(),
            'pending' => Ticket::where('status', 'pending')->count(),
            'cancelled' => Ticket::where('status', 'cancelled')->count(),
            'total_revenue' => Ticket::where('payment_status', 'paid')->sum('price')
        ];
        return view('pages.admin.tiket.index', compact('data','statistics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function indexManager()
    {
        $data = Ticket::with(['passenger', 'route.bus'])->get();
        $statistics = [
            'total' => Ticket::count(),
            'confirmed' => Ticket::where('payment_status', 'paid')->count(),
            'pending' => Ticket::where('status', 'pending')->count(),
            'cancelled' => Ticket::where('status', 'cancelled')->count(),
            'total_revenue' => Ticket::where('payment_status', 'paid')->sum('price')
        ];
        return view('pages.manager.tiket.index', compact('data','statistics'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
