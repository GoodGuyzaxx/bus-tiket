@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mt-4 mb-2">Tambah Rute</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('rute.index') }}">Rute</a></li>
                        <li class="breadcrumb-item active">Tambah Rute</li>
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
                <h5 class="mb-0 text-dark">Form Tambah Rute Bus</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('rute.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- Pilih Bus -->
                        <div class="col-md-6 mb-3">
                            <label for="bus_id" class="form-label">Nama Bus <span class="text-danger">*</span></label>
                            <select class="form-select @error('bus_id') is-invalid @enderror" id="bus_id" name="bus_id" required>
                                <option value="">Pilih Bus</option>
                                @foreach($buses as $bus)
                                    <option value="{{ $bus->id }}" {{ old('bus_id') == $bus->id ? 'selected' : '' }}>
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
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
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
                                   id="origin" name="origin" value="{{ old('origin') }}"
                                   placeholder="Masukkan kota asal" required>
                            @error('origin')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tujuan -->
                        <div class="col-md-6 mb-3">
                            <label for="destination" class="form-label">Tujuan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('destination') is-invalid @enderror"
                                   id="destination" name="destination" value="{{ old('destination') }}"
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
                                       id="price" name="price" value="{{ old('price') }}"
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
                                   id="departure_time" name="departure_time" value="{{ old('departure_time') }}" required>
                            @error('departure_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Waktu Tiba -->
                        <div class="col-md-4 mb-3">
                            <label for="arrival_time" class="form-label">Waktu Tiba <span class="text-danger">*</span></label>
                            <input type="time" class="form-control @error('arrival_time') is-invalid @enderror"
                                   id="arrival_time" name="arrival_time" value="{{ old('arrival_time') }}" required>
                            @error('arrival_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('rute.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="reset" class="btn btn-warning">
                                    <i class="fas fa-undo me-2"></i>Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan Rute
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Additional JavaScript for form validation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Format price input
            const priceInput = document.getElementById('price');
            priceInput.addEventListener('input', function() {
                // Remove non-numeric characters except for the decimal point
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
        });
    </script>
@endsection
