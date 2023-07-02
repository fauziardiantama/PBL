<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') Dosen - SIMKMM | Sistem Informasi Kegiatan Magang Mahasiswa D3 Teknik Informatika UNS</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ url('/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ url('/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ url('/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ url('/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ url('/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ url('/plugins/summernote/summernote-bs4.min.css') }}">
    <!-- sweetalert2 -->
    <link rel="stylesheet" href="{{ url('/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

    <style>
        .user-body {
            border-bottom: 0 !important;
        }
        .search-title > .text-light {
            color: #000000 !important;
        }
        #notes {
            width: 100%;
            width:100%;
            border: 0;
        }
        #notes:focus {
            outline: none;
        }
        .dark-mode .timeline > div > .timeline-item {
            background-color: #182635 !important;
            color: #fff;
            border-color: #6c757d;
        }
        .bg-transparent {
            background-color: transparent!important;
        }
        .dark-mode .content-wrapper, .dark-mode .wrapper, .dark-mode .dropdown-menu {
        background-color: #182635;
        color:#fff;
        }

        .dark-mode .navbar-nav>.user-menu>.dropdown-menu>.user-body a:hover, .dark-mode .navbar-nav>.user-menu>.dropdown-menu>.user-body a:focus, .dark-mode .navbar-nav>.user-menu>.dropdown-menu>.user-body a:active {
            background-color: #182635;
            color: #FED700 !important;
        }

        .dark-mode .f1-step.activated .f1-step-icon {
            background-color: transparent !important;
        }

        .dark-mode .main-header, .dark-mode .main-footer {
            border-bottom: 1px solid #000;
            background-color: rgba(2,0,36,1) !important;
        }
        .dark-mode .main-footer .text-dark:hover, .dark-mode .main-footer .text-dark:focus, .dark-mode .main-footer .text-dark:active {
            color: #FED700 !important;
        }
        .dark-mode a {
            color: #FED700 !important;
        }

        .dark-mode .btn-primary {
            background-color: #FED700 !important;
            border-color: #FED700 !important;
            color: #000 !important;
        }

        .dark-mode .btn-sm {
            color:  #fff !important;
        }

        .dark-mode .btn-primary.btn-sm {
            color: #000 !important;
        }

        .dark-mode .navbar-nav .nav-link:hover,  .dark-mode .navbar-nav .nav-link:active, .dark-mode .navbar-nav .nav-link:focus, .dark-mode .navbar-nav .nav-link.active {
            color: #FED700 !important;
        }

        .dark-mode .main-header .navbar .nav-item > .nav-link {
            color: #fff;
        }
        .dark-mode .nav-pills .nav-link.active, .dark-mode .nav-pills .show>.nav-link
        {
            background-color: #FED700 !important;
            color: #000 !important;
        }
        #notes {
            background-color: #ffffff00;
        }

        .dark-mode #notes {
            color: #fff;
        }
    </style>
    @yield('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ url('/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60"
                width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: #FED700">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link  text-dark" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ url('/dosen/dashboard') }}" class="nav-link  text-dark">Dashboard</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ url('/') }}" class="nav-link  text-dark">Halaman utama</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                    <a class="nav-link  text-dark" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item dropdown user user-menu">
                    <a href="#" class="nav-link dropdown-toggle  text-dark" data-toggle="dropdown">

                        <span class="hidden-xs">{{ Auth::guard('dosen')->user()->nama }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <li class="user-header h-100" style="background-color: #010080 !important; color: #ffff !important">
                            <p>
                                {{ Auth::guard('dosen')->user()->nama }}
                                <small>Role : dosen</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row">
                                <div class="col-4 text-center">
                                    <a href="{{ url('/dosen/profil') }}">Profile</a>
                                </div>
                                <div onclick="$('#notecard').show()" class="col-4 text-center">
                                    <a href="#">Notes</a>
                                </div>
                                <div class="col-4 text-center">
                                    <a href="{{ url('/logout') }}">Log out</a>
                                </div>
                            </div>
                            <!-- /.row -->
                        </li>
                    </ul>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notecard" style="left: inherit; right: 0px;">
                        <li class="user-header h-100" style="background-color: #010080 !important; color: #ffff !important">
                            <div class="card-header">
                                <p class="card-title">
                                    Notes
                                </p>
                                <div class="card-tools"> 
                                    <button type="button" onclick="$('#notecard').hide()" class="btn btn-tool">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </li>
                        <li class="user-body">
                            <textarea id="notes"></textarea>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-dark" id="tema" role="button">
                        <i class="fas fa-moon"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-primary elevation-4"
            style="background: rgb(2,0,36); background: linear-gradient(180deg, rgba(2,0,36,1) 0%, rgba(0,0,107,1) 20%, rgba(0,0,0,1) 100%);">
            <!-- Brand Logo -->
            <a href="{{ url('/dosen/dashboard') }}" class="brand-link text-white" style="border-color: black;">
                <img src="{{ url('/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">SIMKMM D3TI UNS</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="{{ url('/dosen/dashboard') }}" class="nav-link text-white {!! request()->is('dosen/dashboard*') ? 'font-weight-bolder" style="outline: 1px solid white;' : ''!!}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/dosen/bidang-topik') }}" class="nav-link text-white {!! request()->is('dosen/bidang-topik*') ? 'font-weight-bolder" style="outline: 1px solid white;' : ''!!}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Topik KMM
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/dosen/magang') }}" class="nav-link text-white {!! request()->is('dosen/magang*') ? 'font-weight-bolder" style="outline: 1px solid white;' : ''!!}">
                                <i class="nav-icon fas fa-graduation-cap"></i>
                                <p>
                                    Magang
                                </p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{ url('/dosen/bimbingan') }}" class="nav-link text-white {!! request()->is('dosen/bimbingan*') ? 'font-weight-bolder" style="outline: 1px solid white;' : ''!!}">
                                <i class="nav-icon fas fa-chalkboard-teacher"></i>
                                <p>
                                    Bimbingan
                                </p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="{{ url('/dosen/seminardanrevisi') }}" class="nav-link text-white {!! request()->is('dosen/seminardanrevisi*') ? 'font-weight-bolder" style="outline: 1px solid white;' : ''!!}">
                                <i class="nav-icon fas fa-school"></i>
                                <p>
                                    Seminar dan revisi
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/dosen/penguji') }}" class="nav-link text-white {!! request()->is('dosen/penguji*') ? 'font-weight-bolder" style="outline: 1px solid white;' : ''!!}">
                                <i class="nav-icon fas  fa-chalkboard-teacher"></i>
                                <p>
                                    Penguji
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/dosen/nilai') }}" class="nav-link text-white {!! request()->is('dosen/nilai*') ? 'font-weight-bolder" style="outline: 1px solid white;' : ''!!}">
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>
                                    Nilai
                                </p>
                            </a>
                        </li>
                        <li class="nav-header text-white">Lainnya</li>
                        <li class="nav-item">
                            <a href="{{ url('/dosen/profil') }}" class="nav-link text-white {!! request()->is('dosen/profil*') ? 'font-weight-bolder" style="outline: 1px solid white;' : ''!!}">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    Profil
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/logout') }}" class="nav-link text-white {!! request()->is('logout*') ? 'font-weight-bolder" style="outline: 1px solid white;' : ''!!}">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    Log out
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('title')</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                @yield('path')
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid bg-transparent">
                    @yield('content')
                </div>
            </section>
            <!-- /.content -->
        </div>
        @yield('modal')
        <!-- /.content-wrapper -->
        <footer class="main-footer text-dark" style="background-color: #FED700;">
            <strong>SIMKMM Copyright &copy; 2023 Design by <a class="text-dark"
                    href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>

        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ url('/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ url('/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ url('/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ url('/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ url('/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ url('/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ url('/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ url('/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ url('/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ url('/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ url('/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ url('/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('/dist/js/adminlte.js') }}"></script>
    <script src="{{ url('/dist/js/demo.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ url('/dist/js/pages/dashboard.js') }}"></script>
    <script src="{{ url('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            tema = localStorage.getItem('tema');
            if (tema == 'dark') {
                //element inside #tema change to <i class="fas fa-sun"></i>
                $('#tema').html('<i class="fas fa-sun"></i>');
                $('body').addClass('dark-mode');
            } else {
                //element inside #tema change to <i class="fas fa-moon"></i>
                $('#tema').html('<i class="fas fa-moon"></i>');
                $('body').removeClass('dark-mode');
            }
            $('#notes').on('change', function() {
                localStorage.setItem('notes', $(this).val());
            });
            $('#notes').val(localStorage.getItem('notes'));
            //#tema as a element, make function when clicked, save it in localstorage and load it when page is ready
            $('#tema').on('click', function() {
                tema = localStorage.getItem('tema');
                if (tema == 'dark') {
                    localStorage.setItem('tema', 'light');
                    //element inside #tema change to <i class="fas fa-moon"></i>
                    $('#tema').html('<i class="fas fa-moon"></i>');
                    $('body').removeClass('dark-mode');
                } else {
                    localStorage.setItem('tema', 'dark');
                    //element inside #tema change to <i class="fas fa-sun"></i>
                    $('#tema').html('<i class="fas fa-sun"></i>');
                    $('body').addClass('dark-mode');
                }
            });
        });
    </script>
    @yield('javascript')
</body>

</html>
