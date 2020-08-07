@extends('layouts.master')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
@endsection

@section('main-content')
<div class="breadcrumb">
    <h1>Kelas</h1>
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
                        <a type="button" class="btn btn-primary ripple m-1" href="/cplmatkul/add/{{$matkul->ID_MATAKULIAH}}">Add</a>
                        <button type="button" class="btn btn-warning m-1" onclick="showModal()">Edit</button>
                        <button type="button" class="btn btn-danger m-1" onclick="showModalDelete()">Delete</button>
                    </div>
                    <div class="col-md-3">
                        <div class="card mb-4">
                            <div class="card-body text-center">
                                <h5 id="rataNilai" class="mb-0" ></h5>
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
                                <th>LAST UPDATED</th>
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
                    totalNilai = 0;
                    for (var i = 0; i < data.length; i++) {
                        totalNilai += data[i].BOBOT;
                    }
                    var rataNilai;
                    if(data.length > 0){
                        rataNilai = totalNilai / data.length;
                        rataNilai = (Math.round(rataNilai * 100) / 100).toPrecision(2);
                    }else{
                        rataNilai = 0;
                    }
                    $('#rataNilai').text('Rata2 Nilai : '+ rataNilai +'');
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
                                data: "KD_CPL",
                                searchable: true,
                                width: "10%"
                            },
                            {
                                data: "DESKRIPSI_CPL",
                                searchable: true,
                                width: "60%"
                            },
                            {
                                data: "BOBOT",
                                searchable: true,
                                width: "5%"
                            },
                            {
                                data: "UPDATED_AT",
                                searchable: true,
                                width: "10%"
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

        function showModal() {
            $('#formCpl').removeClass('was-validated');
            $('#formCpl')[0].reset();

            var table = $("#tblCpl").DataTable();
            var rows = table.rows('.selected').indexes();
            if (rows.length > 0) {
                $('#formCpl').attr('action', 'javascript:UpdateCpl();');
                var data = table.rows(rows).data();
                $('#titleModalCpl').html("Edit CPL");
                $('#txtIdCplMatkul').val(data[0].ID_CPL_MATKUL);
                $('#txtIdCpl').val(data[0].ID_CPL);
                $('#txtDeskripsiCPL').val(data[0].DESKRIPSI_CPL);
                $('#sBobot').val(data[0].BOBOT);


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


        function UpdateCpl() {
            var obj = [{
                "ID_CPL_MATKUL": $('#txtIdCplMatkul').val(),
                "BOBOT": $('#sBobot option:selected').val()
            }];
            var json = JSON.stringify(obj)
            var notSukses = "Update CPL Berhasil !";
            var notGagal = "Update CPL Gagal !";
            var link = '{{url("api/cplmatkul/update")}}';
            var modal = "#modalCpl";
            TemplateProses(link, json, notSukses, notGagal, modal);

        }

        function DeleteCpl() {
            var table = $("#tblCpl").DataTable();
            var rows = table.rows('.selected').indexes();
            var data = table.rows(rows).data();

            var obj = [{
                "ID_CPL_MATKUL": data[0].ID_CPL_MATKUL
            }];
            var json = JSON.stringify(obj)


            var notSukses = "Delete CPL Berhasil !";
            var notGagal = "Delete CPL Gagal !";
            var link = '{{url("api/cplmatkul/delete")}}';
            var modal = "#modalDeleteCpl";
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
            $("#tblCpl").DataTable().destroy();
            loadGrid();
        }

        function showModalDelete() {
            var table = $("#tblCpl").DataTable();
            var rows = table.rows('.selected').indexes();
            if (rows.length > 0) {
                $('#modalDeleteCpl').modal('show');
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