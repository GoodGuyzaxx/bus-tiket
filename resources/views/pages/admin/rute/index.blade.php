@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mt-4 mb-2">Daftar Rute</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $title ?? 'Rute' }}</li>
                    </ol>
                </nav>
            </div>
            <a href="{{route('rute.create')}}" class="btn btn-primary d-flex align-items-center">
                <i class="fas fa-plus me-2"></i> Tambah rute
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
                <h5 class="mb-0 text-dark">Data Rute</h5>
            </div>
            <div class="card-body p-">
                <div class="table-responsive">
                    <table id="datatablesSimple" class="table table-hover border" style="width:100%">
                        <thead class="bg-light">
                        <tr>
                            <th >No</th>
                            <th >Nama Bus</th>
                            <th>Asal</th>
                            <th>Tujuan</th>
                            <th>Harga</th>
                            <th >Wakut Keberangkatan - Tiba</th>
                            <th >Stauts</th>
                            <th >Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if ($data->count())
                            @foreach ($data as $rute)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $rute->bus->name }}</td>
                                    <td>{{ $rute->origin }} </td>
                                    <td>{{ $rute->destination }} </td>
                                    <td>Rp {{ number_format($rute->price, 0, ',', '.') }} </td>
                                    <td>{{ $rute->departure_time->format('H:i') }} - {{ $rute->arrival_time->format('H:i') }}</td>
                                    <td>
                                        @if($rute->status == 'active')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('rute.edit', $rute->id) }}" class="btn btn-sm btn-warning me-1" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('rute.destroy', $rute->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="btn btn-sm btn-danger me-1" onclick="return confirm('Are you sure you want to delete this?')"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="fas fa-bus me-2"></i> Belum ada data Rute bus.
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
