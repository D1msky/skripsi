@extends('layouts.master')
@section('page-css')

@endsection

@section('main-content')
<div class="breadcrumb">
    <h1>Kelas</h1>

</div>
<div class="separator-breadcrumb border-top"></div>

<!-- end of row -->
<div class="row mb-4">
    <div class="col-md-7 mb-4">
    @foreach($dafmatkul as $data)
            <div class="card mb-4">
                <div class="card-header">
                    {{$data->ID_MATAKULIAH}} ({{$data->matakuliah->SKS}} SKS)
                </div>
                <div class="card-body">
                    <h6 class="card-title">{{$data->matakuliah->NAMA_MATAKULIAH}} [{{$data->matakuliah->SINGKATAN_MATKUL}}] GROUP {{$data->GRUP}}</h6>
                    
                    <a href="/tugas/{{$data->ID_KELAS}}" class="btn btn-primary btn-rounded">Tugas</a>
                    <a href="/cplmatkul/{{$data->ID_MATAKULIAH}}" class="btn btn-info btn-rounded">CPL</a>
                    <a href="/bobot/{{$data->ID_KELAS}}" class="btn btn-dark btn-rounded">Beban Tugas Mahasiswa</a>
                </div>
            </div>
    @endforeach
    </div>
</div>
<!-- end of col -->

@endsection

@section('page-js')

<script type="text/javascript">

</script>
@endsection
@section('bottom-js')




@endsection