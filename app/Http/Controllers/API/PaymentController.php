<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Payment;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function createPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|exists:tickets,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $ticket = Ticket::findOrFail($request->ticket_id);

        // Check if ticket belongs to the authenticated passenger
        if ($ticket->passenger_id !== auth()->id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access to this ticket'
            ], 403);
        }

        // Check if payment already exists
        if ($ticket->payment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment already exists for this ticket'
            ], 400);
        }

        try {
            $payment = $this->midtransService->createTransaction($ticket);

            return response()->json([
                'status' => 'success',
                'message' => 'Payment created successfully',
                'data' => [
                    'payment_url' => $payment->payment_url,
                    'order_id' => $payment->order_id,
                    'amount' => $payment->amount,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function handleCallback(Request $request)
    {
        try {
            $payment = $this->midtransService->handleCallback($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Payment status updated successfully',
                'data' => $payment
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getPaymentStatus($orderId)
    {
        $payment = Payment::where('order_id', $orderId)->first();

        if (!$payment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment not found'
            ], 404);
        }

        // Check if payment belongs to the authenticated passenger
        if ($payment->ticket->passenger_id !== auth()->id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access to this payment'
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'data' => $payment
        ]);
    }

    public function getPaymentStatusByUser($ticketId){
        $payment = Payment::with(['ticket.passenger'])->where('ticket_id', $ticketId)->get();
        if ($payment->isEmpty()){
            return response()->json([
                'message' => "Data Tidak Ditemukan"
            ],404);
        }

        return  response()->json(
           $payment->load('ticket.route.bus')
        );
    }
}
