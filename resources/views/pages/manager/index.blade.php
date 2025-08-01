@extends('layouts.manager')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <!-- Content Row -->
            <div class="row">
                <!-- Siswa Card Example -->
                {{--                <div class="col-xl-3 col-md-6 mb-4">--}}
                {{--                    <div class="card border-left-primary shadow h-100 py-2">--}}
                {{--                        <a style="text-decoration:none; color: #212529;" href="{{ route('admin.user.index') }}">--}}
                {{--                            <div class="card-body">--}}
                {{--                                <div class="row no-gutters align-items-center">--}}
                {{--                                    <div class="col mr-2">--}}
                {{--                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">--}}
                {{--                                            Admin Kantin</div>--}}
                {{--                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$Admin}}</div>--}}
                {{--                                    </div>--}}
                {{--                                    <div class="col-auto">--}}
                {{--                                        <i class="fas fa-user-gear fa-2x text-gray-300"></i>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </a>--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                {{--                <div class="col-xl-3 col-md-6 mb-4">--}}
                {{--                    <div class="card border-left-primary shadow h-100 py-2">--}}
                {{--                        <a style="text-decoration:none; color: #212529;" href="{{ route('admin.konsumen.index') }}">--}}
                {{--                            <div class="card-body">--}}
                {{--                                <div class="row no-gutters align-items-center">--}}
                {{--                                    <div class="col mr-2">--}}
                {{--                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">--}}
                {{--                                            Konsumen</div>--}}
                {{--                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$Konsumen}}</div>--}}
                {{--                                    </div>--}}
                {{--                                    <div class="col-auto">--}}
                {{--                                        <i class="fas fa-users fa-2x text-gray-300"></i>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </a>--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                {{--                <!-- Class Card Example -->--}}
                {{--                <div class="col-xl-3 col-md-6 mb-4">--}}
                {{--                    <div class="card border-left-info shadow h-100 py-2">--}}
                {{--                        <a href="{{ route('admin.kantin.index') }}" style="text-decoration:none; color: #212529;">--}}
                {{--                            <div class="card-body">--}}
                {{--                                <div class="row no-gutters align-items-center">--}}
                {{--                                    <div class="col mr-2">--}}
                {{--                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Kantin--}}
                {{--                                        </div>--}}
                {{--                                        <div class="row no-gutters align-items-center">--}}
                {{--                                            <div class="col-auto">--}}
                {{--                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$Kantin}}--}}
                {{--                                                </div>--}}
                {{--                                            </div>--}}
                {{--                                        </div>--}}
                {{--                                    </div>--}}
                {{--                                    <div class="col-auto">--}}
                {{--                                        <i class="fas fa-house fa-2x text-gray-300"></i>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </a>--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                {{--                <!-- Criteria Card Example -->--}}
                {{--                <div class="col-xl-3 col-md-6 mb-4">--}}
                {{--                    <div class="card border-left-success shadow h-100 py-2">--}}
                {{--                        <a href="{{ route('admin.menu.index') }}" style="text-decoration:none; color: #212529;">--}}
                {{--                            <div class="card-body">--}}
                {{--                                <div class="row no-gutters align-items-center">--}}
                {{--                                    <div class="col mr-2">--}}
                {{--                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">--}}
                {{--                                            Menu</div>--}}
                {{--                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$Menu}}</div>--}}
                {{--                                    </div>--}}
                {{--                                    <div class="col-auto">--}}
                {{--                                        <i class="fas fa-book fa-2x text-gray-300"></i>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </a>--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                {{--                <!-- Data user Card Example -->--}}
                {{--                <div class="col-xl-3 col-md-6 mb-4">--}}
                {{--                    <div class="card border-left-warning shadow h-100 py-2">--}}
                {{--                        <div class="card-body">--}}
                {{--                            <div class="row no-gutters align-items-center">--}}
                {{--                                <div class="col mr-2">--}}
                {{--                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">--}}
                {{--                                        Pengguna</div>--}}
                {{--                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Dewa</div>--}}
                {{--                                </div>--}}
                {{--                                <div class="col-auto">--}}
                {{--                                    <i class="fas fa-user-gear fa-2x text-gray-300"></i>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>
        </div>
    </main>
@endsection
