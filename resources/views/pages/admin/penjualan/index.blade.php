@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mt-4 mb-2">Export Data Payment</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $title ?? 'Export Payment' }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Export Form -->
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-gradient-primary text-white py-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-25 rounded-circle p-3 me-3">
                                <i class="fas fa-file-excel fa-2x text-white"></i>
                            </div>
                            <div>
                                <h4 class="mb-1">Export Data Payment</h4>
                                <p class="mb-0 opacity-75">Download laporan pembayaran dalam format Excel</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-5">
                        <form action="{{route('admin.export')}}" method="POST" id="exportForm">
                            @csrf
                            <!-- Date Range Selection -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="start_date" class="form-label fw-bold">
                                        <i class="fas fa-calendar-alt me-2 text-primary"></i>Tanggal Mulai
                                    </label>
                                    <input type="date"
                                           class="form-control form-control-lg @error('start_date') is-invalid @enderror"
                                           id="start_date"
                                           name="start_date"
                                           value="{{ old('start_date', date('Y-m-01')) }}"
                                           max="{{ date('Y-m-d') }}"
                                           required>
                                    @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="end_date" class="form-label fw-bold">
                                        <i class="fas fa-calendar-alt me-2 text-primary"></i>Tanggal Akhir
                                    </label>
                                    <input type="date"
                                           class="form-control form-control-lg @error('end_date') is-invalid @enderror"
                                           id="end_date"
                                           name="end_date"
                                           value="{{ old('end_date', date('Y-m-d')) }}"
                                           max="{{ date('Y-m-d') }}"
                                           required>
                                    @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Quick Date Selection -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-clock me-2 text-primary"></i>Pilihan Cepat
                                </label>
                                <div class="btn-group w-100" role="group" aria-label="Quick date selection">
                                    <button type="button" class="btn btn-outline-primary" onclick="setDateRange('today')">
                                        Hari Ini
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" onclick="setDateRange('thisWeek')">
                                        Minggu Ini
                                    </button>
                                    <button type="button" class="btn btn-outline-primary active" onclick="setDateRange('thisMonth')">
                                        Bulan Ini
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" onclick="setDateRange('lastMonth')">
                                        Bulan Lalu
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" onclick="setDateRange('thisYear')">
                                        Tahun Ini
                                    </button>
                                </div>
                            </div>

                            <!-- Filter Options -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="transaction_status" class="form-label fw-bold">
                                        <i class="fas fa-check-circle me-2 text-primary"></i>Status Transaksi
                                    </label>
                                    <select name="transaction_status" id="transaction_status" class="form-select form-select-lg">
                                        <option value="">Semua Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="settlement">Settlement</option>
                                        <option value="capture">Capture</option>
                                        <option value="deny">Deny</option>
                                        <option value="cancel">Cancel</option>
                                        <option value="expire">Expire</option>
                                        <option value="failure">Failure</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="payment_type" class="form-label fw-bold">
                                        <i class="fas fa-credit-card me-2 text-primary"></i>Jenis Pembayaran
                                    </label>
                                    <select name="payment_type" id="payment_type" class="form-select form-select-lg">
                                        <option value="">Semua Jenis</option>
                                        <option value="credit_card">Kartu Kredit</option>
                                        <option value="bank_transfer">Transfer Bank</option>
                                        <option value="echannel">Mandiri Bill</option>
                                        <option value="permata">Permata VA</option>
                                        <option value="bca">BCA VA</option>
                                        <option value="bni">BNI VA</option>
                                        <option value="bri">BRI VA</option>
                                        <option value="gopay">GoPay</option>
                                        <option value="shopeepay">ShopeePay</option>
                                        <option value="qris">QRIS</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Bank Filter -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="bank" class="form-label fw-bold">
                                        <i class="fas fa-university me-2 text-primary"></i>Bank
                                    </label>
                                    <select name="bank" id="bank" class="form-select form-select-lg">
                                        <option value="">Semua Bank</option>
                                        <option value="bca">BCA</option>
                                        <option value="bni">BNI</option>
                                        <option value="bri">BRI</option>
                                        <option value="mandiri">Mandiri</option>
                                        <option value="permata">Permata</option>
                                        <option value="cimb">CIMB Niaga</option>
                                        <option value="danamon">Danamon</option>
                                        <option value="maybank">Maybank</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="min_amount" class="form-label fw-bold">
                                        <i class="fas fa-money-bill me-2 text-primary"></i>Minimal Amount
                                    </label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number"
                                               class="form-control"
                                               id="min_amount"
                                               name="min_amount"
                                               value="{{ old('min_amount') }}"
                                               min="0"
                                               step="1000"
                                               placeholder="0">
                                    </div>
                                </div>
                            </div>

                            <!-- Export Options -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-cog me-2 text-primary"></i>Opsi Export
                                </label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" name="include_ticket_info" id="include_ticket_info" checked>
                                            <label class="form-check-label" for="include_ticket_info">
                                                Sertakan Info Tiket
                                            </label>
                                        </div>
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" name="include_passenger_info" id="include_passenger_info" checked>
                                            <label class="form-check-label" for="include_passenger_info">
                                                Sertakan Info Penumpang
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" name="include_route_info" id="include_route_info" checked>
                                            <label class="form-check-label" for="include_route_info">
                                                Sertakan Info Rute
                                            </label>
                                        </div>
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" name="group_by_date" id="group_by_date">
                                            <label class="form-check-label" for="group_by_date">
                                                Group by Tanggal
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="button" class="btn btn-outline-secondary btn-lg me-md-2" onclick="previewData()">
                                    <i class="fas fa-eye me-2"></i>Preview Data
                                </button>
                                <button type="submit" class="btn btn-success btn-lg" id="exportBtn">
                                    <i class="fas fa-download me-2"></i>Export Excel
                                    <span class="spinner-border spinner-border-sm ms-2 d-none" id="exportSpinner"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mt-5">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4 shadow">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-credit-card fa-2x"></i>
                        </div>
                        <div>
                            <div class="small">Total Payments</div>
                            <div class="fs-4 fw-bold">{{ number_format($statistics['total_payments'] ?? 0) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4 shadow">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                        <div>
                            <div class="small">Successful</div>
                            <div class="fs-4 fw-bold">{{ number_format($statistics['successful_payments'] ?? 0) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4 shadow">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                        <div>
                            <div class="small">Pending</div>
                            <div class="fs-4 fw-bold">{{ number_format($statistics['pending_payments'] ?? 0) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-info text-white mb-4 shadow">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-money-bill-wave fa-2x"></i>
                        </div>
                        <div>
                            <div class="small">Total Revenue</div>
                            <div class="fs-4 fw-bold">Rp {{ number_format($statistics['total_revenue'] ?? 0, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview Modal -->
        <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="previewModalLabel">
                            <i class="fas fa-eye me-2"></i>Preview Data Export
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="previewContent">
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-3">Memuat preview data...</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" onclick="$('#exportForm').submit();">
                            <i class="fas fa-download me-2"></i>Export Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Quick date range selection
        function setDateRange(range) {
            const today = new Date();
            const startDate = document.getElementById('start_date');
            const endDate = document.getElementById('end_date');

            // Remove active class from all buttons
            document.querySelectorAll('.btn-group .btn').forEach(btn => btn.classList.remove('active'));

            let start, end;

            switch(range) {
                case 'today':
                    start = end = today;
                    event.target.classList.add('active');
                    break;
                case 'thisWeek':
                    start = new Date(today.setDate(today.getDate() - today.getDay()));
                    end = new Date();
                    event.target.classList.add('active');
                    break;
                case 'thisMonth':
                    start = new Date(today.getFullYear(), today.getMonth(), 1);
                    end = new Date();
                    event.target.classList.add('active');
                    break;
                case 'lastMonth':
                    start = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                    end = new Date(today.getFullYear(), today.getMonth(), 0);
                    event.target.classList.add('active');
                    break;
                case 'thisYear':
                    start = new Date(today.getFullYear(), 0, 1);
                    end = new Date();
                    event.target.classList.add('active');
                    break;
            }

            startDate.value = start.toISOString().split('T')[0];
            endDate.value = end.toISOString().split('T')[0];
        }

        // Preview data function
        function previewData() {
            const formData = new FormData(document.getElementById('exportForm'));

            fetch('{{route('admin.preview')}}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('previewContent').innerHTML = data.html;
                    new bootstrap.Modal(document.getElementById('previewModal')).show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memuat preview data');
                });
        }

        // Form submission with loading
        document.getElementById('exportForm').addEventListener('submit', function() {
            const btn = document.getElementById('exportBtn');
            const spinner = document.getElementById('exportSpinner');

            btn.disabled = true;
            spinner.classList.remove('d-none');

            setTimeout(() => {
                btn.disabled = false;
                spinner.classList.add('d-none');
            }, 3000);
        });

        // Date validation
        document.getElementById('start_date').addEventListener('change', function() {
            document.getElementById('end_date').min = this.value;
        });

        document.getElementById('end_date').addEventListener('change', function() {
            document.getElementById('start_date').max = this.value;
        });
    </script>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
        }

        .card {
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-group .btn {
            transition: all 0.2s ease-in-out;
        }

        .statistics-card {
            transition: transform 0.2s ease-in-out;
        }

        .statistics-card:hover {
            transform: scale(1.05);
        }
    </style>
@endsection
