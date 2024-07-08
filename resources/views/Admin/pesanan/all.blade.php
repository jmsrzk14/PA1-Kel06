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

            <!-- Main content -->
            <section class="content">
                @php
                $total = 0; // Mendeklarasikan variabel $total dengan nilai awal 0
                @endphp
                <!-- Default box -->
                <div class="card">
                <div class="card-header">
        <h4><i class="fa fa-calendar"></i> &nbsp;<?php echo date('l - d F Y'); ?></h4>
                        <h3 class="card-title">@yield('subtitle')</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead style="background-color:gold;">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Pemesan</th>
                                    <th scope="col">Nama Produk</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($storage as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td style="font-size: 18px;">{{ $value->user->name }}</td>
                                    <td style="font-size: 18px;">{{ $value->product_name }}</td>
                                    <td style="font-size: 18px;">{{ $value->price }}</td>
                                    <td>
                                        @if ($value['status'] == 1)
                                        Diterima
                                        @elseif ($value['status'] == 2)
                                        Ditolak
                                        @else
                                        Menunggu
                                        @endif
                                    </td>
                                    <td>
                                @if ($value->status == 0)
                                    <a href="{{ route('status', ['id' => $value->id, 'status' => 1]) }}" class="btn btn-success btn-sm mr-3">Terima</a>
                                    <a href="{{ route('status', ['id' => $value->id, 'status' => 2]) }}" class="btn btn-danger btn-sm">Tolak</a>
                                @endif
                            </td>

                                </tr>
                                @if ($value->status == 1)
                                @php
                                $total += $value->price;
                                @endphp
                                @endif
                                @empty
                                <tr>
                                    <td colspan="3">Tidak Ada Data</td>
                                </tr>
                                @endforelse
                            </tbody>
                            @if ($storage -> isNotEmpty())
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-center">Total</td>
                                    <td>{{ $total }}</td>
                                    <td>
                                    <td></td>
                                    </td>
                                </tr>
                            </tfoot>
                            @endif
                        </table>

                    </div>
                    <!-- /.card-body -->
                    <!-- /.card-footer-->
                </div>
                <!-- /.card -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

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