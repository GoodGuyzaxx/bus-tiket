 <div class="alert alert-info mb-3">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Preview Data Export</strong> - Menampilkan 10 data pertama dari total <strong>{{ number_format($totalCount) }}</strong> data yang akan di-export.
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Order ID</th>
                <th>Amount</th>
                <th>Payment Type</th>
                <th>Bank</th>
                <th>Status</th>
                <th>Transaction Time</th>
                @if($request->has('include_ticket_info'))
                    <th>Seat</th>
                    <th>Ticket Status</th>
                @endif
                @if($request->has('include_passenger_info'))
                    <th>Passenger</th>
                @endif
                @if($request->has('include_route_info'))
                    <th>Route</th>
                    <th>Bus</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @forelse($payments as $index => $payment)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <small class="font-monospace">{{ $payment->order_id }}</small>
                    </td>
                    <td>
                        <strong>Rp {{ number_format($payment->amount, 0, ',', '.') }}</strong>
                    </td>
                    <td>
                        <span class="badge bg-secondary">{{ $payment->payment_type ?? '-' }}</span>
                    </td>
                    <td>
                        {{ strtoupper($payment->bank ?? '-') }}
                    </td>
                    <td>
                        @if($payment->transaction_status == 'settlement' || $payment->transaction_status == 'capture')
                            <span class="badge bg-success">{{ $payment->transaction_status }}</span>
                        @elseif($payment->transaction_status == 'pending')
                            <span class="badge bg-warning">{{ $payment->transaction_status }}</span>
                        @else
                            <span class="badge bg-danger">{{ $payment->transaction_status }}</span>
                        @endif
                    </td>
                    <td>
                        <small>
                            @if($payment->transaction_time)
                                {{ \Carbon\Carbon::parse($payment->transaction_time)->format('d/m/Y H:i') }}
                            @else
                                -
                            @endif
                        </small>
                    </td>
                    @if($request->has('include_ticket_info'))
                        <td>
                            <span class="badge bg-info">{{ $payment->ticket->seat_number ?? '-' }}</span>
                        </td>
                        <td>
                            @if($payment->ticket)
                                @if($payment->ticket->status == 'confirmed')
                                    <span class="badge bg-success">{{ $payment->ticket->status }}</span>
                                @elseif($payment->ticket->status == 'pending')
                                    <span class="badge bg-warning">{{ $payment->ticket->status }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $payment->ticket->status }}</span>
                                @endif
                            @else
                                -
                            @endif
                        </td>
                    @endif
                    @if($request->has('include_passenger_info'))
                        <td>
                            @if($payment->ticket && $payment->ticket->passenger)
                                <div>
                                    <strong>{{ $payment->ticket->passenger->name }}</strong><br>
                                    <small class="text-muted">{{ $payment->ticket->passenger->email }}</small>
                                </div>
                            @else
                                -
                            @endif
                        </td>
                    @endif
                    @if($request->has('include_route_info'))
                        <td>
                            @if($payment->ticket && $payment->ticket->route)
                                <small>
                                    {{ $payment->ticket->route->origin }} → {{ $payment->ticket->route->destination }}
                                </small>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($payment->ticket && $payment->ticket->route && $payment->ticket->route->bus)
                                {{ $payment->ticket->route->bus->name }}
                            @else
                                -
                            @endif
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="20" class="text-center py-4">
                        <i class="fas fa-inbox fa-2x text-muted mb-2"></i><br>
                        <span class="text-muted">Tidak ada data payment untuk periode yang dipilih</span>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if($totalCount > 10)
        <div class="alert alert-warning mt-3">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Perhatian:</strong> Preview hanya menampilkan 10 data pertama.
            Total <strong>{{ number_format($totalCount - 10) }}</strong> data lainnya akan disertakan dalam file Excel.
        </div>
    @endif

    <div class="mt-3">
        <h6>Ringkasan Export:</h6>
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between">
                <span>Periode:</span>
                <strong>{{ \Carbon\Carbon::parse($request->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($request->end_date)->format('d M Y') }}</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Total Data:</span>
                <strong>{{ number_format($totalCount) }} payments</strong>
            </li>
            @if($request->transaction_status)
                <li class="list-group-item d-flex justify-content-between">
                    <span>Filter Status:</span>
                    <strong>{{ ucfirst($request->transaction_status) }}</strong>
                </li>
            @endif
            @if($request->payment_type)
                <li class="list-group-item d-flex justify-content-between">
                    <span>Filter Payment Type:</span>
                    <strong>{{ ucfirst(str_replace('_', ' ', $request->payment_type)) }}</strong>
                </li>
            @endif
            @if($request->bank)
                <li class="list-group-item d-flex justify-content-between">
                    <span>Filter Bank:</span>
                    <strong>{{ strtoupper($request->bank) }}</strong>
                </li>
            @endif
            @if($request->min_amount)
                <li class="list-group-item d-flex justify-content-between">
                    <span>Minimal Amount:</span>
                    <strong>Rp {{ number_format($request->min_amount, 0, ',', '.') }}</strong>
                </li>
            @endif
        </ul>
    </div>
