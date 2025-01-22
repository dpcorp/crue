<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title')</title>
    <meta name="title" content="CRUE">
    <meta name="description" content="Centro Regulador de Urgencias, Emergencias y Desastres">
    <meta name="keywords" content="Centro Regulador de Urgencias, Emergencias, Desastres">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="Spanish">
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('assets/images/app/CRUE.png') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/webfont.min.js') }}"></script>
    <link href="https://fonts.googleapis.com/css2?family=Geologica:wght,CRSV@100..900,0.5&display=swap"
        rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <script>
        window.appConfig = {
            baseUrl: "{{ config('app.url') }}"
        };
    </script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: [`${window.appConfig.baseUrl}assets/css/lib/fonts.min.css`],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link href="{{ asset('assets/css/lib/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/lib/plugins.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/lib/kaiadmin.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/lib/demo.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/app/main.css') }}" />

    <link href="https://cdn.datatables.net/colreorder/1.7.0/css/colReorder.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/fixedcolumns/5.0.1/css/fixedColumns.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css" rel="stylesheet">

    <script type="text/javascript" src="{{ asset('assets/js/lib/sweetalert2@11.js') }}"></script>

    @yield('cdn')

</head>

<body>
    @php
        $settings = \App\Models\ColorSetting::where('user_id', auth()->user()->id)->get();
        $logo = 'dark';
        $navbar = 'white';
        $sidebar = 'dark';
        foreach ($settings as $key => $setting) {
            if ($setting->component == 'navbar') {
                $navbar = $setting->color;
            }

            if ($setting->component == 'sidebar') {
                $sidebar = $setting->color;
            }

            if ($setting->component == 'logo') {
                $logo = $setting->color;
            }
        }
    @endphp
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="{{ $sidebar }}">
            @include('components.main.sidebard')
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                @include('components.main.navbar')
            </div>

            <div class="container">
                <div class="page-inner">
                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Custom template | don't include it in your project! -->
        @include('components.main.change_theme')
        <!-- End Custom template -->
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/lib/popper.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/lib/bootstrap.min.js') }}" defer></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/js/lib/jquery.scrollbar.min.js') }}" defer></script>

    <!-- Kaiadmin JS -->
    <script src="{{ asset('assets/js/lib/kaiadmin.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/lib/setting-demo.js?v=1.0.1') }}" defer></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('assets/js/lib/sweetalert.min.js') }}" defer></script>
    {{-- <script src="{{ asset('assets/js/lib/datatables.min.js') }}" defer></script> --}}

    <script src="https://cdn.datatables.net/v/bs4/dt-1.13.11/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/colreorder/1.7.0/js/dataTables.colReorder.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/dataTables.fixedColumns.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.4.1/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.js"></script>

</body>

</html>
