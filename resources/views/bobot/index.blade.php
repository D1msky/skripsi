@extends('layouts.master')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/apexcharts.css')}}">
@endsection

@section('main-content')
<div class="breadcrumb">
    <h1>Kelas</h1>
    <ul>
        <li><a href="#">Beban Tugas Mahasiswa</a></li>
    </ul>

</div>
<div class="separator-breadcrumb border-top"></div>

<!-- end of row -->
<div class="row mb-4">
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3">BEBAN TUGAS MAHASISWA {{$kelas->matakuliah->NAMA_MATAKULIAH}} GROUP {{$kelas->GRUP}}</h4>
                <div class="row">
                    <div class="col-md-3" style="margin: auto">
                        <div class="table-responsive">
                            <table id="user_table" class="table text-center">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" style="width: 10%">BEBAN</th>
                                        <th scope="col" style="width: 20%">FUZZY</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Very Low</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>Low</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>Medium</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">4</th>
                                        <td>High</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-3" style="margin: auto">
                        <h6 class="text-primary">ARTI WARNA :</h6><br>
                        <button type="button" class="btn btn-success btn-block m-1 mb-3">[ < 40% ] Beban Rendah</button> <button type="button" class="btn btn-warning btn-block m-1 mb-3">[ 40% - 70%] Beban Sedang</button>
                        <button type="button" class="btn btn-danger btn-block m-1 mb-3">[ > 70%] Beban Tinggi</button>
                    </div>
                    <div class="col-md-4">
                        <div id="simpleRadialBar"></div>
                    </div>
                </div>


                <div class="table-responsive">
                    <table id="tblBobot" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>NIM</th>
                                <th>NAMA</th>
                                <th>BEBAN TUGAS (%)</th>
                                <th>BEBAN TUGAS (0-4)</th>
                                <th>KUMPUL TUGAS TERDEKAT</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- end of col -->
    @include('Prodi.modal')
    <div id="reloadModal"></div>
    @endsection

    @section('page-js')
    <script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables.script.js')}}"></script>
    <script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
    <script type="text/javascript">
        var rataBeban;
        var labelBeban;
        $(document).ready(function() {
            loadGrid();
            grafik();
        });

        function loadGrid() {
            $.ajax({
                type: "POST",
                url: '{{url("api/bobot")}}',
                data: '{"idKelas": "{{$kelas->ID_KELAS}}"}',
                contentType: "application/json;charset=utf-8",
                datatype: "json",
                success: function(data) {
                    //console.log(data);
                    var totalBeban = 0;
                    var lengthBobot = data.length;
                    for (var i = 0; i < lengthBobot; i++) {
                        totalBeban += data[i].BOBOT;
                    }
                    rataBeban = (totalBeban / lengthBobot);
                
                    rataBeban = (Math.round(rataBeban * 100) / 100).toPrecision(2);
                    labelBeban = "Rata2 Beban [" + rataBeban + "]";

                    rataBeban = ((rataBeban) / (4)) * 100;
                    rataBeban = (Math.round(rataBeban * 100) / 100).toPrecision(2);


                    var oTable = $("#tblBobot").DataTable({
                        data: data,
                        select: false,
                        lengthMenu: [
                            [10, 20],
                            [10, 20]
                        ],
                        //paging: false,                
                        columns: [{
                                data: "ID_USER",
                                searchable: true,
                                width: "10%"
                            },
                            {
                                data: "NAMA",
                                searchable: true,
                                width: "40%"
                            },
                            {
                                data: null,
                                render: function(data, type, row) {
                                    if (data.BOBOT != 0) {
                                        var dataBobot = ((data.BOBOT) / (4)) * 100;

                                        if (dataBobot < 40) {
                                            return '<div class="progress mb-3"><div class="progress-bar bg-success" role="progressbar" style="width: ' + (Math.round(dataBobot * 100) / 100).toPrecision(2) + '%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div></div>Persen : ' + (Math.round(dataBobot * 100) / 100).toPrecision(2) + '%';
                                        } else if (dataBobot < 70) {
                                            return '<div class="progress mb-3"><div class="progress-bar bg-warning" role="progressbar" style="width: ' + (Math.round(dataBobot * 100) / 100).toPrecision(2) + '%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div></div>Persen : ' + (Math.round(dataBobot * 100) / 100).toPrecision(2) + '%';
                                        } else {
                                            return '<div class="progress mb-3"><div class="progress-bar bg-danger" role="progressbar" style="width: ' + (Math.round(dataBobot * 100) / 100).toPrecision(2) + '%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div></div>Persen : ' + (Math.round(dataBobot * 100) / 100).toPrecision(2) + '%';
                                        }
                                    }else{
                                        return '<div class="progress mb-3"><div class="progress-bar bg-success" role="progressbar" style="width:0%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div></div>Persen : 0%';
                                    }


                                },
                                searchable: true,
                                width: "20%"
                            },
                            {
                                data: "BOBOT",
                                searchable: true,
                                width: "10%"
                            },
                            {
                                data: "KUMPUL_TERDEKAT",
                                searchable: true,
                                width: "20%"
                            },

                        ]
                    });
                },
                error: function(xhr, status, error) {
                    var err = xhr.responseText;
                    alert(err);
                },
                async: false
            });
        }

        function grafik() {
            // Basic Radial Bar Chart
            var options = {
                chart: {
                    height: 290,
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
                series: [rataBeban],
                labels: [labelBeban]

            };

            var chart = new ApexCharts(document.querySelector("#simpleRadialBar"), options);

            chart.render();

        }

        function cekWarna() {
            if (rataBeban < 40) {
                return '#4caf50';
            } else if (rataBeban < 70) {
                return '#ffc107';
            } else {
                return '#f44336';
            }
        }
    </script>
    @endsection
    @section('bottom-js')

    <script src="{{asset('assets/js/form.validation.script.js')}}"></script>
    <script src="{{asset('assets/js/vendor/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/apexcharts.dataseries.js')}}"></script>

    @endsection