
@extends('master')

@section('style')
<style type="text/css">
        .picker__table {
          display: none;
        }
    </style>
@stop

@section('breadcrumb')
<div class="page-header">
    <div class="breadcrumb-line breadcrumb-line-wide">
        <ul class="breadcrumb">
            <li><a href="{{ url('main') }}">Beranda</a></li>
            <li>Grafik</li>
            <li>Tata Usaha</li>
            <li>Laporan Realisasi Penyerapan Anggaran Berdasarkan Jenis Belanja</li>
            <li class="active">Laporan Realisasi Belanja</li>
        </ul>
    </div>
    <br>
</div>
@stop

@section('content')
<input type="hidden" name="_token" class="_token" value="{{ csrf_token() }}" />

<div class="panel panel-flat">
    <div class="panel-heading">
        <h4 class="panel-titletext-bold"><b>LAPORAN REALISASI BELANJA</b></h4>
        <br>
        <div class="form-group">
            <label class="control-label col-lg-1">Periode</label>
            <div class="col-lg-10">
                <div class="row">
                    <div class="col-md-4">
                        <input class="form-control month-picker" id="periode" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel-body">
		<div class="chart-container">
			<div class="chart has-fixed-height" id="basic_columns"></div>
		</div>
	</div>

</div>
@stop

@section('script')
<script type="text/javascript">
	var gArrJenis_ = [];
	var gArrPagu = [];
	var gArrTargetRp = [];
	var gArrTargetPersen = [];
	var gArrRealisasiRp = [];
	var gArrRealisasiPersen = [];
	var gArrSisaDana= [];
    $(document).ready(function(){

    	$("#periode").datepicker('update', "{{ $ctl_periode }}");
    	$("#periode").on('changeDate', function(selected){
            filter();
        });

    	var dataJSON = "{{ $ctl_data }}";
        var dataJSON2 = parseToString(dataJSON);
        var data = JSON.parse(dataJSON2);
        console.log(data);
        for (var i = 0; i < data.length; i++){
        	gArrJenis_.push(data[i]["RM_JENIS_"]);
        	gArrPagu.push(data[i]["RM_PAGU"]);
        	gArrTargetRp.push(data[i]["RM_TARGET_RP"]);
        	gArrTargetPersen.push(data[i]["RM_TARGET_PERSEN"]);
        	gArrRealisasiRp.push(data[i]["RM_REALISASI_RP"]);
        	gArrRealisasiPersen.push(data[i]["RM_REALISASI_PERSEN"]);
        	gArrSisaDana.push(data[i]["RM_SISA_DANA"]);
        }

    });

    function filter(){
    	var periode = $("#periode").val();
    	window.location = "{{ url('main/'.Helper::allUri(5)) }}?periode="+periode
    }

    $(function () {
	    require.config({
	        paths: {
	            echarts: gEchartResources
	        }
	    });
	    require(
	        [
	            'echarts',
	            'echarts/theme/limitless',
	            'echarts/chart/bar',
	            'echarts/chart/line'
	        ],


	        // Charts setup
	        function (ec, limitless) {
	            var basic_columns = ec.init(document.getElementById('basic_columns'), limitless);

	            basic_columns_options = {

	                // Setup grid
	                grid: echartGrid,

	                // Add tooltip
	                tooltip: {
	                    trigger: 'axis'
	                },

	                // Add legend
	                legend: {
	                    data: ['Pagu', 'Target', 'Realisasi', 'Sisa Dana']
	                },

	                // Enable drag recalculate
	                calculable: true,

	                // Horizontal axis
	                xAxis: [{
	                    type: 'category',
	                    data: gArrJenis_
	                }],

	                // Vertical axis
	                yAxis: [{
	                    type: 'value'
	                }],

	                // Add series
	                series: [
	                    {
	                        name: 'Pagu',
	                        type: 'bar',
	                        data: gArrPagu,
	                        itemStyle: {
	                            normal: {
	                                label: {
	                                    show: true,
	                                    textStyle: {
	                                        fontWeight: 500
	                                    }
	                                }
	                            }
	                        },
	                        markLine: {
	                            data: [{type: 'average', name: 'Average'}]
	                        }
	                    },
	                    {
	                        name: 'Target',
	                        type: 'bar',
	                        data: gArrTargetRp,
	                        itemStyle: {
	                            normal: {
	                                label: {
	                                    show: true,
	                                    textStyle: {
	                                        fontWeight: 500
	                                    }
	                                }
	                            }
	                        },
	                        markLine: {
	                            data: [{type: 'average', name: 'Average'}]
	                        }
	                    },
	                    {
	                        name: 'Realisasi',
	                        type: 'bar',
	                        data: gArrRealisasiRp,
	                        itemStyle: {
	                            normal: {
	                                label: {
	                                    show: true,
	                                    textStyle: {
	                                        fontWeight: 500
	                                    }
	                                }
	                            }
	                        },
	                        markLine: {
	                            data: [{type: 'average', name: 'Average'}]
	                        }
	                    },
	                    {
	                        name: 'Sisa Dana',
	                        type: 'bar',
	                        data: gArrSisaDana,
	                        itemStyle: {
	                            normal: {
	                                label: {
	                                    show: true,
	                                    textStyle: {
	                                        fontWeight: 500
	                                    }
	                                }
	                            }
	                        },
	                        markLine: {
	                            data: [{type: 'average', name: 'Average'}]
	                        }
	                    }
	                ]
	            };

	            basic_columns.setOption(basic_columns_options);

	            window.onresize = function () {
	                setTimeout(function () {
	                    basic_columns.resize();
	                }, 200);
	            }
	        }
	    );
	});


</script>
@stop
