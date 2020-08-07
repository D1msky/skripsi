@extends('layouts.master')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
@endsection

@section('main-content')
<div class="breadcrumb">
    <h1>Matakuliah</h1>
    <ul>
        <li><a href="#">CPL</a></li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<!-- end of row -->
<div class="row mb-4">
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3">CPL [{{$matkul->NAMA_MATAKULIAH}}]</h4>
                <div class="row">
                    <div class="col-md-9">
                      
                    </div>
                    <div class="col-md-3">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 id="rataBobot" class="text-center mb-0" ></h5>
                            </div>
                        </div>
                    </div>
                </div>


             
                <div class="table-responsive">
                    <table id="tblCpl" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID CPL MATKUL</th>
                                <th>ID CPL</th>
                                <th>DESKRIPSI</th>
                                <th>NILAI</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- end of col -->
    @include('cpl_matkul.modal')

    @endsection

    @section('page-js')
    <script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables.script.js')}}"></script>
    <script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
    <script type="text/javascript">
        var totalBobot;
        $(document).ready(function() {
            loadGrid();
        });

        function loadGrid() {
            $.ajax({
                type: 'POST',
                url: '{{url("api/cplmatkul")}}',
                data: '{"idMatkul": "{{$matkul->ID_MATAKULIAH}}"}',
                contentType: "application/json;charset=utf-8",
                datatype: "json",
                success: function(data) {
                    totalBobot = 0;
                    for (var i = 0; i < data.length; i++) {
                        totalBobot += data[i].BOBOT;
                    }
                    var rataBobot;
                    if(data.length > 0){
                        rataBobot = totalBobot / data.length;
                        rataBobot = (Math.round(rataBobot * 100) / 100).toFixed(2);
                    }else{
                        rataBobot = 0;
                    }
                    
                    $('#rataBobot').text('RATA2 NILAI : '+ rataBobot +'');
                    var oTable = $("#tblCpl").DataTable({
                        data: data,
                        select: 'single',
                        lengthMenu: [
                            [10, 20],
                            [10, 20]
                        ],
                        columns: [{
                                data: "ID_CPL_MATKUL",
                                searchable: true,
                                width: "15%"
                            },
                            {
                                data: "ID_CPL",
                                searchable: true,
                                width: "15%"
                            },
                            {
                                data: "DESKRIPSI_CPL",
                                searchable: true,
                                width: "65%"
                            },
                            {
                                data: "BOBOT",
                                searchable: true,
                                width: "5%"
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


    @endsection