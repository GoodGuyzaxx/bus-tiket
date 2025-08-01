@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mt-4 mb-2">Daftar Bus</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $title ?? 'Bus' }}</li>
                    </ol>
                </nav>
            </div>
            <a href="{{route('bus.create')}}" class="btn btn-primary d-flex align-items-center">
                <i class="fas fa-plus me-2"></i> Tambah Bus
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

        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-dark">Data Bus</h5>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="datatablesSimple" class="table table-hover border" style="width:100%">
                        <thead class="bg-light">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Bus</th>
                            <th>Plat Nomor</th>
                            <th class="text-center">Total Kursi</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if ($data->count())
                            @foreach ($data as $bus)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $bus->name }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $bus->plate_number }}</span>
                                    </td>
                                    <td class="text-center">{{ $bus->total_seats }} kursi</td>
                                    <td class="text-center">
                                        @if($bus->status == 'active')
                                            <span class="badge bg-success">Aktif</span>
                                        @elseif($bus->status == 'maintenance')
                                            <span class="badge bg-warning">Perawatan</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('bus.edit', $bus->id) }}" class="btn btn-sm btn-warning me-1" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('bus.destroy', $bus->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="btn btn-sm btn-danger me-1" onclick="return confirm('Are you sure you want to delete this bus?')"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fas fa-bus me-2"></i> Belum ada data bus.
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
