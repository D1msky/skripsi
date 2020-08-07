@extends('layouts.master')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/css/bootstrap-select.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/css/bootstrap-datepicker.min.css')}}">
@endsection

@section('main-content')
<div class="breadcrumb">
    <h1>Kelas</h1>

</div>
<div class="separator-breadcrumb border-top"></div>

<!-- end of row -->
<div class="row mb-4">
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3">Kelas</h4>
                <button type="button" class="btn btn-primary ripple m-1" onclick="showModal('InsertKelas')">Add</button>
                <button type="button" class="btn btn-warning m-1" onclick="showModal('EditKelas')">Edit</button>
                <button type="button" class="btn btn-danger m-1" onclick="showModalDelete()">Delete</button>
                <br></br>
                <div class="table-responsive">
                    <table id="tblKelas" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID KELAS</th>
                                <th>ID MATKUL</th>
                                <th>DOSEN 1</th>
                                <th>DOSEN 2</th>
                                <th>DOSEN 3</th>
                                <th>GROUP</th>
                                <th>SEMESTER</th>
                                <th>THN AJARAN</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- end of col -->
    @include('kelas.modal')
    @endsection

    @section('page-js')
    <script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables.script.js')}}"></script>
    <script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript">
        var boolSelect = true;
        var idMatkul;
        var grup;
        var cekKelas = false;
        $(document).ready(function() {
            loadGrid();

        });

        function loadGrid() {
            $.ajax({
                type: "GET",
                url: '{{url("api/kelas")}}',
                data: '',
                contentType: "application/json;charset=utf-8",
                datatype: "json",
                success: function(data) {
                    var oTable = $("#tblKelas").DataTable({
                        data: data,
                        select: 'single',
                        lengthMenu: [
                            [10, 20],
                            [10, 20]
                        ],
                        columns: [{
                                data: "ID_KELAS",
                                searchable: true,
                                width: "15%"
                            },
                            {
                                data: "ID_MATAKULIAH",
                                searchable: true,
                                width: "10%"
                            },
                            {
                                data: "DOSEN1",
                                searchable: true,
                                width: "15%"
                            },
                            {
                                data: "DOSEN2",
                                searchable: true,
                                width: "13%"
                            },
                            {
                                data: "DOSEN3",
                                searchable: true,
                                width: "12%"
                            },

                            {
                                data: "GRUP",
                                searchable: true,
                                width: "10%"
                            },
                            {
                                data: "SEMESTER",
                                searchable: true,
                                width: "10%"
                            },
                            {
                                data: "THN_AJARAN",
                                searchable: true,
                                width: "15%"
                            },
                            {
                                data: null,
                                render: function(data, type, row) {
                                    return '<a href="/klsuser/' + data.ID_KELAS + '" class="btn btn-dark m-1"><span class="ul-btn__icon"><i class="i-Add-User"></i></span></a>';

                                },
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

        function showModal(mode) {

            $('#formKelas').removeClass('was-validated');
            $('#formKelas')[0].reset();


            if (boolSelect == true) {
                $.ajax({
                    type: "GET",
                    url: '{{url("api/matkul")}}',
                    data: '',
                    contentType: "application/json;charset=utf-8",
                    datatype: "json",
                    success: function(data) {

                        $.each(data, function(index, value) {
                            $('#sMatakuliah').append($('<option data-tokens="' + value.ID_MATAKULIAH + value.NAMA_MATAKULIAH + '" value="' + value.ID_MATAKULIAH + '">').text(value.ID_MATAKULIAH+"|"+value.NAMA_MATAKULIAH));
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
                    url: '{{url("api/user/getdosen")}}',
                    data: '',
                    contentType: "application/json;charset=utf-8",
                    datatype: "json",
                    success: function(data) {

                        $.each(data, function(index, value) {

                            $('#sDosen').append($('<option data-tokens="'+ value.ID_USER + value.NAMA + '" value="' + value.ID_USER + '">').text(value.ID_USER+"|"+value.NAMA));
                            $('#sDosen2').append($('<option data-tokens="'+ value.ID_USER + value.NAMA + '" value="' + value.ID_USER + '">').text(value.ID_USER+"|"+value.NAMA));
                            $('#sDosen3').append($('<option data-tokens="'+ value.ID_USER + value.NAMA + '" value="' + value.ID_USER + '">').text(value.ID_USER+"|"+value.NAMA));
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
                    url: '{{url("api/kelas/getthnajaran")}}',
                    data: '',
                    contentType: "application/json;charset=utf-8",
                    datatype: "json",
                    success: function(data) {
                        $.each(data, function(index, value) {

                            $('#sThnAjaran').append($('<option value="' + value + '">').text(value));
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


            $('.selectpicker').selectpicker('refresh');
            if (mode == "EditKelas") {
                var table = $("#tblKelas").DataTable();
                var rows = table.rows('.selected').indexes();
                if (rows.length > 0) {
                    $('#formKelas').attr('action', 'javascript:UpdateKelas();');
                    var data = table.rows(rows).data();
                    $('#titleModalKelas').html("Edit Kelas");
                    $('#txtIdKelas').val(data[0].ID_KELAS);
                    $('#txtIdKelas').attr("disabled", "disabled");
                    $('#sMatakuliah').val(data[0].ID_MATAKULIAH);
                    $('#sDosen').val(data[0].ID_USER);
                    $('#sDosen2').val(data[0].ID_USER1);
                    $('#sDosen3').val(data[0].ID_USER2);
                    $('#sGroup').val(data[0].GRUP);
                    $('#sSemester').val(data[0].SEMESTER);
                    $('#sThnAjaran').val(data[0].THN_AJARAN);
                    idMatkul = data[0].ID_MATAKULIAH;
                    grup = data[0].GRUP;
                    $('.selectpicker').selectpicker('refresh');
                    $('#modalKelas').modal('show');
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
                    url: '{{url("api/kelas/getid")}}',
                    data: '',
                    contentType: "application/json;charset=utf-8",
                    datatype: "json",
                    success: function(data) {
                        $('#txtIdKelas').val(data.ID);
                    },
                    error: function(xhr, status, error) {
                        var err = xhr.responseText;
                        alert(err);
                    },
                    async: false
                });


                $('#formKelas').attr('action', 'javascript:InsertKelas();');
                $('#txtIdKelas').attr("disabled", "disabled");
                $('#titleModalKelas').html("Add Kelas");

                $('#modalKelas').modal('show');
            }


        }


        function InsertKelas() {
            checkKelas();
            if (cekKelas) {
                var obj = [{
                    "ID_KELAS": $('#txtIdKelas').val(),
                    "ID_MATAKULIAH": $('#sMatakuliah option:selected').val(),
                    "ID_DOSEN": $('#sDosen option:selected').val(),
                    "ID_DOSEN2": $('#sDosen2 option:selected').val(),
                    "ID_DOSEN3": $('#sDosen3 option:selected').val(),
                    "GROUP": $('#sGroup option:selected').val(),
                    "SEMESTER": $('#sSemester option:selected').val(),
                    "THN_AJARAN": $('#sThnAjaran option:selected').val()
                }];

                var json = JSON.stringify(obj);

                var notSukses = "Insert Kelas Berhasil !";
                var notGagal = "Insert Kelas Gagal !";
                var link = '{{url("api/kelas/add")}}';
                var modal = "#modalKelas";
                if (($('#sDosen2 option:selected').val() == "") && ($('#sDosen3 option:selected').val() == "")) {
                    TemplateProses(link, json, notSukses, notGagal, modal);
                } else {
                    if (($('#sDosen option:selected').val() != $('#sDosen2 option:selected').val()) && ($('#sDosen option:selected').val() != $('#sDosen3 option:selected').val()) && ($('#sDosen2 option:selected').val() != $('#sDosen3 option:selected').val())) {
                        TemplateProses(link, json, notSukses, notGagal, modal);
                    } else {
                        swal({
                            type: 'warning',
                            title: 'Warning',
                            text: 'Dosen Tidak Boleh Sama !',
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-lg btn-warning'
                        })
                    }
                }


            } else {
                swal({
                    type: 'warning',
                    title: 'Warning',
                    text: 'Kelas Telah Tersedia !',
                    buttonsStyling: false,
                    confirmButtonClass: 'btn btn-lg btn-warning'
                })
            }


        }

        function UpdateKelas() {
           
            var obj = [{
                "ID_KELAS": $('#txtIdKelas').val(),
                "ID_MATAKULIAH": $('#sMatakuliah option:selected').val(),
                "ID_DOSEN": $('#sDosen option:selected').val(),
                "ID_DOSEN2": $('#sDosen2 option:selected').val(),
                "ID_DOSEN3": $('#sDosen3 option:selected').val(),
                "GROUP": $('#sGroup option:selected').val(),
                "SEMESTER": $('#sSemester option:selected').val(),
                "THN_AJARAN": $('#sThnAjaran option:selected').val()
            }];
            var json = JSON.stringify(obj);
            var notSukses = "Update Kelas Berhasil !";
            var notGagal = "Update Kelas Gagal !";
            var link = '{{url("api/kelas/update")}}';
            var modal = "#modalKelas";



            if ((idMatkul == $('#sMatakuliah option:selected').val()) && (grup == $('#sGroup option:selected').val())) {

                if (($('#sDosen2 option:selected').val() == "") && ($('#sDosen3 option:selected').val() == "")) { //Cek Dosen Kembar
                
                    TemplateProses(link, json, notSukses, notGagal, modal);
                } else {
                    if (($('#sDosen option:selected').val() != $('#sDosen2 option:selected').val()) && ($('#sDosen option:selected').val() != $('#sDosen3 option:selected').val()) && ($('#sDosen2 option:selected').val() != $('#sDosen3 option:selected').val())) {
                        
                        TemplateProses(link, json, notSukses, notGagal, modal);
                    } else {
                        swal({
                            type: 'warning',
                            title: 'Warning',
                            text: 'Dosen Tidak Boleh Sama !',
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-lg btn-warning'
                        })
                    }
                }
            } else {
                checkKelas();
                if (cekKelas) {
                    if (($('#sDosen2 option:selected').val() == "") || ($('#sDosen3 option:selected').val() == "")) { //Cek Dosen Kembar
                        TemplateProses(link, json, notSukses, notGagal, modal);
                    } else {
                        if (($('#sDosen option:selected').val() != $('#sDosen2 option:selected').val()) && ($('#sDosen option:selected').val() != $('#sDosen3 option:selected').val()) && ($('#sDosen2 option:selected').val() != $('#sDosen3 option:selected').val())) {
                            TemplateProses(link, json, notSukses, notGagal, modal);
                        } else {
                            swal({
                                type: 'warning',
                                title: 'Warning',
                                text: 'Dosen Tidak Boleh Sama !',
                                buttonsStyling: false,
                                confirmButtonClass: 'btn btn-lg btn-warning'
                            })
                        }
                    }
                } else {
                    swal({
                        type: 'warning',
                        title: 'Warning',
                        text: 'Kelas Telah Tersedia !',
                        buttonsStyling: false,
                        confirmButtonClass: 'btn btn-lg btn-warning'
                    })
                }
            }


        }

        function DeleteKelas() {
            var table = $("#tblKelas").DataTable();
            var rows = table.rows('.selected').indexes();
            var data = table.rows(rows).data();

            var obj = [{
                "ID_KELAS": data[0].ID_KELAS
            }];
            var json = JSON.stringify(obj)


            var notSukses = "Delete Kelas Berhasil !";
            var notGagal = "Delete Kelas Gagal !";
            var link = '{{url("api/kelas/delete")}}';
            var modal = "#modalDeleteKelas";
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
            $("#tblKelas").DataTable().destroy();
            loadGrid();
        }

        function showModalDelete() {
            var table = $("#tblKelas").DataTable();
            var rows = table.rows('.selected').indexes();
            if (rows.length > 0) {
                $('#modalDeleteKelas').modal('show');
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

        function checkKelas() {
            var cekIdMatkul = $('#sMatakuliah option:selected').val();
            var cekGrup = $('#sGroup option:selected').val();

            $.ajax({
                type: 'POST',
                url: '{{url("api/kelas/cekkelas")}}',
                data: '{"ID_MATKUL": "' + cekIdMatkul + '","GRUP" : "' + cekGrup + '"}',
                contentType: "application/json;charset=utf-8",
                datatype: "json",
                success: function(data) {
                    if (data.STATUS == true) {
                        cekKelas = true;
                    } else {
                        cekKelas = false;
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
    <script src="{{asset('assets/js/bootstrap-select.min.js')}}"></script>

    @endsection