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
                    {{$data->ID_MATAKULIAH}} ({{$data->SKS}} SKS)
                </div>
                <div class="card-body">
                    <h6 class="card-title">{{$data->NAMA_MATAKULIAH}} [{{$data->SINGKATAN_MATKUL}}] GROUP {{$data->GRUP}}</h6>
                    @if(($data->DOSEN2 != null) && ($data->DOSEN3 != null))
                    <p class="text-primary">{{$data->DOSEN1}} || {{$data->DOSEN2}} || {{$data->DOSEN3}}</p>
                    @elseif(($data->DOSEN2 == null) && ($data->DOSEN3 != null))
                    <p class="text-primary">{{$data->DOSEN1}} || {{$data->DOSEN3}}</p>
                    @elseif($data->DOSEN2 != null)
                    <p class="text-primary">{{$data->DOSEN1}} || {{$data->DOSEN2}}</p>
                    @else
                    <p class="text-primary">{{$data->DOSEN1}}</p>
                    @endif
                    <a href="/tugas/{{$data->ID_KELAS}}" class="btn btn-primary btn-rounded">Tugas</a>
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