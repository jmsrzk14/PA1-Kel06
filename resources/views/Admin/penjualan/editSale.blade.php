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
    <h1>Edit Penjualan</h1>
    <form action="/admin/sale/{{ $penjualan->id }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama_pembeli">Nama Pembeli</label>
            <input type="text" class="form-control" id="nama_pembeli" name="nama_pembeli" value="{{ $penjualan->nama_pembeli }}">
        </div>
        <div class="form-group">
            <label for="post_id">Nama Produk</label>
            <input type="text" class="form-control" id="post_id" name="post_id" value="{{ $penjualan->post->name }}">
        </div>
        <div class="form-group">
            <label for="price">Harga</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ $penjualan->post->price }}">
        </div>
        <div class="form-group">
            <label for="jumlah">Jumlah</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $penjualan->jumlah }}">
        </div>
        @error('jumlah')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="form-group">
            <label for="tanggal_penjualan">Tanggal Penjualan</label>
            <input type="date" class="form-control" id="tanggal_penjualan" name="tanggal_penjualan" value="{{ $penjualan->tanggal_penjualan }}">
        </div>
        @error('tanggal_penjualan')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <button type="submit" class="btn btn-success mt-5 mr-4"><i class="fas fa-check"></i> Edit</button>
        <a href="/admin/sale" class="btn btn-danger mt-5"><i class="fas fa-times"></i> Batalkan</a>
    </form>
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