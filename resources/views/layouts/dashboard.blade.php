<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name') }}</title>

  <!-- Google Font: Source Sans Pro -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('/template/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="shortcut icon" href="{{ asset('/template/dist/img/favicon.ico') }}">
  <script src="{{ asset('js/app.js') }}" defer></script>
  @yield('custom-css')
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/template/dist/css/adminlte.min.css') }}">
  {{-- <link rel="stylesheet" href="{{ asset('/template/dist/css/customstyle.css') }}"> --}}
</head>
{{-- <body class="sidebar-mini layout-fixed layout-navbar-fixed"> --}}
<body class="hold-transition layout-top-nav layout-fixed layout-navbar-fixed">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <a href="/dashboard" class="navbar-brand">
      <img src="{{ asset('/template/dist/img/brand_logo_bg.png') }}" alt="eSMPT" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">KKM-UTILITI</span>
    </a>
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="dashboard" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="dashboard" class="nav-link">Utama</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="bandingan" class="nav-link">Perbandingan</a>
      </li>
      @if (Auth::user()->role == 'Pentadbir')
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/utama" class="nav-link">Pentadbiran</a>
      </li> 
      @endif
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
          <a class="nav-link" href="{{ route('logout1') }}">
              <i class="fas fa-times-circle text-danger"></i> Logout
          </a>            
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->  
  <div class="content-wrapper">
    {{-- Breadcrumb --}}
    @yield('breadcrumb')

    @yield('content')
    
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Versi</b> 2.0
    </div>
    <strong>Hakcipta &copy; {{ date('Y') }} <a href="#">SMPT</a>.</strong> Bahagian Pembangunan.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('/template/plugins/jquery/jquery.min.js') }}"></script>

<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('/template/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/template/dist/js/adminlte.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('/template/dist/js/pages/dashboard.js') }}"></script>
<!-- addon js -->
@yield('js')
</body>
</html>
