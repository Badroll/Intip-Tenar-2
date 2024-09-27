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
            <li>Tata Usaha</li>
            <li>Urusan Kepegawaian</li>
            <li class="active">Data Cuti Pegawai</li>
        </ul>
    </div>
    <br>
</div>
@stop

@section('content')
<input type="hidden" name="_token" class="_token" value="{{ csrf_token() }}" />

<div class="panel panel-flat">
    <div class="panel-heading">
        <h4 class="panel-titletext-bold"><b>Data Cuti Pegawai</b></h4>
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
	var gCutiTahunan = 0;
	var gCutiSakit = 0;
	var gCutiBesar = 0;
	var gCutiBersalin = 0;
	var gCutiAlasanPenting = 0;
	var gCutiLuarTanggungJawab = 0;
    $(document).ready(function(){

    	$("#periode").datepicker('update', "{{ $ctl_periode }}");
    	$("#periode").on('changeDate', function(selected){
            filter();
        });

    	var dataJSON = "{{ $ctl_data }}";
        var dataJSON2 = parseToString(dataJSON);
        var data = JSON.parse(dataJSON2);
        for (var i = 0; i < data.length; i++){
        	if(data[i]["CUTI_ALASAN"] == "CUTI_TAHUNAN"){
        		gCutiTahunan += data[i]["CUTI_JUMLAH"];
        	}else if(data[i]["CUTI_ALASAN"] == "CUTI_SAKIT"){
        		gCutiSakit += data[i]["CUTI_JUMLAH"];
        	}else if(data[i]["CUTI_ALASAN"] == "CUTI_BESAR"){
        		gCutiBesar += data[i]["CUTI_JUMLAH"];
        	}else if(data[i]["CUTI_ALASAN"] == "CUTI_BERSALIN"){
        		gCutiBersalin += data[i]["CUTI_JUMLAH"];
        	}else if(data[i]["CUTI_ALASAN"] == "CUTI_ALASAN_PENTING"){
        		gCutiAlasanPenting += data[i]["CUTI_JUMLAH"];
        	}else if(data[i]["CUTI_ALASAN"] == "CUTI_LUAR_TANGGUNG_JAWAB"){
        		gCutiLuarTanggungJawab += data[i]["CUTI_JUMLAH"];
        	}
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
	                    data: ['Cuti Tahunan', 'Cuti Sakit', 'Cuti Besar', 'Cuti Bersalin', 'Cuti Alasan Penting', 'Cuti Luar Tanggung Jawab Negara']
	                },

	                // Enable drag recalculate
	                calculable: true,

	                // Horizontal axis
	                xAxis: [{
	                    type: 'category',
	                    data: [bulanIndo("{{ $ctl_periode }}")]
	                    //data: gArrAlasan_
	                }],

	                // Vertical axis
	                yAxis: [{
	                    type: 'value'
	                }],

	                // Add series
	                series: [
	                    {
	                        name: 'Cuti Tahunan',
	                        type: 'bar',
	                        data: [gCutiTahunan],
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
	                        name: 'Cuti Sakit',
	                        type: 'bar',
	                        data: [gCutiSakit],
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
	                        name: 'Cuti Besar',
	                        type: 'bar',
	                        data: [gCutiBesar],
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
	                        name: 'Cuti Bersalin',
	                        type: 'bar',
	                        data: [gCutiBersalin],
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
	                        name: 'Cuti Alasan Penting',
	                        type: 'bar',
	                        data: [gCutiAlasanPenting],
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
	                        name: 'Cuti Luar Tanggung Jawab Negara',
	                        type: 'bar',
	                        data: [gCutiLuarTanggungJawab],
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
