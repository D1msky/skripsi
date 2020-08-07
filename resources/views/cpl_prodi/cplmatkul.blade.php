@extends('layouts.master')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
@endsection

@section('main-content')
<div class="breadcrumb">
    <h1>Persebaran CPL</h1>

</div>
<div class="separator-breadcrumb border-top"></div>

<!-- end of row -->
<div class="row mb-4">
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3">Persebaran CPL</h4>
                <br>
                <div class="table-responsive">
                    <table id="tblMatakuliah" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 12%">KD CPL</th>
                                <th style="width: 66%">NAMA MATAKULIAH</th>
                                <th style="width: 12%">TOTAL MATKUL</th>
                                <th style="width: 10%">TOTAL NILAI</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($hasil as $h)
                            <tr>
                                <td>{{$h['ID']}}</td>
                                <td>{{$h['NAMA']}}</td>
                                <td>{{$h['JMLH']}}</td>
                                <td>{{$h['NILAI']}}</td>
                            </tr>
                         @endforeach
                        </tbody>
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
    
        $(document).ready(function() {
       
            $('#tblMatakuliah').DataTable();
        });

    </script>
    @endsection
    @section('bottom-js')

    <script src="{{asset('assets/js/form.validation.script.js')}}"></script>


    @endsection