<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <title>ALMS | @yield('title')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('public/plugins')}}/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('public/plugins')}}/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('public/plugins')}}/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('public/plugins')}}/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('public/plugins')}}/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('public/plugins')}}/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('public/plugins')}}/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('public/backend')}}/css/adminlte.min.css">
   <!-- Toastr -->
   <link rel="stylesheet" href="{{ asset('public/plugins/toastr/toastr.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('public/plugins')}}/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('public/plugins')}}/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('public/plugins')}}/summernote/summernote-bs4.min.css">

  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('public/plugins')}}/select2/css/select2.min.css">
  <link rel="stylesheet" href="{{ asset('public/plugins')}}/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('public/assets/style/upms-theme.css') }}?v=1.6">

  <style>
    :root {
        --upms-green: #10d915;
        --upms-deep-green: #046307;
        --upms-sidebar: #ffffff;
        --upms-sidebar-dark: #f8fafc;
        --upms-text: #213243;
        --upms-sidebar-border: #e6eef3;
    }

    .main-header.navbar-upms {
        background: var(--upms-deep-green) !important;
        border-bottom: 0 !important;
        box-shadow: 0 4px 18px rgba(4, 99, 7, 0.18) !important;
        min-height: 58px !important;
    }

    .main-header.navbar-upms .nav-link {
        color: #ffffff !important;
    }

    .main-header.navbar-upms .nav-link:hover,
    .main-header.navbar-upms .nav-link:focus {
        background: rgba(255, 255, 255, 0.12) !important;
        color: #ffffff !important;
    }

    .main-header.navbar-upms .navbar-nav > .nav-item > .nav-link {
        border-radius: 6px;
        margin: 0 3px;
        font-weight: 600;
    }

    .main-sidebar {
        background: #d6e0df !important;
        border-right: 0 !important;
        box-shadow: none !important;
        position: fixed !important;
        top: 0 !important;
        bottom: 0 !important;
        height: 100vh !important;
    }

    .wrapper {
        background: #d6e0df !important;
    }

    .brand-link {
        display: flex !important;
        align-items: center !important;
        min-height: 58px !important;
        background: #ffffffff !important;
        border-bottom: 0 !important;
        border-right: 1px solid #7dd3fc !important;
        color: #0f172a !important;
        font-weight: 700 !important;
        box-shadow: none !important;
    }

    .brand-link .brand-text {
        color: #046307 !important;
        font-weight: 800 !important;
        letter-spacing: .5px;
    }

    .brand-link .brand-image {
        background: #ffffff;
        border: 2px solid rgba(255, 255, 255, 0.75);
        opacity: 1 !important;
    }

    /* Set sidebar width for desktop */
    @media (min-width: 992px) {
        body:not(.sidebar-collapse) .main-sidebar,
        body.sidebar-mini.sidebar-collapse .main-sidebar:hover {
            width: 250px !important;
        }
        body:not(.sidebar-collapse) .content-wrapper,
        body:not(.sidebar-collapse) .main-footer,
        body:not(.sidebar-collapse) .main-header {
            margin-left: 250px !important;
        }
    }
    .sidebar {
        max-height: calc(100vh - 58px);
        overflow-y: auto !important;
        scrollbar-width: none;
        -ms-overflow-style: none;
        padding: 0 !important;
        margin: 0 !important;
    }
    .sidebar::-webkit-scrollbar,
    .main-sidebar::-webkit-scrollbar {
        display: none !important;
    }
    .os-scrollbar {
        opacity: 0 !important;
        pointer-events: none !important;
    }

    .nav-sidebar {
        padding-top: 8px;
        padding-bottom: 20px;
        padding-right: 12px;
        padding-left: 12px;
    }

    .nav-sidebar .nav-item > .nav-link {
        color: rgba(33, 50, 67, 0.9) !important;
        border-radius: 8px;
        margin: 8px 0;
        padding: 12px 16px;
        transition: background-color .18s ease, color .18s ease, transform .18s ease;
        background: transparent !important;
        position: relative;
        display: block;
        width: 100%;
    }

    .nav-sidebar .nav-item > .nav-link p,
    .nav-sidebar .nav-item > .nav-link i {
        color: inherit !important;
    }

    .nav-sidebar .nav-link > p > .right,
    .nav-sidebar .nav-link > p > i.right {
        top: 50% !important;
        transform: translateY(-50%) !important;
    }

    .nav-sidebar .menu-open > .nav-link > p > .right,
    .nav-sidebar .menu-open > .nav-link > p > i.right {
        transform: translateY(-50%) rotate(-90deg) !important;
    }

    .nav-sidebar .nav-link:hover {
        background-color: rgba(4, 99, 7, 0.06) !important;
        color: var(--upms-deep-green) !important;
        transform: translateX(1px);
    }

    .nav-sidebar > .nav-item.menu-open > .nav-link:not(.active) {
        background: rgba(33, 50, 67, 0.04) !important;
        color: var(--upms-text) !important;
    }

    .nav-sidebar .nav-treeview {
        margin: 8px 12px 12px;
        padding: 8px 0;
        background: var(--upms-sidebar-dark);
        border-radius: 10px;
    }
    .nav-sidebar .nav-treeview .nav-link {
        padding: 10px 16px !important;
    }

    .nav-sidebar .nav-treeview > .nav-item > .nav-link,
    .nav-sidebar .nav-treeview > .nav-item > .nav-link p,
    .nav-sidebar .nav-treeview > .nav-item > .nav-link i {
        color: var(--upms-text) !important;
        font-weight: 600;
    }

    .nav-sidebar .nav-treeview > .nav-item > .nav-link:hover {
        color: var(--upms-deep-green) !important;
    }

    .nav-sidebar .nav-treeview > .nav-item > .nav-link {
        margin: 1px 6px;
        color: rgba(33, 50, 67, 0.8) !important;
        font-size: 14px;
    }

    .nav-sidebar .nav-treeview > .nav-item > .nav-link.active,
    .nav-sidebar .nav-link.active,
    .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active,
    .sidebar-light-primary .nav-sidebar > .nav-item > .nav-link.active {
        background: transparent !important;
        color: var(--upms-deep-green) !important;
        border-left: 3px solid var(--upms-deep-green);
        padding-left: calc(1rem - 3px) !important;
    }

    .nav-sidebar .nav-treeview > .nav-item > .nav-link.active i,
    .nav-sidebar .nav-link.active i,
    .nav-sidebar .nav-treeview > .nav-item > .nav-link.active p,
    .nav-sidebar .nav-link.active p {
        color: #071b08 !important;
    }

    .content-wrapper {
        background: #eef2f7;
        margin-top: 0 !important;
        padding: 1rem !important;
    }

    .content-wrapper > .content {
        margin-top: 0 !important;
    }

    .main-footer {
        border-top: 1px solid #dbe5df;
        color: #64748b;
    }

    .card.card-info > .card-header,
    .card-info > .card-header {
        background: #f3f4f6 !important;
        border-bottom-color: #e6eef3 !important;
        color: #6b7a86 !important;
    }

    .card.card-info > .card-header .card-title,
    .card-info > .card-header .card-title {
        color: #6b7a86 !important;
    }

    .card.card-info > .card-header .btn,
    .card-info > .card-header .btn {
        background: #1f2937 !important;
        border-color: #1f2937 !important;
        color: #ffffff !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #444;
        line-height: 17px !important;
    }
    .select2 {
width:100%!important;
}
    .table-action, .btn-pill-group {
      display: inline-flex !important;
      gap: 4px !important;
      align-items: center !important;
      flex-wrap: nowrap !important;
    }
    /* Universal Table Responsiveness & Layout Fixes */
    .table-responsive {
        display: block !important;
        width: 100% !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important;
        margin-bottom: 1rem;
    }
    table.table {
        width: 100% !important;
        max-width: none !important;
        margin-bottom: 0 !important;
    }
    .table td, .table th {
        vertical-align: middle !important;
    }
    .dataTables_wrapper {
        width: 100% !important;
        overflow-x: auto !important;
    }

    /* 8-column table content responsiveness from 1024px to 1920px (prevents horizontal and vertical scrolling) */
    @media (min-width: 1024px) and (max-width: 1920px) {
        .table-responsive {
            overflow-x: auto !important;
            overflow-y: hidden !important;
        }
        table.table {
            width: 100% !important;
            table-layout: auto !important;
        }
        .table td, .table th {
            padding: 0.45rem 0.55rem !important;
            font-size: 0.86rem !important;
            line-height: 1.35 !important;
            white-space: normal !important;
            word-break: break-word !important;
            overflow-wrap: break-word !important;
            vertical-align: middle !important;
        }
        /* Ensure serial and action buttons stay compact without breaking row height */
        .table td:first-child,
        .table th:first-child,
        .table td:last-child,
        .table th:last-child {
            white-space: nowrap !important;
            width: 1% !important;
        }
        .table td:last-child .btn,
        .table td:last-child a.btn,
        .table-action .btn,
        .btn-pill-group .btn {
            padding: 0.2rem 0.45rem !important;
            font-size: 0.75rem !important;
        }
    }

    /* Responsive sidebar and content wrapper fixes for screens below 1024px */
    @media (max-width: 1023.98px) {
        .content-wrapper {
            width: 100% !important;
            min-width: 100% !important;
            overflow-x: hidden !important;
        }
        .card-body {
            padding: 0.75rem !important;
        }
        .table td, .table th {
            padding: 0.45rem 0.55rem !important;
            font-size: 0.85rem !important;
            white-space: nowrap !important;
        }
        .btn-sm {
            padding: 0.2rem 0.45rem !important;
            font-size: 0.75rem !important;
        }
    }

    /* Custom Bootstrap Pagination Styling */
    .pagination {
        display: inline-flex !important;
        padding-left: 0 !important;
        list-style: none !important;
        border: 1px solid #dcdcdc !important;
        border-radius: 6px !important;
        overflow: hidden !important;
        margin: 0 !important;
        background: #ffffff !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;
    }

    .pagination .page-item {
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
    }

    .pagination .page-item .page-link {
        position: relative !important;
        display: block !important;
        padding: 6px 14px !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        color: #007bff !important;
        background-color: #ffffff !important;
        border: none !important;
        border-right: 1px solid #e2e8f0 !important;
        line-height: 1.4 !important;
        text-decoration: none !important;
        transition: all 0.15s ease-in-out !important;
    }

    .pagination .page-item:last-child .page-link {
        border-right: none !important;
    }

    .pagination .page-item.active .page-link {
        z-index: 3 !important;
        color: #ffffff !important;
        background-color: #007bff !important;
        border-color: #007bff !important;
        font-weight: bold !important;
    }

    .pagination .page-item:not(.active):not(.disabled) .page-link:hover {
        color: #0056b3 !important;
        background-color: #f1f5f9 !important;
    }

    .pagination .page-item.disabled .page-link {
        color: #94a3b8 !important;
        pointer-events: none !important;
        background-color: #ffffff !important;
    }
  </style>
  @stack('style')
  @stack('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    @auth()
        <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @endauth
<div class="wrapper">

  <!-- Preloader -->
  {{-- <div class="preloader flex-column justify-content-center align-items-center"> --}}
      {{-- <h3 class="animation__shake"><i class="fas fa-tachometer-alt"></i>UPMS</h3> --}}
    {{-- <img class="animation__shake" src="{{ asset('public/backend')}}/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60"> --}}
  {{-- </div> --}}

  <!-- Navbar -->
@include('backend.layouts.header')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('backend.layouts.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->
  @include('backend.layouts.footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
{{-- <script src="{{ asset('public/plugins')}}/jquery/jquery.min.js"></script> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('public/plugins')}}/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('public/plugins')}}/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="{{ asset('public/plugins')}}/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="{{ asset('public/plugins')}}/sparklines/sparkline.js"></script>

<!-- DataTables  & Plugins -->
<script src="{{ asset('public/plugins')}}/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('public/plugins')}}/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('public/plugins')}}/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('public/plugins')}}/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('public/plugins')}}/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('public/plugins')}}/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('public/plugins')}}/jszip/jszip.min.js"></script>
<script src="{{ asset('public/plugins')}}/pdfmake/pdfmake.min.js"></script>
<script src="{{ asset('public/plugins')}}/pdfmake/vfs_fonts.js"></script>
<script src="{{ asset('public/plugins')}}/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('public/plugins')}}/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('public/plugins')}}/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- jQuery Knob Chart -->
<script src="{{ asset('public/plugins')}}/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="{{ asset('public/plugins')}}/moment/moment.min.js"></script>
<script src="{{ asset('public/plugins')}}/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('public/plugins')}}/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Toastr -->
<script src="{{ asset('public/plugins/toastr/toastr.min.js') }}"></script>

<!-- sweetalert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('public/plugins/sweetalert2/sweetalert2.min.js') }}"></scrip
<!-- Summernote -->
<script src="{{ asset('public/plugins')}}/summernote/summernote-bs4.min.js"></script>
<!-- Select2 -->
<script src="{{ asset('public/plugins')}}/select2/js/select2.full.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('public/plugins')}}/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/backend')}}/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('public/backend')}}/js/demo.js"></script>

<script type="text/javascript">
  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<script>
$(document).ready(function() {
    $(".datepicker").datepicker({
        dateFormat: "dd-mm-yy" // dd-mm-yyyy
    });

    // Automatically make any remaining tables responsive across the entire portal
    $('table.table').each(function() {
        if (!$(this).parent().hasClass('table-responsive') && !$(this).parent().hasClass('dataTables_scrollBody')) {
            $(this).wrap('<div class="table-responsive" style="width: 100%; overflow-x: auto;"></div>');
        }
    });

    // Ensure DataTables wrappers never break layout boundaries
    $('.dataTables_wrapper').css('overflow-x', 'auto');
});
</script>


@stack('script')
@stack('js')



</body>
</html>
