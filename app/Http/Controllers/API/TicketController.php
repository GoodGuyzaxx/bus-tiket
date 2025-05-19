<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Route;
use Illuminate\Http\Request;

class TicketController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth:api');
//        $this->middleware('role:admin,manager')->only(['index', 'update', 'destroy']);
//    }

    public function index()
    {
        $tickets = Ticket::with(['passenger', 'route.bus'])->get();
        return response()->json($tickets);
    }

    public function store(Request $request)
    {
        $request->validate([
            'route_id' => 'required|exists:routes,id',
            'seat_number' => 'required|integer|min:1',
        ]);

        $route = Route::findOrFail($request->route_id);

        // Check if seat is available
        $existingTicket = Ticket::where('route_id', $request->route_id)
            ->where('seat_number', $request->seat_number)
            ->where('status', '!=', 'cancelled')
            ->first();

        if ($existingTicket) {
            return response()->json([
                'message' => 'Seat is already taken',
            ], 422);
        }

        // Check if seat number is valid
        if ($request->seat_number > $route->bus->total_seats) {
            return response()->json([
                'message' => 'Invalid seat number',
            ], 422);
        }

        $ticket = Ticket::create([
            'passenger_id' => auth()->guard('passenger')->id(),
            'route_id' => $request->route_id,
            'seat_number' => $request->seat_number,
            'price' => $route->price,
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        return response()->json([
            'message' => 'Ticket booked successfully',
            'ticket' => $ticket->load(['route.bus']),
        ], 201);
    }

    public function show(Ticket $ticket)
    {
        // Check if user is authorized to view the ticket
        if (!$ticket->passenger_id === auth()->guard('passenger')->id() && !auth()->user()->isAdmin() && !auth()->user()->isManager()) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        return response()->json($ticket->load(['passenger', 'route.bus']));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
            'payment_status' => 'required|in:unpaid,paid',
        ]);

        $ticket->update($request->all());

        return response()->json([
            'message' => 'Ticket updated successfully',
            'ticket' => $ticket->load(['passenger', 'route.bus']),
        ]);
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return response()->json([
            'message' => 'Ticket deleted successfully',
        ]);
    }

    public function userTickets(Request $request)
    {
        $tickets = auth()->guard('passenger')->user()->tickets()->with(['route.bus'])->get();
        return response()->json($tickets);
    }
}
