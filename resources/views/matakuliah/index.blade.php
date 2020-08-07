@extends('layouts.master')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
@endsection

@section('main-content')
<div class="breadcrumb">
    <h1>Matakuliah</h1>

</div>
<div class="separator-breadcrumb border-top"></div>

<!-- end of row -->
<div class="row mb-4">
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3">Matakuliah</h4>
                <button type="button" class="btn btn-primary ripple m-1" onclick="showModal('InsertMatakuliah')">Add</button>
                <button type="button" class="btn btn-warning m-1" onclick="showModal('EditMatakuliah')">Edit</button>
                <button type="button" class="btn btn-danger m-1" onclick="showModalDelete()">Delete</button>
                <br></br>
                <div class="table-responsive">
                    <table id="tblMatakuliah" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID MATAKULIAH</th>
                                <th>NAMA MATAKULIAH</th>
                                <th>SINGKATAN</th>
                                <th>SKS</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- end of col -->
    @include('Matakuliah.modal')
    @endsection

    @section('page-js')
    <script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables.script.js')}}"></script>
    <script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
    <script type="text/javascript">
        var cekId = true;
        var cekSing = true;
        $(document).ready(function() {
            loadGrid();
        });

        function loadGrid() {
            $.ajax({
                type: "GET",
                url: '{{url("api/matkul")}}',
                data: '',
                contentType: "application/json;charset=utf-8",
                datatype: "json",
                success: function(data) {

                    var oTable = $("#tblMatakuliah").DataTable({
                        data: data,
                        select: 'single',
                        lengthMenu: [
                            [10, 20],
                            [10, 20]
                        ],
                        //paging: false,                
                        columns: [{
                                data: "ID_MATAKULIAH",
                                searchable: true,
                                width: "15%"
                            },
                            {
                                data: "NAMA_MATAKULIAH",
                                searchable: true,
                                width: "55%"
                            },
                            {
                                data: "SINGKATAN_MATKUL",
                                searchable: true,
                                width: "15%"
                            },
                            {
                                data: "SKS",
                                searchable: true,
                                width: "15%"
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
            $('#formMatakuliah').removeClass('was-validated');
            $('#formMatakuliah')[0].reset();
            $('#cekIdTrue').hide();
            $('#cekIdFalse').hide();
            $('#cekSingkatanTrue').hide();
            $('#cekSingkatanFalse').hide();


            if (mode == "EditMatakuliah") {
                var table = $("#tblMatakuliah").DataTable();
                var rows = table.rows('.selected').indexes();
                if (rows.length > 0) {
                    $('#formMatakuliah').attr('action', 'javascript:UpdateMatakuliah();');
                    var data = table.rows(rows).data();
                    $('#titleModalMatakuliah').html("Edit Matakuliah");
                    $('#txtIdMatakuliah').val(data[0].ID_MATAKULIAH);
                    $('#txtIdMatakuliah').attr("disabled", "disabled");
                    $('#txtNamaMatakuliah').val(data[0].NAMA_MATAKULIAH);
                    $('#txtSingkatanMatakuliah').val(data[0].SINGKATAN_MATKUL);
                    $('#txtSks').val(data[0].SKS);


                    $('#modalMatakuliah').modal('show');
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

                $('#formMatakuliah').attr('action', 'javascript:InsertMatakuliah();');
                $('#txtIdMatakuliah').removeAttr("disabled", "disabled");
                $('#titleModalMatakuliah').html("Add Matakuliah");
                $('#modalMatakuliah').modal('show');
            }

        }


        function InsertMatakuliah() {
    
            if (cekId == true) {
                if (cekSing == true) {
                    var obj = [{
                        "ID_MATAKULIAH": $('#txtIdMatakuliah').val(),
                        "NAMA_MATAKULIAH": $('#txtNamaMatakuliah').val(),
                        "SINGKATAN_MATKUL": $('#txtSingkatanMatakuliah').val(),
                        "SKS": $('#txtSks').val()
                    }];
                    var json = JSON.stringify(obj)
                    var notSukses = "Insert Matakuliah Berhasil !";
                    var notGagal = "Insert Matakuliah Gagal !";
                    var link = '{{url("api/matkul/add")}}';
                    var modal = "#modalMatakuliah";
                    TemplateProses(link, json, notSukses, notGagal, modal);
                } else {
                    swal({
                        type: 'warning',
                        title: 'Warning',
                        text: 'Singkatan Sudah Tersedia !',
                        buttonsStyling: false,
                        confirmButtonClass: 'btn btn-lg btn-warning'
                    })
                }

            } else {
                swal({
                    type: 'warning',
                    title: 'Warning',
                    text: 'ID Sudah Tersedia !',
                    buttonsStyling: false,
                    confirmButtonClass: 'btn btn-lg btn-warning'
                })
            }
        }

        function UpdateMatakuliah() {
            if (cekSing == true) {
                var obj = [{
                    "ID_MATAKULIAH": $('#txtIdMatakuliah').val(),
                    "NAMA_MATAKULIAH": $('#txtNamaMatakuliah').val(),
                    "SINGKATAN_MATKUL": $('#txtSingkatanMatakuliah').val(),
                    "SKS": $('#txtSks').val()
                }];
                var json = JSON.stringify(obj)
                var notSukses = "Update Matakuliah Berhasil !";
                var notGagal = "Update Matakuliah Gagal !";
                var link = '{{url("api/matkul/update")}}';
                var modal = "#modalMatakuliah";
                TemplateProses(link, json, notSukses, notGagal, modal);
            } else {
                swal({
                    type: 'warning',
                    title: 'Warning',
                    text: 'Singkatan Sudah Tersedia !',
                    buttonsStyling: false,
                    confirmButtonClass: 'btn btn-lg btn-warning'
                })
            }


        }

        function DeleteMatakuliah() {
            var table = $("#tblMatakuliah").DataTable();
            var rows = table.rows('.selected').indexes();
            var data = table.rows(rows).data();

            var obj = [{
                "ID_MATAKULIAH": data[0].ID_MATAKULIAH
            }];
            var json = JSON.stringify(obj)


            var notSukses = "Delete Matakuliah Berhasil !";
            var notGagal = "Delete Matakuliah Gagal !";
            var link = '{{url("api/matkul/delete")}}';
            var modal = "#modalDeleteMatakuliah";
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
            $("#tblMatakuliah").DataTable().destroy();
            loadGrid();
        }

        function showModalDelete() {
            var table = $("#tblMatakuliah").DataTable();
            var rows = table.rows('.selected').indexes();
            if (rows.length > 0) {
                $('#modalDeleteMatakuliah').modal('show');
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

        function CekId(txtId) {
            var dataId = $(txtId).val();

            $.ajax({
                type: 'POST',
                url: '{{url("api/matkul/cekid")}}',
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

        function CekSingkatan(txtSingkatan) {
            var data = $(txtSingkatan).val();
            $.ajax({
                type: 'POST',
                url: '{{url("api/matkul/ceksingkatan")}}',
                data: '{"SINGKATAN": "' + data + '"}',
                contentType: "application/json;charset=utf-8",
                datatype: "json",
                success: function(data) {
                    if (data.STATUS == true) {
                        $('#cekSingkatanTrue').show();
                        $('#cekSingkatanFalse').hide();
                        cekSing = true;
                    } else {
                        $('#cekSingkatanTrue').hide();
                        $('#cekSingkatanFalse').show();
                        cekSing = false;
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