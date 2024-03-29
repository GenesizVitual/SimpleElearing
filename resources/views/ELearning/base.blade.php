<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <link rel='icon' href='{{ asset('PESRI.png') }}'>

  <title>Mts Ummussabri</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('admin_asset/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin_asset/dist/css/adminlte.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('admin_asset/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('admin_asset/plugins/toastr/toastr.min.css') }}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ asset('admin_asset/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('admin_asset/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin_asset/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('admin_asset/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- Theme style -->

  @yield('css')

  <link rel="stylesheet" href="{{ asset('admin_asset/dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  @include('Elearning.component_admin.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('Elearning.component_admin.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  @include('Elearning.component_admin.Lsidebar')
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->

    <!-- Default to the left -->
    <strong>Copyright &copy; 2020 <a href="#">mtsummusshabri.com</a> All rights reserved.</strong>
  </footer>

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('admin_asset/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('admin_asset/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('admin_asset/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('admin_asset/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('admin_asset/plugins/toastr/toastr.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('admin_asset/dist/js/adminlte.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('admin_asset/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('admin_asset/plugins/daterangepicker/daterangepicker.js') }}"></script>

</body>
@yield('jsContainer')
@include('Elearning.component_admin.toast')


</html>
