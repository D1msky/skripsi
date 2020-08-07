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

<div class="2-columns-form-layout">
    <div class="">
        <div class="row">
            <div class="col-lg-12">

                <!-- start card 3 Columns  Form Layout-->
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">Setting Prodi</h3>
                    </div>
                    <!--begin::form-->
                    <form action="javascript:SaveProdi();" class="needs-validation" action="" novalidate>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="txtNamaProdi" class="ul-form__label">Nama Prodi:</label>
                                    <input type="text" class="form-control" maxlength="100" id="txtNamaProdi" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="txtSingkatanProdi" class="ul-form__label">Singkatan Prodi:</label>
                                    <input type="text" class="form-control" maxlength="8" onkeyup="CekSingkatan(this)" id="txtSingkatanProdi" required>
                                    <div id="cekSingkatanTrue" class="valid-feedback" style="display: none">ID User Tersedia</div>
                                    <div id="cekSingkatanFalse" class="invalid-feedback" style="display: none">ID User Tidak Tersedia</div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="txtEmailProdi" class="ul-form__label">Email Prodi:</label>
                                    <input type="email" class="form-control" maxlength="100" id="txtEmailProdi" required>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="picFakultas" class="ul-form__label">Fakultas:</label>
                                    <select id="sFakultas" class="form-control" required>
                                        <option value="">- Select Fakultas -</option>
                                    </select>
                                </div>


                            </div>


                            <div class="custom-separator"></div>
                            <h6>[FAKTOR RATING]</h6>

                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="txtPersen" class="ul-form__label">Persen:</label>
                                    <input type="number" min="0" max="1" class="form-control" id="txtPersen" step=".01" required>
                                    <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                        Rating 0 - 1
                                    </small>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="txtWaktu" class="ul-form__label">Waktu:</label>
                                    <input type="number" min="0" max="1" class="form-control" id="txtWaktu" step=".01" required>
                                    <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                        Rating 0 - 1
                                    </small>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="txtCpl" class="ul-form__label">CPL:</label>
                                    <input type="number" min="0" max="1" class="form-control" id="txtCpl" step=".01" required>
                                    <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                        Rating 0 - 1
                                    </small>
                                </div>

                            </div>


                            <div class="custom-separator"></div>
                            <h6>[DOMAIN FUZZY PERSENTASE NILAI TUGAS]</h6>
                            <div class="form-row">
                                <label for="staticEmail19" class="ul-form__label ul-form--margin col-lg-1   col-form-label ">
                                    Tinggi:</label>
                                <div class="col-lg-3 ">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="input-right-icon">
                                                <input type="number" min="0" max="100" class="form-control" id="txtTinggi" required>
                                                <span class="span-right-input-icon">
                                                    <i class="">%</i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8"></div>
                                <br></br>
                                <label for="staticEmail19" class="ul-form__label ul-form--margin col-lg-1   col-form-label ">
                                    Sedang:</label>
                                <div class="col-lg-3 ">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="input-right-icon">
                                                <input type="number" min="0" max="100" class="form-control" id="txtSedangA" required>
                                                <span class="span-right-input-icon">
                                                    <i class="">%</i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="input-right-icon">
                                                <input type="number" min="0" max="100" class="form-control" id="txtSedangB" required>
                                                <span class="span-right-input-icon">
                                                    <i class="">%</i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8"></div>
                                <br></br>
                                <label for="staticEmail19" class="ul-form__label ul-form--margin col-lg-1   col-form-label ">
                                    Rendah:</label>
                                <div class="col-lg-3 ">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="input-right-icon">
                                                <input type="number" min="0" max="100" class="form-control" id="txtRendahA" required>
                                                <span class="span-right-input-icon">
                                                    <i class="">%</i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="input-right-icon">
                                                <input type="number" min="0" max="100" class="form-control" id="txtRendahB" required>
                                                <span class="span-right-input-icon">
                                                    <i class="">%</i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8"></div>
                                <br></br>
                                <label for="staticEmail19" class="ul-form__label ul-form--margin col-lg-1   col-form-label ">
                                    Sangat Rendah:</label>
                                <div class="col-lg-3 ">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="input-right-icon">
                                                <input type="number" min="0" max="100" class="form-control" id="txtSRendahA" required>
                                                <span class="span-right-input-icon">
                                                    <i class="">%</i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="input-right-icon">
                                                <input type="number" min="0" max="100" class="form-control" id="txtSRendahB" required>
                                                <span class="span-right-input-icon">
                                                    <i class="">%</i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>


                        </div>

                        <div class="card-footer">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <button type="submit" class="btn  btn-primary m-1">Save</button>
                                        <a href="/" type="button" class="btn btn-outline-secondary m-1">Cancel</a>



                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>

                    <!-- end::form 3-->

                </div>
                <!-- end card 3-->

            </div>

        </div>
        <!-- end of main row -->
    </div>
</div>



