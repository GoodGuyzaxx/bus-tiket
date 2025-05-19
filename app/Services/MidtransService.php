namespace App\Services;

use App\Models\Ticket;
use App\Models\Payment;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createTransaction(Ticket $ticket)
    {
        $orderId = 'TICKET-' . time() . '-' . $ticket->id;
        
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $ticket->price,
            ],
            'customer_details' => [
                'first_name' => $ticket->passenger->name,
                'email' => $ticket->passenger->email,
                'phone' => $ticket->passenger->phone,
            ],
            'item_details' => [
                [
                    'id' => $ticket->id,
                    'price' => (int) $ticket->price,
                    'quantity' => 1,
                    'name' => "Ticket from {$ticket->route->origin} to {$ticket->route->destination}",
                ],
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            
            $payment = Payment::create([
                'ticket_id' => $ticket->id,
                'order_id' => $orderId,
                'amount' => $ticket->price,
                'transaction_status' => 'pending',
                'payment_url' => $snapToken,
            ]);

            return $payment;
        } catch (\Exception $e) {
            throw new \Exception('Payment gateway error: ' . $e->getMessage());
        }
    }

    public function handleCallback($payload)
    {
        $orderId = $payload['order_id'];
        $transactionStatus = $payload['transaction_status'];
        $paymentType = $payload['payment_type'];
        $fraudStatus = $payload['fraud_status'] ?? null;

        $payment = Payment::where('order_id', $orderId)->first();
        
        if (!$payment) {
            throw new \Exception('Payment not found');
        }

        $payment->update([
            'transaction_status' => $transactionStatus,
            'payment_type' => $paymentType,
            'transaction_id' => $payload['transaction_id'],
            'transaction_time' => $payload['transaction_time'],
            'status_message' => $payload['status_message'],
            'va_number' => $payload['va_numbers'][0]['va_number'] ?? null,
            'bank' => $payload['va_numbers'][0]['bank'] ?? null,
        ]);

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $payment->ticket->update(['payment_status' => 'pending']);
            } else if ($fraudStatus == 'accept') {
                $payment->ticket->update(['payment_status' => 'paid']);
            }
        } else if ($transactionStatus == 'settlement') {
            $payment->ticket->update(['payment_status' => 'paid']);
        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $payment->ticket->update(['payment_status' => 'failed']);
        } else if ($transactionStatus == 'pending') {
            $payment->ticket->update(['payment_status' => 'pending']);
        }

        return $payment;
    }
}
