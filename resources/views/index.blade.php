<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="base-url" content="{{ URL::to('/') }}"/>
    {{--    Favicon --}}
    <link rel="apple-touch-icon" sizes="57x57" href="{{asset('/images/favicon/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('/images/favicon/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('/images/favicon/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('/images/favicon/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('/images/favicon/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('/images/favicon/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('/images/favicon/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('/images/favicon/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('/images/favicon/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{asset('/images/favicon/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('/images/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('/images/favicon/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('/images/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('/images/favicon/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{asset('/images/favicon/ms-icon-144x144.png')}}">
    <meta name="theme-color" content="#ffffff">
    {{--    End Favicon --}}

    <title>SEMS @yield('title')</title>

    @include('partials.style')
    @yield('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
@section('wrapper')
    <div class="wrapper">

        @include('partials.preloader')

        @include('partials.navbar')

        @include('partials.sidebar')

        @section('content-wrapper')
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @section('content-header')
                    @yield('header')
                    @yield('content-wrapper')
                @show

                @section('main-content')
                    <!-- Main content -->
                    <section class="content">

                        @section('container-fluid')

                            <div class="container-fluid">

                                @section('row')
                                    @yield('content')
                                @show
                                <!-- /.row -->
                            </div><!-- /.container-fluid -->
                        @show
                    </section>
                @show
                <!-- /.content -->

            </div>
        @show


        @include('partials.footer')

        @include('partials.controlsidebar')

    </div>

    @section('script')
        @yield('add-script')
        @include('partials.script')

    @show
</body>

</html>
