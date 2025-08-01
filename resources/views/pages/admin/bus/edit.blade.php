@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mt-4 mb-2">Edit Bus</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('bus.index') }}">Daftar Bus</a></li>
                        <li class="breadcrumb-item active">Edit Bus</li>
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
                    <div class="card-header bg-warning text-dark">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-edit me-2"></i>
                            <h5 class="mb-0">Form Edit Bus - {{ $bus->name }}</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <!-- Current Bus Info -->
                        <div class="alert alert-info mb-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle me-2"></i>
                                <div>
                                    <strong>Bus yang sedang diedit:</strong><br>
                                    <span class="badge bg-secondary me-2">{{ $bus->plate_number }}</span>
                                    <span>{{ $bus->name }}</span> -
                                    <span class="badge
                                        @if($bus->status == 'active') bg-success
                                        @elseif($bus->status == 'maintenance') bg-warning
                                        @else bg-danger @endif">
                                        {{ ucfirst($bus->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('bus.update', $bus->id) }}" method="POST" id="busEditForm">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="name" class="form-label fw-bold">
                                        <i class="fas fa-bus me-1 text-warning"></i>
                                        Nama Bus <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name', $bus->name) }}"
                                           placeholder="Masukkan nama bus (contoh: DAMRI AC 01)"
                                           required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="plate_number" class="form-label fw-bold">
                                        <i class="fas fa-id-card me-1 text-warning"></i>
                                        Plat Nomor <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('plate_number') is-invalid @enderror"
                                           id="plate_number"
                                           name="plate_number"
                                           value="{{ old('plate_number', $bus->plate_number) }}"
                                           placeholder="PA 1234 AI"
                                           style="text-transform: uppercase;"
                                           required>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Format: PA [4 digit angka] AI (contoh: PA 1234 AI)
                                    </div>
                                    @error('plate_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="total_seats" class="form-label fw-bold">
                                        <i class="fas fa-chair me-1 text-warning"></i>
                                        Total Kursi <span class="text-danger">*</span>
                                    </label>
                                    <input type="number"
                                           class="form-control @error('total_seats') is-invalid @enderror"
                                           id="total_seats"
                                           name="total_seats"
                                           value="{{ old('total_seats', $bus->total_seats) }}"
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
                                        <i class="fas fa-toggle-on me-1 text-warning"></i>
                                        Status Bus <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('status') is-invalid @enderror"
                                            id="status"
                                            name="status"
                                            required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="active" {{ old('status', $bus->status) == 'active' ? 'selected' : '' }}>
                                            Aktif
                                        </option>
                                        <option value="maintenance" {{ old('status', $bus->status) == 'maintenance' ? 'selected' : '' }}>
                                            Perawatan
                                        </option>
                                        <option value="inactive" {{ old('status', $bus->status) == 'inactive' ? 'selected' : '' }}>
                                            Tidak Aktif
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

                            <!-- Change History (Optional) -->
                            <div class="bg-light p-3 rounded mb-4">
                                <h6 class="mb-2"><i class="fas fa-clock me-1 text-muted"></i> Informasi Terakhir</h6>
                                <div class="row text-sm">
                                    <div class="col-md-6">
                                        <small class="text-muted">
                                            <strong>Dibuat:</strong> {{ $bus->created_at->format('d/m/Y H:i') }}
                                        </small>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted">
                                            <strong>Terakhir diubah:</strong> {{ $bus->updated_at->format('d/m/Y H:i') }}
                                        </small>
                                    </div>
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
                                    <button type="submit" class="btn btn-warning text-dark">
                                        <i class="fas fa-save me-1"></i> Update Bus
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fas fa-exclamation-triangle text-danger" style="font-size: 48px;"></i>
                        <h6 class="mt-3">Apakah Anda yakin ingin menghapus bus ini?</h6>
                        <p class="text-muted">
                            <strong>{{ $bus->name }}</strong><br>
                            <span class="badge bg-secondary">{{ $bus->plate_number }}</span>
                        </p>
                        <p class="text-danger small">
                            <i class="fas fa-warning me-1"></i>
                            Tindakan ini tidak dapat dibatalkan!
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <form action="{{ route('bus.destroy', $bus->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i> Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Store original values for reset functionality
            const originalValues = {
                name: '{{ $bus->name }}',
                plate_number: '{{ $bus->plate_number }}',
                total_seats: '{{ $bus->total_seats }}',
                status: '{{ $bus->status }}'
            };

            // Auto uppercase plate number input
            const plateNumberInput = document.getElementById('plate_number');
            plateNumberInput.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });

            // Form validation
            const form = document.getElementById('busEditForm');
            form.addEventListener('submit', function(e) {
                const plateNumber = document.getElementById('plate_number').value;
                const totalSeats = document.getElementById('total_seats').value;

                // Validate plate number format (PA format)
                const plateRegex = /^PA\s*\d{4}\s*AI$/;
                if (!plateRegex.test(plateNumber)) {
                    e.preventDefault();
                    alert('Format plat nomor tidak valid. Gunakan format: PA [4 digit] AI');
                    return false;
                }

                // Validate total seats
                if (totalSeats < 1 || totalSeats > 100) {
                    e.preventDefault();
                    alert('Jumlah kursi harus antara 1-100');
                    return false;
                }

                // Confirm update
                if (!confirm('Apakah Anda yakin ingin menyimpan perubahan?')) {
                    e.preventDefault();
                    return false;
                }
            });

            // Add loading state to submit button
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
                submitBtn.disabled = true;
            });

            // Reset form to original values
            window.resetForm = function() {
                if (confirm('Apakah Anda yakin ingin mengembalikan ke nilai asli?')) {
                    document.getElementById('name').value = originalValues.name;
                    document.getElementById('plate_number').value = originalValues.plate_number;
                    document.getElementById('total_seats').value = originalValues.total_seats;
                    document.getElementById('status').value = originalValues.status;
                }
            };

            // Highlight changed fields
            function highlightChanges() {
                const fields = ['name', 'plate_number', 'total_seats', 'status'];
                fields.forEach(field => {
                    const element = document.getElementById(field);
                    if (element.value !== originalValues[field]) {
                        element.classList.add('border-warning');
                        element.style.backgroundColor = '#fff3cd';
                    } else {
                        element.classList.remove('border-warning');
                        element.style.backgroundColor = '';
                    }
                });
            }

            // Add change detection
            ['name', 'plate_number', 'total_seats', 'status'].forEach(id => {
                document.getElementById(id).addEventListener('input', highlightChanges);
                document.getElementById(id).addEventListener('change', highlightChanges);
            });
        });
    </script>
@endpush
