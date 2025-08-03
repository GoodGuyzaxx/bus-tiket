@extends('layouts.manager')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mt-4 mb-2">Daftar Tiket</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $title ?? 'Tiket' }}</li>
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

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Filter Section -->
{{--        <div class="card mb-4 shadow-sm border-0">--}}
{{--            <div class="card-body">--}}
{{--                <form method="GET" action="{{ route('tiket.index') }}">--}}
{{--                    <div class="row g-3">--}}
{{--                        <div class="col-md-3">--}}
{{--                            <label for="status" class="form-label">Status Tiket</label>--}}
{{--                            <select name="status" id="status" class="form-select">--}}
{{--                                <option value="">Semua Status</option>--}}
{{--                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>--}}
{{--                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>--}}
{{--                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-3">--}}
{{--                            <label for="payment_status" class="form-label">Status Pembayaran</label>--}}
{{--                            <select name="payment_status" id="payment_status" class="form-select">--}}
{{--                                <option value="">Semua Status</option>--}}
{{--                                <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Belum Bayar</option>--}}
{{--                                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Sudah Bayar</option>--}}
{{--                                <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refund</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-3">--}}
{{--                            <label for="passenger" class="form-label">Nama Penumpang</label>--}}
{{--                            <input type="text" name="passenger" id="passenger" class="form-control"--}}
{{--                                   value="{{ request('passenger') }}" placeholder="Cari nama penumpang...">--}}
{{--                        </div>--}}
{{--                        <div class="col-md-3">--}}
{{--                            <label class="form-label">&nbsp;</label>--}}
{{--                            <div class="d-flex gap-2">--}}
{{--                                <button type="submit" class="btn btn-primary">--}}
{{--                                    <i class="fas fa-search me-1"></i> Filter--}}
{{--                                </button>--}}
{{--                                <a href="{{ route('tiket.index') }}" class="btn btn-outline-secondary">--}}
{{--                                    <i class="fas fa-times me-1"></i> Reset--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-dark">Data Tiket</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="datatablesSimple" class="table table-hover border mb-0" style="width:100%">
                        <thead class="bg-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Penumpang</th>
                            <th>Rute</th>
                            <th>Bus</th>
                            <th>No. Kursi</th>
                            <th>Harga</th>
                            <th>Status Pembayaran</th>
                            <th>Tanggal Booking</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if ($data->count())
                            @foreach ($data as $tiket)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $tiket->passenger->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $tiket->passenger->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $tiket->route->origin }} → {{ $tiket->route->destination }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                {{ $tiket->route->departure_time->format('H:i') }} -
                                                {{ $tiket->route->arrival_time->format('H:i') }}
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ $tiket->route->bus->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $tiket->route->bus->plate_number ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info text-dark">Kursi {{ $tiket->seat_number }}</span>
                                    </td>
                                    <td>
                                        <strong>Rp {{ number_format($tiket->price, 0, ',', '.') }}</strong>
                                    </td>

                                    <td>
                                        @if($tiket->payment_status == 'unpaid')
                                            <span class="badge bg-warning">
                                                Belum Bayar
                                            </span>
                                        @elseif($tiket->payment_status == 'paid')
                                            <span class="badge bg-success">
                                                Sudah Bayar
                                            </span>
                                        @elseif($tiket->payment_status == 'pending')
                                            <span class="badge bg-warning">
                                                Menunggu
                                            </span>
                                        @elseif($tiket->payment_status == "failed")
                                            <span class="badge bg-danger">
                                                Gagal
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            {{ $tiket->created_at->format('d/m/Y') }}
                                            <br>
                                            <small class="text-muted">{{ $tiket->created_at->format('H:i') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-cog"></i>
                                            </button>
                                            <ul class="dropdown-menu">
{{--                                                <li>--}}
{{--                                                    <a class="dropdown-item" href="{{ route('tiket.show', $tiket->id) }}">--}}
{{--                                                        <i class="fas fa-eye me-2"></i> Detail--}}
{{--                                                    </a>--}}
{{--                                                </li>--}}
{{--                                                <li>--}}
{{--                                                    <a class="dropdown-item" href="{{ route('tiket.edit', $tiket->id) }}">--}}
{{--                                                        <i class="fas fa-pencil-alt me-2"></i> Edit--}}
{{--                                                    </a>--}}
{{--                                                </li>--}}
{{--                                                @if($tiket->status == 'pending')--}}
{{--                                                    <li><hr class="dropdown-divider"></li>--}}
{{--                                                    <li>--}}
{{--                                                        <form action="" method="POST" class="d-inline">--}}
{{--                                                            @csrf--}}
{{--                                                            @method('PATCH')--}}
{{--                                                            <button type="submit" class="dropdown-item text-success">--}}
{{--                                                                <i class="fas fa-check me-2"></i> Konfirmasi--}}
{{--                                                            </button>--}}
{{--                                                        </form>--}}
{{--                                                    </li>--}}
{{--                                                    <li>--}}
{{--                                                        <form action="" method="POST" class="d-inline">--}}
{{--                                                            @csrf--}}
{{--                                                            @method('PATCH')--}}
{{--                                                            <button type="submit" class="dropdown-item text-warning"--}}
{{--                                                                    onclick="return confirm('Yakin ingin membatalkan tiket ini?')">--}}
{{--                                                                <i class="fas fa-ban me-2"></i> Batalkan--}}
{{--                                                            </button>--}}
{{--                                                        </form>--}}
{{--                                                    </li>--}}
{{--                                                @endif--}}
{{--                                                @if($tiket->payment_status == 'unpaid' && $tiket->status != 'cancelled')--}}
{{--                                                    <li><hr class="dropdown-divider"></li>--}}
{{--                                                    <li>--}}
{{--                                                        <form action="" method="POST" class="d-inline">--}}
{{--                                                            @csrf--}}
{{--                                                            @method('PATCH')--}}
{{--                                                            <button type="submit" class="dropdown-item text-info">--}}
{{--                                                                <i class="fas fa-money-bill me-2"></i> Tandai Lunas--}}
{{--                                                            </button>--}}
{{--                                                        </form>--}}
{{--                                                    </li>--}}
{{--                                                @endif--}}
{{--                                                <li><hr class="dropdown-divider"></li>--}}
{{--                                                <li>--}}
{{--                                                    <a class="dropdown-item" href="" target="_blank">--}}
{{--                                                        <i class="fas fa-print me-2"></i> Print Tiket--}}
{{--                                                    </a>--}}
{{--                                                </li>--}}
                                                <li>
                                                    <form action="{{ route('tiket.destroy', $tiket->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method("DELETE")
                                                        <button type="submit" class="dropdown-item text-danger"
                                                                onclick="return confirm('Yakin ingin menghapus tiket ini?')">
                                                            <i class="fas fa-trash me-2"></i> Hapus
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-ticket-alt fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">Belum ada data Tiket</h5>
                                        <p class="text-muted">Tiket yang dibuat akan tampil di sini</p>
{{--                                        <a href="{{ route('tiket.create') }}" class="btn btn-primary">--}}
{{--                                            <i class="fas fa-plus me-2"></i> Tambah Tiket Pertama--}}
{{--                                        </a>--}}
                                    </div>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

{{--                @if($data->count() > 0)--}}
{{--                    <div class="card-footer bg-white border-top-0 py-3">--}}
{{--                        <div class="d-flex justify-content-between align-items-center">--}}
{{--                            <div class="text-muted">--}}
{{--                                Menampilkan {{ $data->firstItem() }} - {{ $data->lastItem() }} dari {{ $data->total() }} tiket--}}
{{--                            </div>--}}
{{--                            {{ $data->appends(request()->query())->links() }}--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endif--}}
            </div>
        </div>

        <!-- Statistics Cards -->
{{--        <div class="row">--}}
{{--            <div class="col-xl-3 col-md-6">--}}
{{--                <div class="card bg-primary text-white mb-4">--}}
{{--                    <div class="card-body d-flex align-items-center">--}}
{{--                        <div class="me-3">--}}
{{--                            <i class="fas fa-ticket-alt fa-2x"></i>--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <div class="small">Total Tiket</div>--}}
{{--                            <div class="fs-4 fw-bold">{{ $statistics['total'] ?? 0 }}</div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-xl-3 col-md-6">--}}
{{--                <div class="card bg-success text-white mb-4">--}}
{{--                    <div class="card-body d-flex align-items-center">--}}
{{--                        <div class="me-3">--}}
{{--                            <i class="fas fa-check-circle fa-2x"></i>--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <div class="small">Tiket Confirmed</div>--}}
{{--                            <div class="fs-4 fw-bold">{{ $statistics['confirmed'] ?? 0 }}</div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-xl-3 col-md-6">--}}
{{--                <div class="card bg-info text-white mb-4">--}}
{{--                    <div class="card-body d-flex align-items-center">--}}
{{--                        <div class="me-3">--}}
{{--                            <i class="fas fa-money-bill-wave fa-2x"></i>--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <div class="small">Total Pendapatan</div>--}}
{{--                            <div class="fs-4 fw-bold">Rp {{ number_format($statistics['total_revenue'] ?? 0, 0, ',', '.') }}</div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>

    <script>
        function printTable() {
            window.print();
        }
    </script>
@endsection
