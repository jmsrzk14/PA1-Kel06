@extends('admin.layout.layoutadmin')

@section('title', 'Dashboard')

@push('script')
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
@endpush

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4><i class="fa fa-calendar"></i> &nbsp;<?php echo date('l - d F Y'); ?></h4>
                </div>
                <div class="col-sm-6">
                    <h1 class="m-0 text-right">Dashboard</h1>
                </div>
            </div>
        </div>
    </div>
    
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $JumlahProduk }}</h3>
                            <p>Produk</p>
                        </div>
                        <div class="icon">
                            <i class="nav-icon fas fa-boxes"></i>
                        </div>
                        <a href="/admin/produk" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>Rp. {{ number_format($PenjualanPerHari, 0, ',', '.') }}</h3>
                            <p>Penjualan <?php echo date('d F Y'); ?></p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-money-bill-wave"></i>
                        </div>
                        <a href="/admin/penjualan" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $JumlahKasir }}</h3>
                            <p>Kasir</p>
                        </div>
                        <div class="icon">
                            <i class="nav-icon fas fa-users"></i>
                        </div>
                        <a href="/admin/kasir" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $JumlahKategori }}</h3>
                            <p>Kategori</p>
                        </div>
                        <div class="icon">
                            <i class="nav-icon fa fa-bars"></i>
                        </div>
                        <a href="/admin/kategori" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
            <form action="/admin/dashboard" method="get">
            @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <input type="number" id="datepicker" placeholder="Tahun: {{ date('Y') }}" value="{{ $tahun ?? date('Y') }}" name="tahun" class="date-own form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <button class="btn btn-success" style="background-color: #012378; border-color: #012378;">Filter</button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-12">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-money-bill-wave mr-1"></i>
                                Penjualan
                            </h3>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 mb-lg-0 mb-4">
                                <div class="card">
                                    <div class="card-body p-3">
                                        <div id="container"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </section>
                <!-- /.Left col -->
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
        Highcharts.setOptions({
            lang: {
                invalidData: {
                    highcharts: 'Error: unable to process data',
                    highstock: 'Error: unable to apply data',
                    highmaps: 'Error: unable to apply data'
                }
            }
        });

        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Statistik Data Penjualan',
                align: 'left',
                margin: 50
            },
            subtitle: {
                text: '{{ $tahun }}',
                align: 'center',
            },
            xAxis: {
                categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                crosshair: true,
                accessibility: {
                    description: 'Months'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah'
                }
            },
            tooltip: {
                valueSuffix: ' Rp. ',
                pointFormat: '<span style="color:{point.color}">\u25CF</span> {series.name}: <b>{point.y:,.0f}</b><br/>'
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: 'Rp. {point.y:,.0f}',
                        style: {
                            color: '#333'
                        }
                    }
                }
            },
            series: [{
                name: 'Penjualan',
                data: {!! json_encode($charts_donasi) !!}.map(Number),
                color: '#2E8B57'
            }]
        });

        $("#datepicker").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years"
        });
</script>
@endsection
