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
            <li class="active">Tupoksi</li>
        </ul>
    </div>
    <br>
</div>
@stop

@section('content')
<input type="hidden" name="_token" class="_token" value="{{ csrf_token() }}" />

<div class="panel panel-flat">
    <div class="panel-heading">
        <h4 class="panel-titletext-bold"><b>TUPOKSI</b></h4>
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
	var gArrLaki = [];
	var gArrPerempuan = [];
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
        	gArrJenis_.push(data[i]["TPKS_JENIS_"]);
        	gArrLaki.push(data[i]["TPKS_LAKI"]);
        	gArrPerempuan.push(data[i]["TPKS_PEREMPUAN"]);
        }

    });

    function filter(){
    	var periode = $("#periode").val();
    	window.location = "{{ url('main/'.Helper::allUri(4)) }}?periode="+periode
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
	                grid: {
			            x: 35,
			            x2: 25,
			            y: 60,
			            y2: 50
			        },

	                // Add tooltip
	                tooltip: {
	                    trigger: 'axis'
	                },

	                // Add legend
	                legend: {
	                    data: ['Laki-laki', 'Perempuan', 'Jumlah']
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
	                        name: 'Laki-laki',
	                        type: 'bar',
	                        data: gArrLaki,
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
	                        name: 'Perempuan',
	                        type: 'bar',
	                        data: gArrPerempuan,
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
	                        name: 'Jumlah',
	                        type: 'bar',
	                        data: gArrLaki.map(function (num, idx) {
							  return num + gArrPerempuan[idx];
							}),
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
