@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mt-4 mb-2">Tambah Bus Baru</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('bus.index') }}">Daftar Bus</a></li>
                        <li class="breadcrumb-item active">Tambah Bus</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('bus.index') }}" class="btn btn-secondary d-flex align-items-center">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-bus me-2"></i>
                            <h5 class="mb-0">Form Tambah Bus</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('bus.store') }}" method="POST" id="busForm">
                            @csrf

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="name" class="form-label fw-bold">
                                        <i class="fas fa-bus me-1 text-primary"></i>
                                        Nama Bus <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name') }}"
                                           placeholder="Masukkan nama bus (contoh: Bus Pariwisata Jaya)"
                                           required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="plate_number" class="form-label fw-bold">
                                        <i class="fas fa-id-card me-1 text-primary"></i>
                                        Plat Nomor <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('plate_number') is-invalid @enderror"
                                           id="plate_number"
                                           name="plate_number"
                                           value="{{ old('plate_number') }}"
                                           placeholder="B 1234 XYZ"
                                           style="text-transform: uppercase;"
                                           required>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Format: [Kode Wilayah] [Nomor] [Huruf] (contoh: B 1234 XYZ)
                                    </div>
                                    @error('plate_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="total_seats" class="form-label fw-bold">
                                        <i class="fas fa-chair me-1 text-primary"></i>
                                        Total Kursi <span class="text-danger">*</span>
                                    </label>
                                    <input type="number"
                                           class="form-control @error('total_seats') is-invalid @enderror"
                                           id="total_seats"
                                           name="total_seats"
                                           value="{{ old('total_seats') }}"
                                           placeholder="Jumlah kursi"
                                           min="1"
                                           max="100"
                                           required>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Masukkan jumlah kursi penumpang (1-100)
                                    </div>
                                    @error('total_seats')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="status" class="form-label fw-bold">
                                        <i class="fas fa-toggle-on me-1 text-primary"></i>
                                        Status Bus <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('status') is-invalid @enderror"
                                            id="status"
                                            name="status"
                                            required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                                            <i class="fas fa-check-circle"></i> Aktif
                                        </option>
                                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>
                                            <i class="fas fa-wrench"></i> Perawatan
                                        </option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                            <i class="fas fa-times-circle"></i> Tidak Aktif
                                        </option>
                                    </select>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Pilih status operasional bus
                                    </div>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="mb-4">

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted small">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Field bertanda <span class="text-danger">*</span> wajib diisi
                                </div>
                                <div>
                                    <button type="button" class="btn btn-outline-secondary me-2" onclick="resetForm()">
                                        <i class="fas fa-undo me-1"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Simpan Bus
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Auto uppercase plate number input
            const plateNumberInput = document.getElementById('plate_number');
            plateNumberInput.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });

            // Form validation
            const form = document.getElementById('busForm');
            form.addEventListener('submit', function(e) {
                const plateNumber = document.getElementById('plate_number').value;
                const totalSeats = document.getElementById('total_seats').value;

                // Validate plate number format (basic validation)
                const plateRegex = /^[A-Z]{1,2}\s*\d{1,4}\s*[A-Z]{1,3}$/;
                if (!plateRegex.test(plateNumber)) {
                    e.preventDefault();
                    alert('Format plat nomor tidak valid. Gunakan format seperti: B 1234 XYZ');
                    return false;
                }

                // Validate total seats
                if (totalSeats < 1 || totalSeats > 100) {
                    e.preventDefault();
                    alert('Jumlah kursi harus antara 1-100');
                    return false;
                }
            });

            // Add loading state to submit button
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
                submitBtn.disabled = true;
            });
        });

        function resetForm() {
            if (confirm('Apakah Anda yakin ingin mengosongkan semua field?')) {
                document.getElementById('busForm').reset();
            }
        }

        // Preview functionality for better UX
        function updatePreview() {
            const name = document.getElementById('name').value;
            const plateNumber = document.getElementById('plate_number').value;
            const totalSeats = document.getElementById('total_seats').value;
            const status = document.getElementById('status').value;

            // You can add preview functionality here if needed
        }

        // Add event listeners for real-time preview
        ['name', 'plate_number', 'total_seats', 'status'].forEach(id => {
            document.getElementById(id).addEventListener('input', updatePreview);
        });
    </script>
@endpush