@endsection

@section('page-js')
<script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/datatables.script.js')}}"></script>
<script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
<script type="text/javascript">
    var lastSingkatan = "";
    var cekSingkatan = true;
    $(document).ready(function() {
        loadFakultas();
        loadGrid();
    });

    function loadGrid() {
        $.ajax({
            type: 'GET',
            url: '{{url("api/setprodi")}}',
            data: '',
            contentType: "application/json;charset=utf-8",
            datatype: "json",
            success: function(data) {

                $('#txtNamaProdi').val(data.NAMA_PRODI);
                $('#txtEmailProdi').val(data.EMAIL_PRODI);
                $('#txtSingkatanProdi').val(data.SINGKATAN_PRODI);
                lastSingkatan = data.SINGKATAN_PRODI;
                $('#sFakultas').val(data.ID_FAKULTAS);
                $('#txtPersen').val(data.BOBOT_PERSEN);
                $('#txtWaktu').val(data.BOBOT_WAKTU);
                $('#txtCpl').val(data.BOBOT_CPL);
                $('#txtTinggi').val(data.PERSEN_TINGGI);
                $('#txtSedangA').val(data.PERSEN_SDG_A);
                $('#txtSedangB').val(data.PERSEN_SDG_B);
                $('#txtRendahA').val(data.PERSEN_RNDH_A);
                $('#txtRendahB').val(data.PERSEN_RNDH_B);
                $('#txtSRendahA').val(data.PERSEN_SRNDH_A);
                $('#txtSRendahB').val(data.PERSEN_SRNDH_B);
            },
            error: function(xhr, status, error) {
                var err = xhr.responseText;
                alert(err);
            },
            async: false
        });
    }

    function loadFakultas() {
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
    }

    function SaveProdi() {
        var namaProdi = $('#txtNamaProdi').val();
        var singktnProdi = $('#txtSingkatanProdi').val();
        var emailProdi = $('#txtEmailProdi').val();
        var fakultas = $('#sFakultas option:selected').val();
        var persen = $('#txtPersen').val();
        var waktu = $('#txtWaktu').val();
        var cpl = $('#txtCpl').val();

        var tinggi = $('#txtTinggi').val();
        var sdga = $('#txtSedangA').val();
        var sdgb = $('#txtSedangB').val();
        var rndha = $('#txtRendahA').val();
        var rndhb = $('#txtRendahB').val();
        var srndha = $('#txtSRendahA').val();
        var srndhb = $('#txtSRendahB').val();

        if ((parseFloat(persen) + parseFloat(waktu) + parseFloat(cpl)) == 1) {
            if ((parseFloat(sdga) < parseFloat(sdgb)) || (parseFloat(rndha) < parseFloat(rndhb)) || (parseFloat(srndha) < parseFloat(srndhb))) {
                if (cekSingkatan) {
                    var obj = [{
                        "ID_PRODI": "{{auth()->user()->ID_PRODI}}",
                        "ID_FAKULTAS": fakultas,
                        "NAMA_PRODI": namaProdi,
                        "SINGKATAN_PRODI": singktnProdi,
                        "EMAIL_PRODI": emailProdi,
                        "BOBOT_PERSEN": persen,
                        "BOBOT_WAKTU": waktu,
                        "BOBOT_CPL": cpl,
                        "PERSEN_TINGGI": tinggi,
                        "PERSEN_SDG_A": sdga,
                        "PERSEN_SDG_B": sdgb,
                        "PERSEN_RNDH_A": rndha,
                        "PERSEN_RNDH_B": rndhb,
                        "PERSEN_SRNDH_A": srndha,
                        "PERSEN_SRNDH_B": srndhb
                    }];
                    var json = JSON.stringify(obj)

                    var link = '{{url("api/setprodi/update")}}';

                    TemplateProses(link, json);
                } else {
                    swal({
                        type: 'warning',
                        title: 'Warning',
                        text: 'Singkatan Tidak Tersedia !',
                        buttonsStyling: false,
                        confirmButtonClass: 'btn btn-lg btn-warning'
                    })
                }

            } else {
                swal({
                    type: 'warning',
                    title: 'Warning',
                    text: 'Persen Nilai Tidak Sesuai !',
                    buttonsStyling: false,
                    confirmButtonClass: 'btn btn-lg btn-warning'
                })
            }
        } else {
            swal({
                type: 'warning',
                title: 'Warning',
                text: 'Bobot Tidak Sesuai !',
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-lg btn-warning'
            })
        }

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
                        text: 'Update Prodi Berhasil !',
                        buttonsStyling: false,
                        confirmButtonClass: 'btn btn-lg btn-success'
                    })
                } else {
                    swal({
                        type: 'error',
                        title: 'Error',
                        text: 'Insert Prodi Gagal !',
                        buttonsStyling: false,
                        confirmButtonClass: 'btn btn-lg btn-danger'
                    })
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