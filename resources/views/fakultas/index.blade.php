@extends('layouts.master')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
@endsection

@section('main-content')
<div class="breadcrumb">
    <h1>Fakultas</h1>

</div>
<div class="separator-breadcrumb border-top"></div>

<!-- end of row -->
<div class="row mb-4">
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3">Fakultas</h4>
                <button type="button" class="btn btn-primary ripple m-1" onclick="showModal('InsertFakultas')">Add</button>
                <button type="button" class="btn btn-warning m-1" onclick="showModal('EditFakultas')">Edit</button>
                <button type="button" class="btn btn-danger m-1" onclick="showModalDelete()">Delete</button>
                <br></br>
                <div class="table-responsive">
                    <table id="tblFakultas" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID FAKULTAS</th>
                                <th>NAMA FAKULTAS</th>
                                <th>EMAIL FAKULTAS</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- end of col -->
    @include('fakultas.modal')
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
                type: "GET",
                url: '{{url("api/fakultas")}}',
                data: '',
                contentType: "application/json;charset=utf-8",
                datatype: "json",
                success: function(data) {

                    var oTable = $("#tblFakultas").DataTable({
                        data: data,
                        select: 'single',
                        lengthMenu: [
                            [10, 20],
                            [10, 20]
                        ],
                        //paging: false,                
                        columns: [{
                                data: "ID_FAKULTAS",
                                searchable: true,
                                width: "20%"
                            },
                            {
                                data: "NAMA_FAKULTAS",
                                searchable: true,
                                width: "50%"
                            },
                            {
                                data: "EMAIL_FAKULTAS",
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

        function showModal(mode) {
            $('#formFakultas').removeClass('was-validated');
            $('#formFakultas')[0].reset();

            if (mode == "EditFakultas") {
                var table = $("#tblFakultas").DataTable();
                var rows = table.rows('.selected').indexes();
                if (rows.length > 0) {
                    $('#formFakultas').attr('action', 'javascript:UpdateFakultas();');
                    var data = table.rows(rows).data();
                    $('#titleModalFakultas').html("Edit Fakultas");
                    $('#txtIdFakultas').val(data[0].ID_FAKULTAS);
                    $('#txtIdFakultas').attr("disabled", "disabled");
                    $('#txtNamaFakultas').val(data[0].NAMA_FAKULTAS);
                    $('#txtEmailFakultas').val(data[0].EMAIL_FAKULTAS);

                    $('#modalFakultas').modal('show');
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
                    url: '{{url("api/fakultas/getid")}}',
                    data: '',
                    contentType: "application/json;charset=utf-8",
                    datatype: "json",
                    success: function(data) {
                        $('#txtIdFakultas').val(data.ID);
                    },
                    error: function(xhr, status, error) {
                        var err = xhr.responseText;
                        alert(err);
                    },
                    async: false
                });
                $('#formFakultas').attr('action', 'javascript:InsertFakultas();');
                $('#txtIdFakultas').attr("disabled", "disabled");
                $('#titleModalFakultas').html("Add Fakultas");
                $('#modalFakultas').modal('show');
            }

        }


        function InsertFakultas() {
            var obj = [{
                "ID_FAKULTAS": $('#txtIdFakultas').val(),
                "NAMA_FAKULTAS": $('#txtNamaFakultas').val(),
                "EMAIL_FAKULTAS": $('#txtEmailFakultas').val()
            }];
            var json = JSON.stringify(obj)
            var notSukses = "Insert Fakultas Berhasil !";
            var notGagal = "Insert Fakultas Gagal !";
            var link = '{{url("api/fakultas/add")}}';
            var modal = "#modalFakultas";
            TemplateProses(link, json, notSukses, notGagal, modal);

        }

        function UpdateFakultas() {
            var obj = [{
                "ID_FAKULTAS": $('#txtIdFakultas').val(),
                "NAMA_FAKULTAS": $('#txtNamaFakultas').val(),
                "EMAIL_FAKULTAS": $('#txtEmailFakultas').val()
            }];
            var json = JSON.stringify(obj)
            var notSukses = "Update Fakultas Berhasil !";
            var notGagal = "Update Fakultas Gagal !";
            var link = '{{url("api/fakultas/update")}}';
            var modal = "#modalFakultas";
            TemplateProses(link, json, notSukses, notGagal, modal);

        }

        function DeleteFakultas() {
            var table = $("#tblFakultas").DataTable();
            var rows = table.rows('.selected').indexes();
            var data = table.rows(rows).data();

            var obj = [{
                "ID_FAKULTAS": data[0].ID_FAKULTAS
            }];
            var json = JSON.stringify(obj)


            var notSukses = "Delete Fakultas Berhasil !";
            var notGagal = "Delete Fakultas Gagal !";
            var link = '{{url("api/fakultas/delete")}}';
            var modal = "#modalDeleteFakultas";
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
            $("#tblFakultas").DataTable().destroy();
            loadGrid();
        }

        function showModalDelete() {
            var table = $("#tblFakultas").DataTable();
            var rows = table.rows('.selected').indexes();
            if (rows.length > 0) {
                $('#modalDeleteFakultas').modal('show');
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
    </script>
    @endsection
    @section('bottom-js')

    <script src="{{asset('assets/js/form.validation.script.js')}}"></script>


    @endsection