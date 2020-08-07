@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1>Dashboard Kaprodi</h1>

</div>

<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <!-- ICON BG -->
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center">
                <i class="i-Administrator"></i>
                <div class="content">
                    <p class="text-muted mt-2 mb-0">Total Mahasiswa {{auth()->user()->prodi->SINGKATAN_PRODI}}</p>
                    <p class="text-primary text-24 line-height-1 mb-2">{{$data['jmlhuser']}}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center">
                <i class="i-File-Clipboard-File--Text"></i>
                <div class="content">
                    <p class="text-muted mt-2 mb-0">Total Matakuliah {{auth()->user()->prodi->SINGKATAN_PRODI}}</p>
                    <p class="text-primary text-24 line-height-1 mb-2">{{$data['jmlhmatkul']}}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center">
                <i class="i-Conference"></i>
                <div class="content">
                    <p class="text-muted mt-2 mb-0">Total Kelas {{auth()->user()->prodi->SINGKATAN_PRODI}}</p>
                    <p class="text-primary text-24 line-height-1 mb-2">{{$data['jmlhkelas']}}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center">
                <i class="i-Open-Book"></i>
                <div class="content">
                    <p class="text-muted mt-2 mb-0">Rata2 Nilai CPL {{auth()->user()->prodi->SINGKATAN_PRODI}}</p>
                    <p class="text-primary text-24 line-height-1 mb-2">{{$data['avgbobotcpl']}}</p>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-lg-9 col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">Rata-Rata Beban Tugas Mahasiswa Setiap Kelas {{auth()->user()->prodi->SINGKATAN_PRODI}}</div>
                <div class="row">
                    <div class="col-md-3">
                        <select id="sFilterKelas" class="form-control" onchange="filterKelas(this.value)">
                            <option value="">- Filter Matakuliah -</option>
                         
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="sSortKelas" class="form-control" onchange="sortKelas(this.value)">
                            <option value="">- Sort Kelas -</option>
                            <option value="A">Sort : ASC </option>
                            <option value="D">Sort : DSC </option>
                        </select>
                    </div>
                </div>

                <div id="echartBarKelas" style="height: 300px;"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card o-hidden mb-4">
            <div class="card-header d-flex align-items-center border-0">

                <h3 class="w-100 float-left card-title m-0">Top 3 Beban Kelas</h3>
            </div>

            <div class="">
                <div class="table-responsive">
                    <table id="user_table" class="table text-center">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" style="width: 10%">NO</th>
                                <th scope="col" style="width: 70%">KELAS</th>
                                <th scope="col" style="width: 20%">BEBAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(json_decode($sortTop) as $k)
                            <tr>
                                <th scope="row">{{($loop->index)+1}}</th>
                                <td>{{$k->NAMA}}</td>
                                <td>{{$k->BEBAN}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-9 col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">Rata-Rata Nilai CPL Setiap Matakuliah {{auth()->user()->prodi->SINGKATAN_PRODI}}</div>
                <div class="row">
                    <div class="col-md-3">
                        <select id="sFilterCpl" class="form-control" onchange="filterCpl(this.value)">
                            <option value="">- Filter Matkuliah -</option>
                          
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="sSortCpl" class="form-control" onchange="sortCpl(this.value)">
                            <option value="">- Sort Matkuliah -</option>
                            <option value="A">Sort : ASC </option>
                            <option value="D">Sort : DSC </option>
                        </select>
                    </div>
                </div>

                <div id="echartBarCpl" style="height: 300px;"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card o-hidden mb-4">
            <div class="card-header d-flex align-items-center border-0">
                <h3 class="w-100 float-left card-title m-0">Top 3 Nilai CPL</h3>
            </div>

            <div class="">
                <div class="table-responsive">
                    <table id="user_table" class="table text-center">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" style="width: 10%">NO</th>
                                <th scope="col" style="width: 70%">MATAKULIAH</th>
                                <th scope="col" style="width: 20%">NILAI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(json_decode($sortTopCpl) as $s)
                            <tr>
                                <th scope="row">{{($loop->index)+1}}</th>
                                <td>{{$s->NAMA}}</td>
                                <td>{{$s->NILAI}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('page-js')
<script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
<script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
<script type="text/javascript">
    var echartBar1;
    var getCpl = <?php echo json_encode($listCpl); ?>;
    var getKelas = <?php echo json_encode($listKelas); ?>;
    var filterKelasData = [],
        filterKelasBobot = [];
    var filterCplData = [],
        filterCplBobot = [];

    $(document).ready(function() {
        barChartKelas();
        barChartCpl();
        initFilter();
    });

    function initFilter() {
        $.ajax({
            type: "GET",
            url: '{{url("api/filterkaprodi")}}',
            data: '',
            contentType: "application/json;charset=utf-8",
            datatype: "json",
            success: function(data) {
                $.each(data, function(index, value) {
                    $('#sFilterCpl').append($('<option>').text("Filter : "+ value).attr('value', value));
                    $('#sFilterKelas').append($('<option>').text("Filter : "+ value).attr('value', value));
                });
            },
            error: function(xhr, status, error) {
                var err = xhr.responseText;
                alert(err);
            },
            async: false
        });
    }

    function barChartKelas() {

        var echartElemBar = document.getElementById('echartBarKelas');
        if (echartElemBar) {
            echartBar1 = echarts.init(echartElemBar);
             echartBar1.setOption({
               
                legend: {
                    borderRadius: 0,
                    orient: 'horizontal',
                    x: 'right',
                    data: ['Beban']
                },
                grid: {
                    left: '8px',
                    right: '8px',
                    bottom: '0',
                    containLabel: true
                },
                tooltip: {
                    show: true,
                    backgroundColor: 'rgba(0, 0, 0, .8)'
                },
                xAxis: [{
                    type: 'category',
                    data: filterKelasData,
                    axisTick: {
                        alignWithLabel: true
                    },
                    splitLine: {
                        show: false
                    },
                    axisLine: {
                        show: true
                    },
                    axisLabel:{
                        interval : 0,
                        rotate : 30
                    }
                    
                
                }],
                yAxis: [{
                    type: 'value',
                    axisLabel: {
                        formatter: '{value}'
                    },
                    min: 0,
                    max: 4,
                    interval: 0.5,
                    axisLine: {
                        show: false
                    },
                    splitLine: {
                        show: true,
                        interval: 'auto'
                    }
                }],

                series: [{
                    name: 'Beban',
                    data: filterKelasBobot,
                    label: {
                        show: false,
                        color: '#0168c1'
                    },
                    type: 'bar',
                    barGap: 0,
                    color: '#7569b3',
                    smooth: true,
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowOffsetY: -2,
                            shadowColor: 'rgba(0, 0, 0, 0.3)'
                        }
                    }
                 }]
            });

            $(window).on('resize', function() {
                setTimeout(function() {
                    echartBar1.resize();
                }, 500);
            });


        }
    }

    function barChartCpl() {

        var echartElemBar = document.getElementById('echartBarCpl');
        if (echartElemBar) {
            var echartBar = echarts.init(echartElemBar);
            echartBar.setOption({
                legend: {
                    borderRadius: 0,
                    orient: 'horizontal',
                    x: 'right',
                    data: ['Nilai']
                },
                grid: {
                    left: '8px',
                    right: '8px',
                    bottom: '0',
                    containLabel: true
                },
                tooltip: {
                    show: true,
                    backgroundColor: 'rgba(0, 0, 0, .8)'
                },
                xAxis: [{
                    type: 'category',
                    data: filterCplData,
                    axisTick: {
                        alignWithLabel: true
                    },
                    splitLine: {
                        show: false
                    },
                    axisLine: {
                        show: true
                    },
                    axisLabel:{
                        interval : 0,
                        rotate : 30
                    }
                }],
                yAxis: [{
                    type: 'value',
                    axisLabel: {
                        formatter: '{value}'
                    },
                    min: 0,
                    max: 4,
                    interval: 0.5,
                    axisLine: {
                        show: false
                    },
                    splitLine: {
                        show: true,
                        interval: 'auto'
                    }
                }],

                series: [{
                    name: 'Nilai',
                    data: filterCplBobot,
                    label: {
                        show: false,
                        color: '#0168c1'
                    },
                    type: 'bar',
                    barGap: 0,
                    color: '#7569b3',
                    smooth: true,
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowOffsetY: -2,
                            shadowColor: 'rgba(0, 0, 0, 0.3)'
                        }
                    }
                }]
            });
            $(window).on('resize', function() {
                setTimeout(function() {
                    echartBar.resize();
                }, 500);
            });
        }
    }

    function filterKelas(id) {
        filterKelasData = [];
        filterKelasBobot = [];
        if (id != "") {
            var counter = 0;
            for (var i = 0; i < getKelas.length; i++) {
                if ((getKelas[i].ID).indexOf(id) > -1) {
                    filterKelasData[counter] = getKelas[i].NAMA;
                    filterKelasBobot[counter] = getKelas[i].BEBAN;
                    counter++;
                }
            }
        }
        
        //filterKelasData ="[" + filterKelasData.map(x => "" + x + "").toString() + "]";
        console.log(filterKelasData);
        barChartKelas();
    }


    function filterCpl(id) {

        filterCplData = [];
        filterCplBobot = [];
        if (id != "") {
            var counter = 0;
            for (var i = 0; i < getCpl.length; i++) {
                if ((getCpl[i].ID).indexOf(id) > -1) {
                    filterCplData[counter] = getCpl[i].NAMA;
                    filterCplBobot[counter] = getCpl[i].NILAI;
                    counter++;
                }
            }
        }
        
        barChartCpl();
    }

    function sortCpl(id) {
        var tmp, tmpData;
        var idx;
        if (id == "A") {
            for (var i = 0; i < filterCplData.length; i++) {
                tmp = filterCplBobot[i];
                idx = i;
                for (var j = i; j < (filterCplData.length); j++) {
                    if (tmp > filterCplBobot[j]) {
                        tmp = filterCplBobot[j];
                        idx = j;
                    }
                }
                tmpData = filterCplData[i];
                tmp = filterCplBobot[i];
                filterCplBobot[i] = filterCplBobot[idx];
                filterCplData[i] = filterCplData[idx];

                filterCplBobot[idx] = tmp;
                filterCplData[idx] = tmpData;
            }
        } else if (id == "D") {

            for (var i = 0; i < filterCplData.length; i++) {
                tmp = filterCplBobot[i];
                idx = i;
                for (var j = i; j < (filterCplData.length); j++) {
                    if (tmp < filterCplBobot[j]) {
                        tmp = filterCplBobot[j];
                        idx = j;
                    }
                }
                tmpData = filterCplData[i];
                tmp = filterCplBobot[i];
                filterCplBobot[i] = filterCplBobot[idx];
                filterCplData[i] = filterCplData[idx];

                filterCplBobot[idx] = tmp;
                filterCplData[idx] = tmpData;
            }

        }


        barChartCpl();
    }

    function sortKelas(id) {
        var tmp, tmpData;
        var idx;
        if (id == "A") {
            for (var i = 0; i < filterKelasData.length; i++) {
                tmp = filterKelasBobot[i];
                idx = i;
                for (var j = i; j < (filterKelasData.length); j++) {
                    if (tmp > filterKelasBobot[j]) {
                        tmp = filterKelasBobot[j];
                        idx = j;
                    }
                }
                tmpData = filterKelasData[i];
                tmp = filterKelasBobot[i];
                filterKelasBobot[i] = filterKelasBobot[idx];
                filterKelasData[i] = filterKelasData[idx];

                filterKelasBobot[idx] = tmp;
                filterKelasData[idx] = tmpData;
            }
        } else if (id == "D") {

            for (var i = 0; i < filterKelasData.length; i++) {
                tmp = filterKelasBobot[i];
                idx = i;
                for (var j = i; j < (filterKelasData.length); j++) {
                    if (tmp < filterKelasBobot[j]) {
                        tmp = filterKelasBobot[j];
                        idx = j;
                    }
                }
                tmpData = filterKelasData[i];
                tmp = filterKelasBobot[i];
                filterKelasBobot[i] = filterKelasBobot[idx];
                filterKelasData[i] = filterKelasData[idx];

                filterKelasBobot[idx] = tmp;
                filterKelasData[idx] = tmpData;
            }

        }
        barChartKelas();
    }
</script>
@endsection