@extends('layouts.admin')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>

            <!-- Dashboard Row -->
            <div class="row">
                <!-- Total Bus Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <a style="text-decoration:none; color: #212529;" href="">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Jumlah Bus
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$data['total_bus']}}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-bus fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Total Rute Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <a style="text-decoration:none; color: #212529;" href="">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Jumlah Rute
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$data['total_rute']}}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-road fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>


                <!-- Total Jadwal Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <a style="text-decoration:none; color: #212529;" href="">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            User Aktif
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$data['total_user']}} </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Pendapatan Penjualan Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <a style="text-decoration:none; color: #212529;" href="">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Pendapatan Penjualan
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            Rp {{ number_format($data['total_revenue'], 0, ',', '.') }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection
