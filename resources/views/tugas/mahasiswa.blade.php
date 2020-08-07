@extends('layouts.master')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet" />

@endsection

@section('main-content')
<div class="breadcrumb">
    <h1>Kelas</h1>
    <ul>
        <li><a href="#">Tugas</a></li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<!-- end of row -->
<div class="row mb-4">
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3">Tugas [{{$matkul->ID_MATAKULIAH}}] {{$matkul->NAMA_MATAKULIAH}}</h4>

                <br>
                <div class="table-responsive">
                    <table id="tblTugas" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NAMA TUGAS</th>
                                <th>PERSEN (%)</th>
                                <th>WAKTU MULAI</th>
                                <th>WAKTU SELESAI</th>

                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- end of col -->

    @endsection

    @section('page-js')
    <script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables.script.js')}}"></script>
    <script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            loadGrid();
            
        });

        function loadGrid() {
            $.ajax({
                type: 'POST',
                url: '{{url("api/tugas")}}',
                data: '{"idKelas": "{{$idKelas}}"}',
                contentType: "application/json;charset=utf-8",
                datatype: "json",
                success: function(data) {

                    var oTable = $("#tblTugas").DataTable({
                        data: data,
                        select: true,
                        lengthMenu: [
                            [10, 20],
                            [10, 20]
                        ],
                        //paging: false,                
                        columns: [{
                                data: "ID_TUGAS",
                                searchable: true,
                                width: "15%"
                            },
                            {
                                data: "NAMA_TUGAS",
                                searchable: true,
                                width: "25%"
                            },
                            {
                                data: "PERSEN",
                                searchable: true,
                                width: "12%"
                            },
                            {
                                data: "WAKTU_MULAI",
                                searchable: true,
                                width: "18%"
                            },
                            {
                                data: "WAKTU_SELESAI",
                                searchable: true,
                                width: "30%"
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

    </script>
    @endsection
    @section('bottom-js')
    <script src="{{asset('assets/js/form.validation.script.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    @endsection