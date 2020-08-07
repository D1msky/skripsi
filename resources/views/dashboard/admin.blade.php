@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1>Dashboard Admin</h1>

</div>

<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <!-- ICON BG -->
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center">
                <i class="i-Administrator"></i>
                <div class="content">
                    <p class="text-muted mt-2 mb-0">Total User</p>
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
                    <p class="text-muted mt-2 mb-0">Total Matkul</p>
                    <p class="text-primary text-24 line-height-1 mb-2">{{$data['jmlhmat']}}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center">
                <i class="i-Conference"></i>
                <div class="content">
                    <p class="text-muted mt-2 mb-0">Total Kelas</p>
                    <p class="text-primary text-24 line-height-1 mb-2">{{$data['jmlhkel']}}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center">
                <i class="i-Open-Book"></i>
                <div class="content">
                    <p class="text-muted mt-2 mb-0">Total CPL</p>
                    <p class="text-primary text-24 line-height-1 mb-2">{{$data['jmlhcpl']}}</p>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-lg-8 col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">Jumlah Kelas Setiap Prodi</div>
                <div id="echartBarKelas" style="height: 300px;"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('page-js')
<script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
<script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
<script src="{{asset('assets/js/es5/dashboard.v1.script.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        barChartKelas();
        
    });

    function barChartKelas() {
        var getData = "{{$data['prodiData']}}";
        var getMhs = "{{$data['prodiMhs']}}";

        var echartElemBar = document.getElementById('echartBarKelas');
        if (echartElemBar) {
            var echartBar = echarts.init(echartElemBar);
            echartBar.setOption({
                legend: {
                    borderRadius: 0,
                    orient: 'horizontal',
                    x: 'right',
                    data: ['Kelas']
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
                    data: JSON.parse(getData.replace(/&quot;/g, '"')),
                    axisTick: {
                        alignWithLabel: true
                    },
                    splitLine: {
                        show: false
                    },
                    axisLine: {
                        show: true
                    }
                }],
                yAxis: [{
                    type: 'value',
                    axisLabel: {
                        formatter: '{value}'
                    },
                    min: 0,
                    max: 80,
                    interval: 10,
                    axisLine: {
                        show: false
                    },
                    splitLine: {
                        show: true,
                        interval: 'auto'
                    }
                }],

                series: [{
                    name: 'Kelas',
                    data: JSON.parse(getMhs),
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
</script>
@endsection