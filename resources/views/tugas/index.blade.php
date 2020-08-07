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
                <button type="button" class="btn btn-primary ripple m-1" onclick="showModal('InsertTugas')">Add</button>
                <button type="button" class="btn btn-warning m-1" onclick="showModal('EditTugas')">Edit</button>
                <button type="button" class="btn btn-danger m-1" onclick="showModalDelete()">Delete</button>
                <br></br>
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
    @include('tugas.modal')
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

        function showModal(mode) {
            //Reset Form
            $('#formTugas')[0].reset();
            $('#formTugas').removeClass('was-validated');
            $('#cekIdTrue').hide();
            $('#cekIdFalse').hide();
            $('#txtTglSelesai').datepicker();
            //Reset Form



            if (mode == "EditTugas") {
                var table = $("#tblTugas").DataTable();
                var rows = table.rows('.selected').indexes();
                if (rows.length > 0) {
                    $('#formTugas').attr('action', 'javascript:UpdateTugas();');
                    var data = table.rows(rows).data();
                    $('#titleModalTugas').html("Edit Tugas");
                    $('#txtIdTugas').val(data[0].ID_TUGAS);
                    $('#txtNamaTugas').val(data[0].NAMA_TUGAS);
                    $('#txtPersen').val(data[0].PERSEN);
                    $('#txtWaktuMulai').val(data[0].WAKTU_MULAI);
                    var dataku = data[0].WAKTU_SELESAI;
                    var hsl = dataku.split(" ");
                    $('#txtTglSelesai').val(hsl[0]);
                    $('#txtWaktuSelesai').val(hsl[1]);





                    $('#modalTugas').modal('show');
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
                    url: '{{url("api/tugas/getid")}}',
                    data: '',
                    contentType: "application/json;charset=utf-8",
                    datatype: "json",
                    success: function(data) {
                        $('#txtIdTugas').val(data.ID);
                    },
                    error: function(xhr, status, error) {
                        var err = xhr.responseText;
                        alert(err);
                    },
                    async: false
                });
                $('#formTugas').attr('action', 'javascript:InsertTugas();');
                $('#titleModalTugas').html("Add Tugas");
                $('#modalTugas').modal('show');
            }


        }

        function InsertTugas() {
            var obj = [{
                "ID_TUGAS": $('#txtIdTugas').val(),
                "ID_KELAS": "{{$idKelas}}",
                "NAMA_TUGAS": $('#txtNamaTugas').val(),
                "PERSEN": $('#txtPersen').val(),
                "WAKTU_SELESAI": $('#txtTglSelesai').val() + " " + $('#txtWaktuSelesai').val()
            }];
            var json = JSON.stringify(obj)
           
            var notSukses = "Insert Tugas Berhasil !";
            var notGagal = "Insert Tugas Gagal !";
            var link = '{{url("api/tugas/add")}}';
            var modal = "#modalTugas";
            TemplateProses(link, json, notSukses, notGagal, modal);

        }

        function UpdateTugas() {

            var obj = [{
                "ID_TUGAS": $('#txtIdTugas').val(),
                "ID_KELAS": "{{$idKelas}}",
                "NAMA_TUGAS": $('#txtNamaTugas').val(),
                "PERSEN": $('#txtPersen').val(),
                "WAKTU_MULAI": $('#txtWaktuMulai').val(),
                "WAKTU_SELESAI": $('#txtTglSelesai').val() + " " + $('#txtWaktuSelesai').val()
            }];

            var json = JSON.stringify(obj)
            var notSukses = "Update Tugas Berhasil !";
            var notGagal = "Update Tugas Gagal !";
            var link = '{{url("api/tugas/update")}}';
            var modal = "#modalTugas";
            TemplateProses(link, json, notSukses, notGagal, modal);

        }

        function showModalDelete() {
            var table = $("#tblTugas").DataTable();
            var rows = table.rows('.selected').indexes();
            if (rows.length > 0) {
                $('#modalDeleteTugas').modal('show');
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

        function DeleteTugas() {
            var table = $("#tblTugas").DataTable();
            var rows = table.rows('.selected').indexes();
            var data = table.rows(rows).data();

            var obj = [{
                "ID_TUGAS": data[0].ID_TUGAS
            }];
            var json = JSON.stringify(obj)


            var notSukses = "Delete Tugas Berhasil !";
            var notGagal = "Delete Tugas Gagal !";
            var link = '{{url("api/tugas/delete")}}';
            var modal = "#modalDeleteTugas";
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
            $("#tblTugas").DataTable().destroy();
            loadGrid();
        }

        function CekId(txtId) {
            var dataId = $(txtId).val();

            $.ajax({
                type: 'POST',
                url: '{{url("api/Tugas/cekid")}}',
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    @endsection