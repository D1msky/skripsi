@extends('layouts.master')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/apexcharts.css')}}">
@endsection
@section('main-content')
<div class="breadcrumb">
    <h1>Dashboard Mahasiswa</h1>
</div>

<div class="separator-breadcrumb border-top"></div>

<div class="row">

    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center">
                <i class="i-Conference"></i>
                <div class="content">
                    <p class="text-muted mt-2 mb-0">Total Kelas</p>
                    <p class="text-primary text-24 line-height-1 mb-2">{{$data['jmlhkelas']}}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center">
                <i class="i-Notepad"></i>
                <div class="content">
                    <p class="text-muted mt-2 mb-0">Total Tugas Aktif</p>
                    <p class="text-primary text-24 line-height-1 mb-2">{{$data['tugasaktif']}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card mb-3">
            <div class="card-header">
                Kumpul Tugas Terdekat
            </div>
            <div class="card-body">

                <p class="card-text text-15 text-center">{{$data['tugasTerdekat']}}</p>

            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-4 col-lg-4 col-sm-6">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">Beban Tugas Mahasiswa</div>
                <div id="simpleRadialBar"></div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card o-hidden mb-4">
            <div class="card-header d-flex align-items-center border-0">
                <h3 class="w-50 float-left card-title m-0">Daftar Tugas</h3>

            </div>

            <div class="">
                <div class="table-responsive">
                    <table id="user_table" class="table text-center">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" style="width: 10%">NO</th>
                                <th scope="col" style="width: 20%">KELAS</th>
                                <th scope="col" style="width: 40%">NAMA TUGAS</th>
                                <th scope="col" style="width: 10%">PERSEN</th>
                                <th scope="col" style="width: 20%">SISA WAKTU (DAY)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(json_decode($tugas) as $tgs)
                            <tr>
                                <th scope="row">{{($loop->index)+1}}</th>
                                <td>{{$tgs->NAMA}}</td>
                                <td>{{$tgs->NAMA_TUGAS}}</td>
                                <td>{{$tgs->PERSEN}}</td>
                                <td>{{$tgs->SELISIH}}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>

</div>




@endsection

@section('page-js')
<script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
<script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/apexcharts.dataseries.js')}}"></script>
<script type="text/javascript">
    var rataBobot;
    $(document).ready(function() {
        grafik();
    });

    function grafik() {
        // Basic Radial Bar Chart
        var getSeries = "{{$data['rataBobot']}}";
        if (getSeries != 0) {
            rataBobot = (Math.round(getSeries * 100) / 100).toPrecision(2);
            var labelBobot = "Beban [" + getSeries + "]";
            rataBobot = ((getSeries) / (4)) * 100;
            rataBobot = (Math.round(rataBobot * 100) / 100).toPrecision(2);
        }else{
            var labelBobot = "Beban [" + getSeries + "]";
            rataBobot = 0;
        }

        var options = {
            chart: {
                height: 250,
                type: 'radialBar'
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        size: '70%'
                    },
                    dataLabels: {
                        showOn: 'always'
                    }

                }
            },
            fill: {
                colors: [cekWarna()]
            },
            series: [rataBobot],
            labels: [labelBobot]

        };

        var chart = new ApexCharts(document.querySelector("#simpleRadialBar"), options);

        chart.render();

    }

    function cekWarna() {
        if (rataBobot < 40) {
            return '#4caf50';
        } else if (rataBobot < 70) {
            return '#ffc107';
        } else {
            return '#f44336';
        }
    }
</script>
@endsection