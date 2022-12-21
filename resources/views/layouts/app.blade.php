<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Dashboard - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('template/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('template/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('template/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('template/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{ asset('template/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{ asset('template/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{ asset('template/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{ asset('template/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('template/vendor/datatables/datatables.css') }}">
  <link rel="stylesheet" href="{{ asset('template/vendor/datatables/Buttons-2.1.1/css/buttons.bootstrap.css') }}" >
  <link href="{{ asset('template/css/style.css') }}" rel="stylesheet">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    @php
      $user = auth()->user();
    @endphp

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('home') }}" class="logo d-flex align-items-center">
            <img src="{{ asset('template/img/logo.png') }}" alt="">
            <span class="d-none d-lg-block">NBM</span>
        </a>
        @if($user)
            @if($user->level_id == '1')
                <i class="bi bi-list toggle-sidebar-btn"></i>
            @endif
        @endif
    </div><!-- End Logo -->

      @if($user)
          @if($user->level_id == '2')
              <div class="search-bar">
                  <form class="search-form d-flex align-items-center" method="GET" action="{{ route('home') }}">
                      <input type="text" name="search" placeholder="Search" title="Enter search keyword">
                      <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                  </form>
              </div>
          @endif
      @endif


    <nav class="header-nav ms-auto">
      @include('layouts.navbar')
    </nav>
  </header><!-- End Header -->

  @if(Auth::check())
    @if(auth()->user()->level_id == '1')
        <aside id="sidebar" class="sidebar">

            <ul class="sidebar-nav" id="sidebar-nav">

                <li class="nav-item">
                    <a class="nav-link " href="{{route('admin.home')}}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                    </a>
                </li
                <li class="nav-heading">Pages</li>

                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('admin.product.index') }}">
                    <i class="bi bi-box"></i>
                    <span>Produk</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('admin.transaction.index') }}">
                    <i class="bi bi-bucket"></i>
                    <span>Transaksi </span>
                    </a>
                </li>
            </ul>
        </aside>
    @endif
  @endif

  @if(Auth::check())
      @if(auth()->user()->level_id == '1')
          <main id="main" class="main">
              @yield('content')
          </main>
      @else
          <div class="container">
              <br><br><br>
              @yield('content')
          </div>
      @endif
  @else
      <div class="container">
          <br><br><br>
          @yield('content')
      </div>
  @endif


  <!-- Vendor JS Files -->
  <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
  <script src="{{ asset('template/vendor/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
  <script src="{{ asset('template/vendor/chart.js/chart.min.js') }}"></script>
  <script src="{{ asset('template/vendor/echarts/echarts.min.js') }}"></script>
  <script src="{{ asset('template/vendor/quill/quill.min.js') }}"></script>
  <script src="{{ asset('template/vendor/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('template/vendor/datatables/Buttons-2.1.1/js/buttons.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('template/vendor/datatables/Buttons-2.1.1/js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('template/vendor/datatables/Buttons-2.1.1/js/buttons.print.min.js') }}"></script>
  <script src="{{ asset('template/vendor/datatables/JSZip-2.5.0/jszip.min.js') }}"></script>
  <script src="{{ asset('template/vendor/datatables/pdfmake-0.1.36/pdfmake.min.js') }}"></script>
  <script src="{{ asset('template/vendor/datatables/pdfmake-0.1.36/vfs_fonts.js') }}"></script>
  <script src="{{ asset('template/vendor/datatables/RowGroup/dataTables.rowGroup.min.js') }}"></script>
  <script src="{{ asset('template/vendor/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('template/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('template/vendor/sweetalert/dist/sweetalert2.min.js') }}"></script>
  <!-- Template Main JS File -->
  <script src="{{ asset('template/js/main.js') }}"></script>

  @stack('script')
</body>

</html>
