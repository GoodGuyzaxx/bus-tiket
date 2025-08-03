<?php

namespace App\Services;

use App\Models\Payment;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PaymentExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle, ShouldAutoSize
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Payment::with(['ticket.passenger', 'ticket.route.bus']);

        // Filter tanggal
        $query->whereBetween('created_at', [
            Carbon::parse($this->filters['start_date'])->startOfDay(),
            Carbon::parse($this->filters['end_date'])->endOfDay()
        ]);

        // Filter status transaksi
        if (!empty($this->filters['transaction_status'])) {
            $query->where('transaction_status', $this->filters['transaction_status']);
        }

        // Filter jenis pembayaran
        if (!empty($this->filters['payment_type'])) {
            $query->where('payment_type', $this->filters['payment_type']);
        }

        // Filter bank
        if (!empty($this->filters['bank'])) {
            $query->where('bank', $this->filters['bank']);
        }

        // Filter minimal amount
        if (!empty($this->filters['min_amount'])) {
            $query->where('amount', '>=', $this->filters['min_amount']);
        }

        return $query->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        $headings = [
            'No',
            'Order ID',
            'Transaction ID',
            'Amount',
            'Payment Type',
            'Bank',
            'VA Number',
            'Transaction Status',
            'Status Message',
            'Transaction Time',
            'Created At',
        ];

        // Tambahkan kolom berdasarkan opsi yang dipilih
        if (!empty($this->filters['include_ticket_info'])) {
            $headings = array_merge($headings, [
                'Ticket ID',
                'Seat Number',
                'Ticket Price',
                'Ticket Status',
            ]);
        }

        if (!empty($this->filters['include_passenger_info'])) {
            $headings = array_merge($headings, [
                'Passenger Name',
                'Passenger Email',
                'Passenger Phone',
            ]);
        }

        if (!empty($this->filters['include_route_info'])) {
            $headings = array_merge($headings, [
                'Bus Name',
                'Route Origin',
                'Route Destination',
                'Departure Time',
                'Arrival Time',
            ]);
        }

        return $headings;
    }

    public function map($payment): array
    {
        $row = [
            '',  // No akan diisi otomatis
            $payment->order_id,
            $payment->transaction_id ?? '-',
            'Rp ' . number_format($payment->amount, 0, ',', '.'),
            $payment->payment_type ?? '-',
            $payment->bank ?? '-',
            $payment->va_number ?? '-',
            $payment->transaction_status,
            $payment->status_message ?? '-',
            $payment->transaction_time ? Carbon::parse($payment->transaction_time)->format('Y-m-d H:i:s') : '-',
            $payment->created_at->format('Y-m-d H:i:s'),
        ];

        // Tambahkan data berdasarkan opsi yang dipilih
        if (!empty($this->filters['include_ticket_info'])) {
            $row = array_merge($row, [
                $payment->ticket_id,
                $payment->ticket->seat_number ?? '-',
                'Rp ' . number_format($payment->ticket->price ?? 0, 0, ',', '.'),
                $payment->ticket->status ?? '-',
            ]);
        }

        if (!empty($this->filters['include_passenger_info'])) {
            $row = array_merge($row, [
                $payment->ticket->passenger->name ?? '-',
                $payment->ticket->passenger->email ?? '-',
                $payment->ticket->passenger->phone ?? '-',
            ]);
        }

        if (!empty($this->filters['include_route_info'])) {
            $row = array_merge($row, [
                $payment->ticket->route->bus->name ?? '-',
                $payment->ticket->route->origin ?? '-',
                $payment->ticket->route->destination ?? '-',
                $payment->ticket->route->departure_time ? $payment->ticket->route->departure_time->format('H:i') : '-',
                $payment->ticket->route->arrival_time ? $payment->ticket->route->arrival_time->format('H:i') : '-',
            ]);
        }

        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        // Style untuk header
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Style untuk data
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        $sheet->getStyle('A2:' . $highestColumn . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
        ]);

        // Zebra striping untuk baris
        for ($row = 2; $row <= $highestRow; $row++) {
            if ($row % 2 == 0) {
                $sheet->getStyle('A' . $row . ':' . $highestColumn . $row)->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F8F9FA'],
                    ],
                ]);
            }
        }

        // Auto-numbering untuk kolom No
        for ($row = 2; $row <= $highestRow; $row++) {
            $sheet->setCellValue('A' . $row, $row - 1);
        }

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 20,  // Order ID
            'C' => 20,  // Transaction ID
            'D' => 15,  // Amount
            'E' => 15,  // Payment Type
            'F' => 10,  // Bank
            'G' => 15,  // VA Number
            'H' => 15,  // Transaction Status
            'I' => 25,  // Status Message
            'J' => 20,  // Transaction Time
            'K' => 20,  // Created At
        ];
    }

    public function title(): string
    {
        $startDate = Carbon::parse($this->filters['start_date'])->format('d M Y');
        $endDate = Carbon::parse($this->filters['end_date'])->format('d M Y');

        return 'Payment Report ' . $startDate . ' - ' . $endDate;
    }
}
