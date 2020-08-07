@extends('layouts.master')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/css/bootstrap-select.min.css')}}">
@endsection

@section('main-content')
<div class="breadcrumb">
    <h1>Kelas</h1>
    <ul>
        <li><a href="#">Add Mahasiswa</a></li>
    </ul>

</div>
<div class="separator-breadcrumb border-top"></div>

<!-- end of row -->
<div class="row mb-4">
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3">Add Mahasiswa</h4>
                <button type="button" class="btn btn-primary ripple m-1" onclick="showModal('InsertKlsUser')">Add</button>
                <button type="button" class="btn btn-warning m-1" onclick="showModal('EditKlsUser')">Edit</button>
                <button type="button" class="btn btn-danger m-1" onclick="showModalDelete()">Delete</button>
                <br></br>
                <div class="table-responsive">
                    <table id="tblKlsUser" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ID KELAS</th>
                                <th>ID USER</th>
                                <th>NAMA</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- end of col -->
    @include('kelas_user.modal')
    @endsection

    @section('page-js')
    <script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables.script.js')}}"></script>
    <script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>

    <script type="text/javascript">
        var arrSel = [];
        $(document).ready(function() {
            loadGrid();

        });

        function loadGrid() {
            $.ajax({
                type: 'POST',
                url: '{{url("api/klsuser/getdata")}}',
                data: '{"idKelas": "{{$idKelas}}"}',
                contentType: "application/json;charset=utf-8",
                datatype: "json",
                success: function(data) {
                    var oTable = $("#tblKlsUser").DataTable({
                        data: data,
                        select: 'single',
                        lengthMenu: [
                            [10, 20],
                            [10, 20]
                        ],
                        //paging: false,                
                        columns: [{
                                data: "ID_KELAS_USER",
                                searchable: true,
                                width: "15%"
                            },
                            {
                                data: "ID_KELAS",
                                searchable: true,
                                width: "25%"
                            },
                            {
                                data: "ID_USER",
                                searchable: true,
                                width: "12%"
                            },
                            {
                                data: "NAMA",
                                searchable: true,
                                width: "18%"
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
            $('#formKlsUser')[0].reset();
            $('#formKlsUser').removeClass('was-validated');
            removeSel();
            $('#sMahasiswa').selectpicker('refresh');
            //Reset Form

            $.ajax({
                type: "POST",
                url: '{{url("api/user/getmhs")}}',
                data: '{"idKelas": "{{$idKelas}}"}',
                contentType: "application/json;charset=utf-8",
                datatype: "json",
                success: function(data) {
                    $.each(data, function(index, value) {
                        arrSel[index] = value.ID_USER;
                        $('#sMahasiswa').append($('<option data-tokens="' + value.ID_USER + value.NAMA + '" value="' + value.ID_USER + '">').text(value.ID_USER + "|" + value.NAMA));
                    });
                },
                error: function(xhr, status, error) {
                    var err = xhr.responseText;
                    alert(err);
                },
                async: false
            });

            $('#sMahasiswa').selectpicker('refresh');

            if (mode == "EditKlsUser") {
                var table = $("#tblKlsUser").DataTable();
                var rows = table.rows('.selected').indexes();
                if (rows.length > 0) {
                    $('#formKlsUser').attr('action', 'javascript:UpdateKlsUser();');
                    var data = table.rows(rows).data();
                    $('#titleModalUser').html("Edit Mahasiswa");
                    $('#txtIdKlsUser').val(data[0].ID_KELAS_USER);
                    $('#sMahasiswa').append($('<option data-tokens="' + data[0].ID_USER + data[0].NAMA + '" value="' + data[0].ID_USER + '">').text(data[0].ID_USER + "|" + data[0].NAMA));
                    $('#sMahasiswa').selectpicker('refresh');
                    $('#sMahasiswa').val(data[0].ID_USER);
                    $('#sMahasiswa').selectpicker('refresh');

                    //Tambah Data Baru di RemoveSel
                    var count = arrSel.length;
                    arrSel[count] = data[0].ID_USER;

                    $('#modalKlsUser').modal('show');
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
                    url: '{{url("api/klsuser/getid")}}',
                    data: '',
                    contentType: "application/json;charset=utf-8",
                    datatype: "json",
                    success: function(data) {
                        $('#txtIdKlsUser').val(data.ID);
                    },
                    error: function(xhr, status, error) {
                        var err = xhr.responseText;
                        alert(err);
                    },
                    async: false
                });

                $('#formKlsUser').attr('action', 'javascript:InsertKlsUser();');

                $('#titleModalKlsUser').html("Add Mahasiswa");
                $('#modalKlsUser').modal('show');
            }


        }

        function removeSel() {
            for (var i = 0; i < arrSel.length; i++) {
                $('#sMahasiswa').find('[value=' + arrSel[i] + ']').remove();
            }
        }

        function InsertKlsUser() {
            var obj = [{
                "ID_KELAS_USER": $('#txtIdKlsUser').val(),
                "ID_USER": $('#sMahasiswa option:selected').val(),
                "ID_KELAS": "{{$idKelas}}"
            }];
            var json = JSON.stringify(obj)
            var notSukses = "Insert Mahasiswa Berhasil !";
            var notGagal = "Insert Mahasiswa Gagal !";
            var link = '{{url("api/klsuser/add")}}';
            var modal = "#modalKlsUser";
            TemplateProses(link, json, notSukses, notGagal, modal);

        }

        function UpdateKlsUser() {
            var obj = [{
                "ID_KELAS_USER": $('#txtIdKlsUser').val(),
                "ID_USER": $('#sMahasiswa option:selected').val(),
                "ID_KELAS": "{{$idKelas}}"
            }];
            var json = JSON.stringify(obj)
            var notSukses = "Update Mahasiswa Berhasil !";
            var notGagal = "Update Mahasiswa Gagal !";
            var link = '{{url("api/klsuser/update")}}';
            var modal = "#modalKlsUser";
            TemplateProses(link, json, notSukses, notGagal, modal);

        }

        function showModalDelete() {
            var table = $("#tblKlsUser").DataTable();
            var rows = table.rows('.selected').indexes();
            if (rows.length > 0) {
                $('#modalDeleteKlsUser').modal('show');
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

        function DeleteKlsUser() {
            var table = $("#tblKlsUser").DataTable();
            var rows = table.rows('.selected').indexes();
            var data = table.rows(rows).data();

            var obj = [{
                "ID_KELAS_USER": data[0].ID_KELAS_USER
            }];
            var json = JSON.stringify(obj)

            var notSukses = "Delete Mahasiswa Berhasil !";
            var notGagal = "Delete Mahasiswa Gagal !";
            var link = '{{url("api/klsuser/delete")}}';
            var modal = "#modalDeleteKlsUser";
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
                        //Refresh Mahasiswa
                        removeSel();
                        $('#sMahasiswa').selectpicker('refresh');
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
            $("#tblKlsUser").DataTable().destroy();
            loadGrid();
        }
    </script>
    @endsection
    @section('bottom-js')
    <script src="{{asset('assets/js/form.validation.script.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-select.min.js')}}"></script>

    @endsection