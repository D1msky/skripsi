@extends('layouts.master')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
@endsection

@section('main-content')
<div class="breadcrumb">
    <h1>User</h1>

</div>
<div class="separator-breadcrumb border-top"></div>

<!-- end of row -->
<div class="row mb-4">
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3">User</h4>
                <button type="button" class="btn btn-primary ripple m-1" onclick="showModal('InsertUser')">Add</button>
                <button type="button" class="btn btn-warning m-1" onclick="showModal('EditUser')">Edit</button>
                <button type="button" class="btn btn-danger m-1" onclick="showModalDelete()">Delete</button>
                <br></br>
                <div class="table-responsive">
                    <table id="tblUser" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NAMA</th>
                                <th>JENIS KELAMIN</th>
                                <th>STATUS</th>
                                <th>PRODI</th>

                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- end of col -->
    @include('user.modal')
    @endsection

    @section('page-js')
    <script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables.script.js')}}"></script>
    <script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
    <script type="text/javascript">
        var cekId = true;
        var boolSelect = true;
       
        $(document).ready(function() {
            loadGrid();
        });

        function loadGrid() {
            $.ajax({
                type: "GET",
                url: '{{url("api/user")}}',
                data: '',
                contentType: "application/json;charset=utf-8",
                datatype: "json",
                success: function(data) {

                    var oTable = $("#tblUser").DataTable({
                        data: data,
                        select: 'single',
                        lengthMenu: [
                            [10, 20],
                            [10, 20]
                        ],
                        //paging: false,                
                        columns: [{
                                data: "ID_USER",
                                searchable: true,
                                width: "15%"
                            },
                            {
                                data: "NAMA",
                                searchable: true,
                                width: "25%"
                            },
                            {
                                data: "JENIS_KELAMIN",
                                searchable: true,
                                width: "12%"
                            },
                            {
                                data: "NAMA_STATUS",
                                searchable: true,
                                width: "18%"
                            },
                            {
                                data: "NAMA_PRODI",
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
            //Reset Form
            $('#formUser')[0].reset();
            $('#formUser').removeClass('was-validated');
            $('#cekIdTrue').hide();
            $('#cekIdFalse').hide();
            //Reset Form
            if (boolSelect == true) {

                $.ajax({
                    type: "GET",
                    url: '{{url("api/status")}}',
                    data: '',
                    contentType: "application/json;charset=utf-8",
                    datatype: "json",
                    success: function(data) {
                        $.each(data, function(index, value) {
                            $('#sStatus').append($('<option>').text(value.NAMA_STATUS).attr('value', value.ID_STATUS));
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



            if (mode == "EditUser") {
                var table = $("#tblUser").DataTable();
                var rows = table.rows('.selected').indexes();
                if (rows.length > 0) {
                    $('#formUser').attr('action', 'javascript:UpdateUser();');
                    var data = table.rows(rows).data();
                    $('#titleModalUser').html("Edit User");
                    $('#txtIdUser').val(data[0].ID_USER);
                    $('#txtIdUser').attr("disabled", "disabled");
                    $('#txtPassword').val(data[0].PASSWORD);
             
                    $('#txtNama').val(data[0].NAMA);
                    $('#sJenisKelamin').val(data[0].JENIS_KELAMIN);
                    $('#sStatus').val(data[0].ID_STATUS);
                    $('#sProdi').val(data[0].ID_PRODI);

                    $('#modalUser').modal('show');
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
                $('#formUser').attr('action', 'javascript:InsertUser();');
                $('#txtIdUser').removeAttr("disabled", "disabled");
                $('#titleModalUser').html("Add User");
                $('#modalUser').modal('show');
            }


        }

        function InsertUser() {

            if (cekId == true) {
                var obj = [{
                    "ID_USER": $('#txtIdUser').val(),
                    "NAMA": $('#txtNama').val(),
                    "PASSWORD": $('#txtPassword').val(),
                    "JENIS_KELAMIN": $('#sJenisKelamin option:selected').val(),
                    "ID_STATUS": $('#sStatus option:selected').val(),
                    "ID_PRODI": $('#sProdi option:selected').val()
                }];
                var json = JSON.stringify(obj)
                var notSukses = "Insert User Berhasil !";
                var notGagal = "Insert User Gagal !";
                var link = '{{url("api/user/add")}}';
                var modal = "#modalUser";
                TemplateProses(link, json, notSukses, notGagal, modal);
            } else {
                swal({
                    type: 'error',
                    title: 'Error!',
                    text: 'ID User Tidak Tersedia !',
                    confirmButtonText: 'Dismiss',
                    buttonsStyling: false,
                    confirmButtonClass: 'btn btn-lg btn-danger'
                })
            }

        }

        function UpdateUser() {

            var obj = [{
                "ID_USER": $('#txtIdUser').val(),
                "NAMA": $('#txtNama').val(),
                "PASSWORD": $('#txtPassword').val(),
                "JENIS_KELAMIN": $('#sJenisKelamin option:selected').val(),
                "ID_STATUS": $('#sStatus option:selected').val(),
                "ID_PRODI": $('#sProdi option:selected').val()
            }];


            var json = JSON.stringify(obj)
            var notSukses = "Update User Berhasil !";
            var notGagal = "Update User Gagal !";
            var link = '{{url("api/user/update")}}';
            var modal = "#modalUser";
            TemplateProses(link, json, notSukses, notGagal, modal);

        }

        function showModalDelete() {
            var table = $("#tblUser").DataTable();
            var rows = table.rows('.selected').indexes();
            if (rows.length > 0) {
                $('#modalDeleteUser').modal('show');
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

        function DeleteUser() {
            var table = $("#tblUser").DataTable();
            var rows = table.rows('.selected').indexes();
            var data = table.rows(rows).data();

            var obj = [{
                "ID_USER": data[0].ID_USER
            }];
            var json = JSON.stringify(obj)


            var notSukses = "Delete User Berhasil !";
            var notGagal = "Delete User Gagal !";
            var link = '{{url("api/user/delete")}}';
            var modal = "#modalDeleteUser";
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
            $("#tblUser").DataTable().destroy();
            loadGrid();
        }

        function CekId(txtId) {
            var dataId = $(txtId).val();

            $.ajax({
                type: 'POST',
                url: '{{url("api/user/cekid")}}',
                data: '{"ID": "' + dataId + '"}',
                contentType: "application/json;charset=utf-8",
                datatype: "json",
                success: function(data) {
                    if (data.STATUS == true) {
                        $('#cekIdTrue').show();
                        $('#cekIdFalse').hide();
                        cekId = true;
                    } else {
                        $('#cekIdTrue').hide();
                        $('#cekIdFalse').show();
                        cekId = false;
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