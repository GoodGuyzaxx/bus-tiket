@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mt-4 mb-2">Edit Rute</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('rute.index') }}">Rute</a></li>
                        <li class="breadcrumb-item active">Edit Rute</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('rute.index') }}" class="btn btn-secondary d-flex align-items-center">
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

        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-dark">Form Edit Rute Bus</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('rute.update', $rute->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Pilih Bus -->
                        <div class="col-md-6 mb-3">
                            <label for="bus_id" class="form-label">Nama Bus <span class="text-danger">*</span></label>
                            <select class="form-select @error('bus_id') is-invalid @enderror" id="bus_id" name="bus_id" required>
                                <option value="">Pilih Bus</option>
                                @foreach($buses as $bus)
                                    <option value="{{ $bus->id }}"
                                        {{ (old('bus_id', $rute->bus_id) == $bus->id) ? 'selected' : '' }}>
                                        {{ $bus->name }} - {{ $bus->plate_number }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bus_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="active" {{ (old('status', $rute->status) == 'active') ? 'selected' : '' }}>
                                    Aktif
                                </option>
                                <option value="inactive" {{ (old('status', $rute->status) == 'inactive') ? 'selected' : '' }}>
                                    Tidak Aktif
                                </option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Asal -->
                        <div class="col-md-6 mb-3">
                            <label for="origin" class="form-label">Asal <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('origin') is-invalid @enderror"
                                   id="origin" name="origin" value="{{ old('origin', $rute->origin) }}"
                                   placeholder="Masukkan kota asal" required>
                            @error('origin')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tujuan -->
                        <div class="col-md-6 mb-3">
                            <label for="destination" class="form-label">Tujuan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('destination') is-invalid @enderror"
                                   id="destination" name="destination" value="{{ old('destination', $rute->destination) }}"
                                   placeholder="Masukkan kota tujuan" required>
                            @error('destination')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Harga -->
                        <div class="col-md-4 mb-3">
                            <label for="price" class="form-label">Harga <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                       id="price" name="price" value="{{ old('price', $rute->price) }}"
                                       placeholder="0" min="0" step="1000" required>
                            </div>
                            @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Waktu Keberangkatan -->
                        <div class="col-md-4 mb-3">
                            <label for="departure_time" class="form-label">Waktu Keberangkatan <span class="text-danger">*</span></label>
                            <input type="time" class="form-control @error('departure_time') is-invalid @enderror"
                                   id="departure_time" name="departure_time"
                                   value="{{ old('departure_time', date('H:i', strtotime($rute->departure_time))) }}" required>
                            @error('departure_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Waktu Tiba -->
                        <div class="col-md-4 mb-3">
                            <label for="arrival_time" class="form-label">Waktu Tiba <span class="text-danger">*</span></label>
                            <input type="time" class="form-control @error('arrival_time') is-invalid @enderror"
                                   id="arrival_time" name="arrival_time"
                                   value="{{ old('arrival_time', date('H:i', strtotime($rute->arrival_time))) }}" required>
                            @error('arrival_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Info Update -->
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="alert alert-info d-flex align-items-center" role="alert">
                                <i class="fas fa-info-circle me-2"></i>
                                <div>
                                    <small>
                                        <strong>Terakhir diubah:</strong>
                                        {{ $rute->updated_at ? $rute->updated_at->format('d M Y, H:i') : 'Belum pernah diubah' }}
                                        @if($rute->updated_at && $rute->updated_at->diffInMinutes($rute->created_at) > 5)
                                            | <strong>Dibuat:</strong> {{ $rute->created_at->format('d M Y, H:i') }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <!-- Left side - Preview button (optional) -->
                                <div>
                                    <button type="button" class="btn btn-outline-info" onclick="previewChanges()">
                                        <i class="fas fa-eye me-2"></i>Preview
                                    </button>
                                </div>

                                <!-- Right side - Action buttons -->
                                <div class="d-flex gap-2">
                                    <a href="{{ route('rute.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                    <button type="reset" class="btn btn-warning" onclick="resetForm()">
                                        <i class="fas fa-undo me-2"></i>Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Update Rute
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Preview Modal -->
        <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="previewModalLabel">
                            <i class="fas fa-eye me-2"></i>Preview Perubahan Data Rute
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted">Data Lama</h6>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="mb-2"><strong>Bus:</strong> {{ $rute->bus->name ?? 'N/A' }}</div>
                                        <div class="mb-2"><strong>Rute:</strong> {{ $rute->origin }} → {{ $rute->destination }}</div>
                                        <div class="mb-2"><strong>Harga:</strong> Rp {{ number_format($rute->price, 0, ',', '.') }}</div>
                                        <div class="mb-2"><strong>Waktu:</strong> {{ date('H:i', strtotime($rute->departure_time)) }} - {{ date('H:i', strtotime($rute->arrival_time)) }}</div>
                                        <div class="mb-2">
                                            <strong>Status:</strong>
                                            <span class="badge bg-{{ $rute->status == 'active' ? 'success' : 'danger' }}">
                                                {{ $rute->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Data Baru</h6>
                                <div class="card bg-primary text-white">
                                    <div class="card-body" id="previewData">
                                        <!-- Data akan diisi oleh JavaScript -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Store original values for reset functionality
            const originalValues = {
                bus_id: '{{ $rute->bus_id }}',
                origin: '{{ $rute->origin }}',
                destination: '{{ $rute->destination }}',
                price: '{{ $rute->price }}',
                departure_time: '{{ date('H:i', strtotime($rute->departure_time)) }}',
                arrival_time: '{{ date('H:i', strtotime($rute->arrival_time)) }}',
                status: '{{ $rute->status }}',
                description: '{{ $rute->description ?? '' }}'
            };

            // Format price input
            const priceInput = document.getElementById('price');
            priceInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            // Validate departure and arrival time
            const departureTime = document.getElementById('departure_time');
            const arrivalTime = document.getElementById('arrival_time');

            function validateTimes() {
                if (departureTime.value && arrivalTime.value) {
                    if (departureTime.value >= arrivalTime.value) {
                        arrivalTime.setCustomValidity('Waktu tiba harus lebih besar dari waktu keberangkatan');
                    } else {
                        arrivalTime.setCustomValidity('');
                    }
                }
            }

            departureTime.addEventListener('change', validateTimes);
            arrivalTime.addEventListener('change', validateTimes);

            // Reset form function
            window.resetForm = function() {
                if (confirm('Apakah Anda yakin ingin mereset form ke data awal?')) {
                    document.getElementById('bus_id').value = originalValues.bus_id;
                    document.getElementById('origin').value = originalValues.origin;
                    document.getElementById('destination').value = originalValues.destination;
                    document.getElementById('price').value = originalValues.price;
                    document.getElementById('departure_time').value = originalValues.departure_time;
                    document.getElementById('arrival_time').value = originalValues.arrival_time;
                    document.getElementById('status').value = originalValues.status;
                    document.getElementById('description').value = originalValues.description;

                    // Remove validation classes
                    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                    document.querySelectorAll('.is-valid').forEach(el => el.classList.remove('is-valid'));
                }
            };

            // Preview changes function
            window.previewChanges = function() {
                const busSelect = document.getElementById('bus_id');
                const busText = busSelect.options[busSelect.selectedIndex].text;
                const status = document.getElementById('status').value;
                const statusText = status === 'active' ? 'Aktif' : 'Tidak Aktif';
                const statusClass = status === 'active' ? 'success' : 'danger';

                const previewHtml = `
                    <div class="mb-2"><strong>Bus:</strong> ${busText}</div>
                    <div class="mb-2"><strong>Rute:</strong> ${document.getElementById('origin').value} → ${document.getElementById('destination').value}</div>
                    <div class="mb-2"><strong>Harga:</strong> Rp ${new Intl.NumberFormat('id-ID').format(document.getElementById('price').value)}</div>
                    <div class="mb-2"><strong>Waktu:</strong> ${document.getElementById('departure_time').value} - ${document.getElementById('arrival_time').value}</div>
                    <div class="mb-2">
                        <strong>Status:</strong>
                        <span class="badge bg-${statusClass}">${statusText}</span>
                    </div>
                `;

                document.getElementById('previewData').innerHTML = previewHtml;
                new bootstrap.Modal(document.getElementById('previewModal')).show();
            };
        });
    </script>
@endsection
