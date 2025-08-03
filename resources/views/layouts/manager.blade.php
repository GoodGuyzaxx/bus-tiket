<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('frontend/images/logo.png') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>

    {{-- style --}}
    @include('includes.manager.style')

</head>

<body class="sb-nav-fixed">

    {{-- navbar --}}
    @include('includes.manager.navbar')


    <div id="layoutSidenav">

        {{-- sidenav --}}
        @include('includes.manager.sidenav')

        {{-- content --}}
        <div id="layoutSidenav_content">
            {{-- content --}}
            @yield('content')

            {{-- footer --}}
{{--            @include('includes.admin.footer')--}}
        </div>
    </div>

    @include('includes.manager.script')

</body>

</html>
