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
        <li>Add</li>
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
                    <button type="button" class="btn btn-dark ripple m-1" onclick="showModal()">Add Item</button>
                    </div>
                    <div class="col-md-3">
                        <select id="sKategori" class="form-control" required>
                            <option value="">- Filter Kategori CPL -</option>
                            <option value="Rumusan Sikap">Filter : Rumusan Sikap</option>
                            <option value="Rumusan Ketrampilan Umum">Filter : Rumusan Ketrampilan Umum</option>
                            <option value="Rumusan Ketrampilan Khusus">Filter : Rumusan Ketrampilan Khusus</option>
                            <option value="Rumusan Pengetahuan">Filter : Rumusan Pengetahuan</option>
                        </select>
                    </div>
                </div>      
                
               
                <br></br>
                <div class="table-responsive">
                    <table id="tblCpl" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>KD CPL</th>
                                <th>DESKRIPSI</th>
                                <th>KATEGORI</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- end of col -->
    @include('Cpl_matkul.modal')
    @endsection

    @section('page-js')
    <script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables.script.js')}}"></script>
    <script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
    <script type="text/javascript">
        var idmatkul = "{{$matkul->ID_MATAKULIAH}}";
        var oTable;
        $(document).ready(function() {
            loadGrid();
            $( "#sKategori" ).change(function() {
                oTable.draw();
            });
        });

        function loadGrid() {
            $.ajax({
                type: "POST",
                url: '{{url("api/cplmatkul/add/getdata")}}',
                data: '{"idMatkul": "{{$matkul->ID_MATAKULIAH}}"}',
                contentType: "application/json;charset=utf-8",
                datatype: "json",
                success: function(data) {

                     oTable = $("#tblCpl").DataTable({
                        data: data,
                        select: 'single',
                        lengthMenu: [
                            [10, 20],
                            [10, 20]
                        ],

                        columns: [{
                                data: "KD_CPL",
                                searchable: true,
                                width: "15%"
                            },

                            {
                                data: "DESKRIPSI_CPL",
                                searchable: true,
                                width: "65%"
                            },
                            {
                                data: "NAMA_KATEGORI",
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

        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var ddlId = $('#sKategori').val();
                var id = data[2];
                
        
                if ((ddlId == "") || ddlId == id)
                {
                    return true;
                }
                return false;
            }
        );

        function showModal() {
            //Reset Form
            $('#formCpl')[0].reset();
            $('#formCpl').removeClass('was-validated');
            //Reset Form

            var table = $("#tblCpl").DataTable();
            var rows = table.rows('.selected').indexes();
            if (rows.length > 0) {
                $('#formCpl').attr('action', 'javascript:InsertCpl();');
                var data = table.rows(rows).data();
                $('#titleModalCpl').html("Add CPL");

                $.ajax({
                    type: "GET",
                    url: '{{url("api/cplmatkul/getid")}}',
                    data: '',
                    contentType: "application/json;charset=utf-8",
                    datatype: "json",
                    success: function(data) {
                        $('#txtIdCplMatkul').val(data.ID);
                    },
                    error: function(xhr, status, error) {
                        var err = xhr.responseText;
                        alert(err);
                    },
                    async: false
                });
                $('#txtIdCpl').val(data[0].ID_CPL);
                $('#txtDeskripsiCPL').val(data[0].DESKRIPSI_CPL);


                $('#modalCpl').modal('show');
            } else {
                swal({
                    type: 'warning',
                    title: 'Warning',
                    text: 'Data Belum Dipilih !',
                    buttonsStyling: false,
                    confirmButtonClass: 'btn btn-lg btn-warning'
                })
            }



        }

        function InsertCpl() {
            var obj = [{
                "ID_CPL_MATKUL": $('#txtIdCplMatkul').val(),
                "ID_CPL": $('#txtIdCpl').val(),
                "ID_MATAKULIAH": "{{$matkul->ID_MATAKULIAH}}",
                "BOBOT": $('#sBobot option:selected').val()
            }];
            var json = JSON.stringify(obj)

            var link = '{{url("api/cplmatkul/add")}}';

            TemplateProses(link, json);

        }

        function TemplateProses(link, json) {
            $.ajax({
                type: 'POST',
                url: link,
                data: json,
                contentType: "application/json;charset=utf-8",
                datatype: "json",
                success: function(data) {

                    if (data.STATUS == true) {
                        swal({
                            type: 'success',
                            title: 'Success!',
                            text: 'Insert CPL Berhasil !',
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-lg btn-success'
                        }).then(function() {
                            window.location.href = "/cplmatkul/" + idmatkul + "";
                        });
                    }else{
                        swal({
                            type: 'error',
                            title: 'Error',
                            text: 'Insert CPL Gagal !',
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-lg btn-danger'
                        }).then(function() {
                            window.location.href = "/cplmatkul/" + idmatkul + "";
                        });
                    }


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