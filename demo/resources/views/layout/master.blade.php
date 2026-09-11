<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Admin Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="CWC Admin Dashboard" name="description" />
    <meta content="Ayush Vahane" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('backends/assets/images/cwc-log.jpg') }}">

    <!-- Upcube Core Styles -->
    <link href="{{ asset('backends/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backends/assets/css/icons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backends/assets/css/app.min.css') }}" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>
        /* Small visual tweaks */
        .page-title-box h4 {
            font-weight: 600;
        }
        .main-content {
            min-height: 100vh;
        }
        .form-select{
            text-transform: uppercase;
        }
    </style>
</head>

<body data-topbar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

        {{--  Header --}}
        @include('layout.header')

        {{--  Sidebar --}}
        @include('layout.sidebar')

        <!--  Main Content -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            {{--  Footer --}}
            @include('layout.footer')
        </div>
        <!-- End Main Content -->

    </div>
    <!-- END layout-wrapper -->

    <!-- JS -->
    <script src="{{ asset('backends/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backends/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backends/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backends/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backends/assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- Page specific scripts -->
    @stack('scripts')

    <script src="{{ asset('backends/assets/js/app.js') }}"></script>
@include('partials.chatbot')
</body>
</html>

{{-- ============================
    MASTER LAYOUT
    - All pages extend this layout
    - Contains header, sidebar, footer, and main content area
    - Main content is injected via @yield('content')
    - Common CSS and JS assets are included here
    - Page-specific scripts can be added via @push('scripts')
============================ --}}
