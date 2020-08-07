@extends('layouts.master')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
@endsection

@section('main-content')
<div class="breadcrumb">
    <h1>Prodi</h1>

</div>
<div class="separator-breadcrumb border-top"></div>

<!-- end of row -->
<div class="row mb-4">
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3">Prodi</h4>
                <button type="button" class="btn btn-primary ripple m-1" onclick="showModal('InsertProdi')">Add</button>
                <button type="button" class="btn btn-warning m-1" onclick="showModal('EditProdi')">Edit</button>
                <button type="button" class="btn btn-danger m-1" onclick="showModalDelete()">Delete</button>
                <br></br>
                <div class="table-responsive">
                    <table id="tblProdi" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID PRODI</th>
                                <th>NAMA PRODI</th>
                                <th>SINGKATAN</th>
                                <th>EMAIL PRODI</th>
                                <th>NAMA FAKULTAS</th>
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
        var boolSelect = true;
        var cekSingkatan = true;
        var lastSingkatan = "";
        $(document).ready(function() {
            loadGrid();
        });

        function loadGrid() {
            $.ajax({
                type: "GET",
                url: '{{url("api/prodi")}}',
                data: '',
                contentType: "application/json;charset=utf-8",
                datatype: "json",
                success: function(data) {

                    var oTable = $("#tblProdi").DataTable({
                        data: data,
                        select: 'single',
                        lengthMenu: [
                            [10, 20],
                            [10, 20]
                        ],
                        //paging: false,                
                        columns: [{
                                data: "ID_PRODI",
                                searchable: true,
                                width: "15%"
                            },
                            {
                                data: "NAMA_PRODI",
                                searchable: true,
                                width: "25%"
                            },
                            {
                                data: "SINGKATAN_PRODI",
                                searchable: true,
                                width: "15%"
                            },
                            {
                                data: "EMAIL_PRODI",
                                searchable: true,
                                width: "20%"
                            },
                            {
                                data: "NAMA_FAKULTAS",
                                searchable: true,
                                width: "25%"
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
            $('#formProdi').removeClass('was-validated');
            $('#formProdi')[0].reset();
            $('#cekSingkatanTrue').hide();
            $('#cekSingkatanFalse').hide();

            if (boolSelect == true) {
                $.ajax({
                    type: "GET",
                    url: '{{url("api/fakultas")}}',
                    data: '',
                    contentType: "application/json;charset=utf-8",
                    datatype: "json",
                    success: function(data) {
                        $.each(data, function(index, value) {
                            $('#sFakultas').append($('<option>').text(value.NAMA_FAKULTAS).attr('value', value.ID_FAKULTAS));
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
            if (mode == "EditProdi") {
                var table = $("#tblProdi").DataTable();
                var rows = table.rows('.selected').indexes();
                if (rows.length > 0) {
                    $('#formProdi').attr('action', 'javascript:UpdateProdi();');
                    var data = table.rows(rows).data();
                    $('#titleModalProdi').html("Edit Prodi");
                    $('#txtIdProdi').val(data[0].ID_PRODI);
                    $('#txtIdProdi').attr("disabled", "disabled");
                    $('#txtNamaProdi').val(data[0].NAMA_PRODI);
                    $('#txtSingkatanProdi').val(data[0].SINGKATAN_PRODI);
                    $('#txtEmailProdi').val(data[0].EMAIL_PRODI);
                    $('#sFakultas').val(data[0].ID_FAKULTAS);
                    lastSingkatan = data[0].SINGKATAN_PRODI;

                    $('#modalProdi').modal('show');
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
                    url: '{{url("api/prodi/getid")}}',
                    data: '',
                    contentType: "application/json;charset=utf-8",
                    datatype: "json",
                    success: function(data) {
                        $('#txtIdProdi').val(data.ID);
                    },
                    error: function(xhr, status, error) {
                        var err = xhr.responseText;
                        alert(err);
                    },
                    async: false
                });
                $('#formProdi').attr('action', 'javascript:InsertProdi();');
                $('#txtIdProdi').attr("disabled", "disabled");
                $('#titleModalProdi').html("Add Prodi");
                $('#modalProdi').modal('show');
            }

        }


        function InsertProdi() {
            if (cekSingkatan) {
                var obj = [{
                    "ID_PRODI": $('#txtIdProdi').val(),
                    "NAMA_PRODI": $('#txtNamaProdi').val(),
                    "SINGKATAN_PRODI": $('#txtSingkatanProdi').val(),
                    "EMAIL_PRODI": $('#txtEmailProdi').val(),
                    "ID_FAKULTAS": $('#sFakultas option:selected').val()
                }];
                var json = JSON.stringify(obj)
                var notSukses = "Insert Prodi Berhasil !";
                var notGagal = "Insert Prodi Gagal !";
                var link = '{{url("api/prodi/add")}}';
                var modal = "#modalProdi";
                TemplateProses(link, json, notSukses, notGagal, modal);
            } else {
                swal({
                    type: 'error',
                    title: 'Error!',
                    text: 'Singkatan Tidak Tersedia !',
                    confirmButtonText: 'Dismiss',
                    buttonsStyling: false,
                    confirmButtonClass: 'btn btn-lg btn-danger'
                })
            }


        }

        function UpdateProdi() {
            if (cekSingkatan) {
                var obj = [{
                    "ID_PRODI": $('#txtIdProdi').val(),
                    "NAMA_PRODI": $('#txtNamaProdi').val(),
                    "SINGKATAN_PRODI": $('#txtSingkatanProdi').val(),
                    "EMAIL_PRODI": $('#txtEmailProdi').val(),
                    "ID_FAKULTAS": $('#sFakultas option:selected').val()
                }];
                var json = JSON.stringify(obj)
                var notSukses = "Update Prodi Berhasil !";
                var notGagal = "Update Prodi Gagal !";
                var link = '{{url("api/prodi/update")}}';
                var modal = "#modalProdi";
                TemplateProses(link, json, notSukses, notGagal, modal);
            } else {
                swal({
                    type: 'error',
                    title: 'Error!',
                    text: 'Singkatan Tidak Tersedia !',
                    confirmButtonText: 'Dismiss',
                    buttonsStyling: false,
                    confirmButtonClass: 'btn btn-lg btn-danger'
                })
            }

        }

        function DeleteProdi() {
            var table = $("#tblProdi").DataTable();
            var rows = table.rows('.selected').indexes();
            var data = table.rows(rows).data();

            var obj = [{
                "ID_PRODI": data[0].ID_PRODI
            }];
            var json = JSON.stringify(obj)


            var notSukses = "Delete Prodi Berhasil !";
            var notGagal = "Delete Prodi Gagal !";
            var link = '{{url("api/prodi/delete")}}';
            var modal = "#modalDeleteProdi";
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
            $("#tblProdi").DataTable().destroy();
            loadGrid();
        }

        function showModalDelete() {
            var table = $("#tblProdi").DataTable();
            var rows = table.rows('.selected').indexes();
            if (rows.length > 0) {
                $('#modalDeleteProdi').modal('show');
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


        function CekSingkatan(txtSingkatan) {
            var data = $(txtSingkatan).val();
            if (lastSingkatan == data) {
                $('#cekSingkatanTrue').show();
                $('#cekSingkatanFalse').hide();
                cekSingkatan = true;
            } else {
                $.ajax({
                    type: 'POST',
                    url: '{{url("api/prodi/ceksingkatan")}}',
                    data: '{"SINGKATAN": "' + data + '"}',
                    contentType: "application/json;charset=utf-8",
                    datatype: "json",
                    success: function(data) {
                        if (data.STATUS == true) {
                            $('#cekSingkatanTrue').show();
                            $('#cekSingkatanFalse').hide();
                            cekSingkatan = true;
                        } else {
                            $('#cekSingkatanTrue').hide();
                            $('#cekSingkatanFalse').show();
                            cekSingkatan = false;
                        }

                    },
                    error: function(xhr, status, error) {
                        var err = xhr.responseText;
                        alert(err);
                    },
                    async: false
                });
            }
        }
    </script>
    @endsection
    @section('bottom-js')

    <script src="{{asset('assets/js/form.validation.script.js')}}"></script>


    @endsection