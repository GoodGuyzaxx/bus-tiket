@extends('layouts.manager')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mt-4 mb-2">Daftar Pengguan</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                         <li class="breadcrumb-item active">{{ $title ?? 'User' }}</li>
                    </ol>
                </nav>
            </div>
            <a href="{{route('manager.user.create')}}" class="btn btn-primary d-flex align-items-center">
                <i class="fas fa-plus me-2"></i> Tambah Pengguna
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
                <h5 class="mb-0 text-dark">Data Pengguna Admin</h5>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="datatablesSimple" class="table table-hover border" style="width:100%">
                        <thead class="bg-light">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Nomor Handphone</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if ($data->count())
                            @foreach ($data as $admin)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->role }}</td>
                                    <td class="text-center">
                                        <a href="" class="btn btn-sm btn-warning me-1" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger btnDelete"
                                                data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal"
                                                data-id="{{ $admin->id }}"
                                                data-name="{{ $admin->name }}"
                                                title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fas fa-info-circle me-2"></i> Belum ada data pengguna admin.
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

{{--    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">--}}
{{--        <div class="modal-dialog">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi Hapus</h5>--}}
{{--                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    Apakah Anda yakin ingin menghapus pengguna <strong id="adminNamePlaceholder"></strong> ini? Tindakan ini tidak dapat dibatalkan.--}}
{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>--}}
{{--                    <form id="deleteForm" method="POST" action="">--}}
{{--                        @csrf--}}
{{--                        @method('DELETE')--}}
{{--                        <button type="submit" class="btn btn-danger">Hapus</button>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection

{{--@push('scripts')--}}
{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');--}}
{{--            const deleteForm = document.getElementById('deleteForm');--}}
{{--            const adminNamePlaceholder = document.getElementById('adminNamePlaceholder');--}}

{{--            deleteConfirmationModal.addEventListener('show.bs.modal', function (event) {--}}
{{--                // Button that triggered the modal--}}
{{--                const button = event.relatedTarget;--}}
{{--                // Extract info from data-* attributes--}}
{{--                const adminId = button.getAttribute('data-id');--}}
{{--                const adminName = button.getAttribute('data-name');--}}

{{--                // Update the modal's content.--}}
{{--                adminNamePlaceholder.textContent = adminName;--}}
{{--                deleteForm.action = `/manager/user/${adminId}`; // Adjust your delete route here--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endpush--}}
