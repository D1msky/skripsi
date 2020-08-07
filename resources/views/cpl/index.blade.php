@extends('layouts.master')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
@endsection

@section('main-content')
<div class="breadcrumb">
    <h1>CPL</h1>

</div>
<div class="separator-breadcrumb border-top"></div>

<!-- end of row -->
<div class="row mb-4">
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3">CPL</h4>
                <button type="button" class="btn btn-primary ripple m-1" onclick="showModal('InsertCPL')">Add</button>
                <button type="button" class="btn btn-warning m-1" onclick="showModal('EditCPL')">Edit</button>
                <button type="button" class="btn btn-danger m-1" onclick="showModalDelete()">Delete</button>
                <br></br>
                <div class="table-responsive">
                    <table id="tblCPL" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID CPL</th>
                                <th>KD CPL</th>
                                <th>PRODI</th>
                                <th>DESKRIPSI CPL</th>
                                <th>KATEGORI CPL</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- end of col -->
    @include('cpl.modal')
    @endsection

    @section('page-js')
    <script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables.script.js')}}"></script>
    <script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
    <script type="text/javascript">
        var boolSelect = true;
        $(document).ready(function() {
            loadGrid();
        });

        function loadGrid() {
            $.ajax({
                type: "GET",
                url: '{{url("api/cpl")}}',
                data: '',
                contentType: "application/json;charset=utf-8",
                datatype: "json",
                success: function(data) {

                    var oTable = $("#tblCPL").DataTable({
                        data: data,
                        select: 'single',
                        lengthMenu: [
                            [10, 20],
                            [10, 20]
                        ],
                        //pagingType : "simple",
                        columns: [{
                                data: "ID_CPL",
                                searchable: true,
                                width: "15%"
                            },
                            {
                                data: "KD_CPL",
                                searchable: true,
                                width: "10%"
                            },
                            {
                                data: "NAMA_PRODI",
                                searchable: true,
                                width: "15%"
                            },
                            {
                                data: "DESKRIPSI_CPL",
                                searchable: true,
                                width: "40%"
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

        function showModal(mode) {
            //Reset Form
            $('#formCPL')[0].reset();
            $('#formCPL').removeClass('was-validated');
            $('#cekIdTrue').hide();
            $('#cekIdFalse').hide();
            //Reset Form
            if (boolSelect == true) {

                $.ajax({
                    type: "GET",
                    url: '{{url("api/katcpl")}}',
                    data: '',
                    contentType: "application/json;charset=utf-8",
                    datatype: "json",
                    success: function(data) {
                        $.each(data, function(index, value) {
                            $('#sKatCpl').append($('<option>').text(value.NAMA_KATEGORI).attr('value', value.ID_KATEGORI_CPL));
                        });
                    },
                    error: function(xhr, status, error) {
                        var err = xhr.responseText;
                        alert(err);
                    },
                    async: false
                });

                $.ajax({
                    type: "GET",
                    url: '{{url("api/prodi")}}',
                    data: '',
                    contentType: "application/json;charset=utf-8",
                    datatype: "json",
                    success: function(data) {
                        $.each(data, function(index, value) {
                            $('#sProdi').append($('<option>').text(value.NAMA_PRODI).attr('value', value.ID_PRODI));
                        });
                    },
                    error: function(xhr, status, error) {
                        var err = xhr.responseText;
                        alert(err);
                    },
                    async: false
                });
                boolSelect = false;
            }



            if (mode == "EditCPL") {
                var table = $("#tblCPL").DataTable();
                var rows = table.rows('.selected').indexes();
                if (rows.length > 0) {
                    $('#formCPL').attr('action', 'javascript:UpdateCPL();');
                    var data = table.rows(rows).data();
                    $('#titleModalCPL').html("Edit CPL");
                    $('#txtIdCPL').val(data[0].ID_CPL);
                    $('#txtKdCPL').val(data[0].KD_CPL);
                    $('#sProdi').val(data[0].ID_PRODI);
                    $('#txtDeskripsiCPL').val(data[0].DESKRIPSI_CPL);
                    $('#sKatCpl').val(data[0].ID_KATEGORI_CPL);

                    $('#modalCPL').modal('show');
                } else {
                    swal({
                        type: 'warning',
                        title: 'Warning',
                        text: 'Data Belum Dipilih !',
                        buttonsStyling: false,
                        confirmButtonClass: 'btn btn-lg btn-warning'
                    })
                }

            } else {
                $.ajax({
                    type: "GET",
                    url: '{{url("api/cpl/getid")}}',
                    data: '',
                    contentType: "application/json;charset=utf-8",
                    datatype: "json",
                    success: function(data) {
                        $('#txtIdCPL').val(data.ID);
                    },
                    error: function(xhr, status, error) {
                        var err = xhr.responseText;
                        alert(err);
                    },
                    async: false
                });

                $('#formCPL').attr('action', 'javascript:InsertCPL();');
            
                $('#titleModalCPL').html("Add CPL");
                $('#modalCPL').modal('show');
            }


        }

        function InsertCPL() {
            var obj = [{
                "ID_CPL": $('#txtIdCPL').val(),
                "KD_CPL" : $('#txtKdCPL').val(),
                "ID_PRODI" : $('#sProdi option:selected').val(),
                "DESKRIPSI_CPL": $('#txtDeskripsiCPL').val(),
                "ID_KATEGORI_CPL": $('#sKatCpl option:selected').val(),
            }];
            var json = JSON.stringify(obj)
            var notSukses = "Insert CPL Berhasil !";
            var notGagal = "Insert CPL Gagal !";
            var link = '{{url("api/cpl/add")}}';
            var modal = "#modalCPL";
            TemplateProses(link, json, notSukses, notGagal, modal);

        }

        function UpdateCPL() {
            var obj = [{
                "ID_CPL": $('#txtIdCPL').val(),
                "KD_CPL" : $('#txtKdCPL').val(),
                "ID_PRODI" : $('#sProdi option:selected').val(),
                "DESKRIPSI_CPL": $('#txtDeskripsiCPL').val(),
                "ID_KATEGORI_CPL": $('#sKatCpl option:selected').val(),
            }];
            var json = JSON.stringify(obj)
            var notSukses = "Update CPL Berhasil !";
            var notGagal = "Update CPL Gagal !";
            var link = '{{url("api/cpl/update")}}';
            var modal = "#modalCPL";
            TemplateProses(link, json, notSukses, notGagal, modal);

        }

        function showModalDelete() {
            var table = $("#tblCPL").DataTable();
            var rows = table.rows('.selected').indexes();
            if (rows.length > 0) {
                $('#modalDeleteCPL').modal('show');
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

        function DeleteCPL() {
            var table = $("#tblCPL").DataTable();
            var rows = table.rows('.selected').indexes();
            var data = table.rows(rows).data();

            var obj = [{
                "ID_CPL": data[0].ID_CPL
            }];
            var json = JSON.stringify(obj)


            var notSukses = "Delete CPL Berhasil !";
            var notGagal = "Delete CPL Gagal !";
            var link = '{{url("api/cpl/delete")}}';
            var modal = "#modalDeleteCPL";
            TemplateProses(link, json, notSukses, notGagal, modal);
        }

        function TemplateProses(link, json, notSukses, notGagal, modal) {
            $.ajax({
                type: 'POST',
                url: link,
                data: json,
                contentType: "application/json;charset=utf-8",
                datatype: "json",
                success: function(data) {

                    if (data.STATUS == true) {
                        ShowNotification(notSukses, true);
                    } else {
                        ShowNotification(notGagal, false);
                    }
                    $(modal).modal('toggle');
                    repeatTable();

                },
                error: function(xhr, status, error) {
                    var err = xhr.responseText;
                    alert(err);
                },
                async: false
            });
        }

        function repeatTable() {
            $("#tblCPL").DataTable().destroy();
            loadGrid();
        }
    </script>
    @endsection
    @section('bottom-js')
    <script src="{{asset('assets/js/form.validation.script.js')}}"></script>
    @endsection