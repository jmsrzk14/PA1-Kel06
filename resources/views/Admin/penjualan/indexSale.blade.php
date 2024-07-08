<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Roiyall Coffee</title>
    <link rel="icon" type="image/x-icon" href="/images/logo.png">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/Admin_css/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/Admin_css/dist/css/adminlte.min.css') }}">
    @stack('style')
</head>

<body class="hold-transition sidebar-mini">
@include('sweetalert::alert')

    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        @include('StrukturAdmin.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="" class="brand-link">
                <img src="/images/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Admin Roiyall Coffee</span>
            </a>

            <!-- Sidebar -->
            @include('StrukturAdmin.sidebar')
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>@yield('title')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>


    <div class="card-header">
        <h4><i class="fa fa-calendar"></i> &nbsp;<?php echo date('l - d F Y'); ?></h4>
    </div>
    <div class="card card-primary ml-3 mt-2" style="width: 100%">
    <div class="container">
    <h1>Daftar Penjualan</h1>
    <!-- <a href="{{ route('admin.sale.create') }}" class="btn btn-primary">Tambah Penjualan</a> -->
    <br>
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
<table class="table">
        <thead style="background-color:gold;">
            <tr>
                <th>Nama Pembeli</th>
                <th>Pesanan</th>
                <th>Jumlah Pesanan</th>
                <th>Tanggal Penjualan</th>
                <th>Total Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualan as $sale)
                <tr>
                    <td>{{ $sale->nama_pembeli }}</td>
                    <td>{{ $sale->post->name }}</td>
                    <td>{{ $sale->jumlah }}</td>
                    <td>{{ $sale->tanggal_penjualan }}</td>
                    <td>{{ $sale->price }}</td>
                    <td>
                    <a href="{{ route('sale.edit', $sale->id) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('sale.destroy', $sale->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $penjualan->links() }}
</div>
        </div>
    </div>
</div>

<footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0
            </div>
            <strong>Designed by Kelompok 05 PA 2024 </strong>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('/Admin_css/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('/Admin_css/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('/Admin_css/dist/js/adminlte.min.js') }}"></script>
    @stack('script')
</body>

</html>