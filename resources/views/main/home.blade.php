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
        </ul>
    </div>
    <br>
</div>
@stop

@section('content')
<input type="hidden" name="_token" class="_token" value="{{ csrf_token() }}" />

<div class="panel panel-flat">
    <div class="panel-heading">
        <h4 class="panel-titletext-bold"><b>SUMMARY DATA GRAFIK BULANAN</b></h4>
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
    <hr>

    <br>
    <div class="panel-body">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-flat">
					<div class="panel-body">
						<div class="chart-container has-scroll">
							<div class="chart has-fixed-height has-minimum-width" id="basic_pie"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-flat">
					<div class="panel-body">
						<div class="chart-container has-scroll">
							<div class="chart has-fixed-height has-minimum-width" id="rose_diagram_visible2"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-flat">
					<div class="panel-body">
						<div class="chart-container has-scroll">
							<div class="chart has-fixed-height has-minimum-width" id="rose_diagram_visible"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<br>
		<div class="chart-container">
			<h4>LAPORAN REALISASI BELANJA</h4>
			<div class="chart has-fixed-height" id="basic_columns"></div>
		</div>
		<br>
		<div class="chart-container">
			<h4>LAPORAN RELISASI PENDAPATAN</h4>
			<div class="chart has-fixed-height" id="basic_bars"></div>
		</div>
	</div>

</div>
@stop

@section('script')
<script type="text/javascript">
	var gTupoksiArrJenis_ = [];
	// var gTupoksiArrJumlah = [];
	var gTupoksiArrData = [];

	var gPldpArrNegara_ = [];
	// var gPldpArrJumlah = [];
	var gPldpArrData = [];

	var gPldp_ArrNegara_ = [];
	var gPldp_ArrData = [];

	var gRmArrJenis_ = [];
	var gRmArrPagu = [];
	var gRmArrTarget = [];
	var gRmArrRelisasi = [];
	var gRmArrSisa = [];

	var gPnpArrUraian_ = [];
	var gPnpArrJumlah = [];
	var gPnpArrTarget = [];
	var gPnpArrRelisasi = [];
	var gPnpArrSisa = [];

    $(document).ready(function(){

    	try {

	    	$("#periode").datepicker('update', "{{ $ctl_periode }}");
	    	$("#periode").on('changeDate', function(selected){
	            filter();
	        });

	        var dataJSON = "{{ $ctl_pldp }}";
	        console.log(dataJSON);
	        var dataJSON2 = parseToString(dataJSON);
	        console.log(dataJSON2);
	        var data = JSON.parse(dataJSON2);
	        for (var i = 0; i < data.length; i++){
	        	gPldpArrNegara_.push(data[i]["NGR_NAMA"]);
	        	// gPldpArrJumlah.push(data[i]["PLDP_LAKI"] + data[i]["PLDP_PEREMPUAN"]);
	        	gPldpArrData.push( { value : data[i]["PLDP_LAKI"] + data[i]["PLDP_PEREMPUAN"], name : data[i]["NGR_NAMA"]} );
	        }
	        console.log(data);

	        dataJSON = "{{ $ctl_pldp_ }}";
	        dataJSON2 = parseToString(dataJSON);
	        data = JSON.parse(dataJSON2);
	        for (var i = 0; i < data.length; i++){
	        	gPldp_ArrNegara_.push(data[i]["NGR_NAMA"]);
	        	// gPldpArrJumlah.push(data[i]["PLDP_LAKI"] + data[i]["PLDP_PEREMPUAN"]);
	        	gPldp_ArrData.push( { value : data[i]["PLDP_LAKI"] + data[i]["PLDP_PEREMPUAN"], name : data[i]["NGR_NAMA"]} );
	        }
	        console.log(data);

	        dataJSON = "{{ $ctl_tupoksi }}";
	        dataJSON2 = parseToString(dataJSON);
	        data = JSON.parse(dataJSON2);
	        for (var i = 0; i < data.length; i++){
	        	gTupoksiArrJenis_.push(data[i]["R_INFO"]);
	        	// gTupoksiArrJumlah.push(data[i]["TPKS_LAKI"] + data[i]["TPKS_PEREMPUAN"]);
	        	gTupoksiArrData.push( { value : data[i]["TPKS_LAKI"] + data[i]["TPKS_PEREMPUAN"], name : data[i]["R_INFO"]} );
	        }
	        console.log(data);

	        dataJSON = "{{ $ctl_rm }}";
	        dataJSON2 = parseToString(dataJSON);
	        data = JSON.parse(dataJSON2);
	        for (var i = 0; i < data.length; i++){
	        	gRmArrJenis_.push(data[i]["R_INFO"]);
	        	gRmArrPagu.push(data[i]["RM_PAGU"]);
	        	gRmArrTarget.push(data[i]["RM_TARGET_RP"]);
	        	gRmArrRelisasi.push(data[i]["RM_REALISASI_RP"]);
	        	gRmArrSisa.push(data[i]["RM_SISA_DANA"]);
	        }
	        console.log(data);

	        dataJSON = "{{ $ctl_pnp }}";
	        dataJSON2 = parseToString(dataJSON);
	        data = JSON.parse(dataJSON2);
	        for (var i = 0; i < data.length; i++){
	        	gPnpArrUraian_.push(data[i]["R_INFO"].replaceAll(" ", "\n"));
	        	gPnpArrJumlah.push(data[i]["PNP_JUMLAH"]);
	        }
	        console.log(data);

		}catch(err){
			//
		}

    });

    function filter(){
    	var periode = $("#periode").val();
    	window.location = "{{ url('main/'.Helper::allUri(4)) }}?periode="+periode
    }

    try{
    	//
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
		            'echarts/chart/pie',
		            'echarts/chart/funnel',
		            'echarts/chart/bar',
		            'echarts/chart/line'
		        ],


		        // Charts setup
		        function (ec, limitless) {
		            var basic_pie = ec.init(document.getElementById('basic_pie'), limitless);
		            var rose_diagram_visible = ec.init(document.getElementById('rose_diagram_visible'), limitless);
		            var rose_diagram_visible2 = ec.init(document.getElementById('rose_diagram_visible2'), limitless);
		            var basic_columns = ec.init(document.getElementById('basic_columns'), limitless);
		            var basic_bars = ec.init(document.getElementById('basic_bars'), limitless);

		            basic_pie_options = {

		                // Add title
		                title: {
		                    text: 'PENERIMAAN LAYANAN DETENI',
		                    // subtext: 'Open source information',
		                    x: 'center'
		                },

		                // Add tooltip
		                tooltip: {
		                    trigger: 'item',
		                    formatter: "{a} <br/>{b}: {c} ({d}%)"
		                },

		                // Add legend
		                legend: {
		                    orient: 'vertical',
		                    x: 'left',
		                    data: (gPldpArrNegara_.length > 0) ? gPldpArrNegara_ : ["Jumlah"]
		                },

		                // Display toolbox
		                toolbox: {
		                    show: true,
		                    orient: 'vertical',
		                    feature: {
		                        mark: {
		                            show: true,
		                            title: {
		                                mark: 'Markline switch',
		                                markUndo: 'Undo markline',
		                                markClear: 'Clear markline'
		                            }
		                        },
		                        dataView: {
		                            show: true,
		                            readOnly: false,
		                            title: 'View data',
		                            lang: ['View chart data', 'Close', 'Update']
		                        },
		                        magicType: {
		                            show: true,
		                            title: {
		                                pie: 'Switch to pies',
		                                funnel: 'Switch to funnel',
		                            },
		                            type: ['pie', 'funnel'],
		                            option: {
		                                funnel: {
		                                    x: '25%',
		                                    y: '20%',
		                                    width: '50%',
		                                    height: '70%',
		                                    funnelAlign: 'left',
		                                    max: 1548
		                                }
		                            }
		                        },
		                        restore: {
		                            show: true,
		                            title: 'Restore'
		                        },
		                        saveAsImage: {
		                            show: true,
		                            title: 'Same as image',
		                            lang: ['Save']
		                        }
		                    }
		                },

		                // Enable drag recalculate
		                calculable: true,

		                // Add series
		                series: [{
		                    name: 'PLD',
		                    type: 'pie',
		                    radius: '70%',
		                    center: ['50%', '57.5%'],
		                    data: (gPldpArrData.length > 0) ? gPldpArrData : [{ value : 0, name : "Jumlah"}]
		                }]
		            };

		            rose_diagram_visible_options = {

		                // Add title
		                title: {
		                    text: 'TUPOKSI',
		                    // subtext: 'Senior front end developer',
		                    x: 'center'
		                },

		                // Add tooltip
		                tooltip: {
		                    trigger: 'item',
		                    formatter: "{a} <br/>{b}: {c} ({d}%)"
		                },

		                // Add legend
		                legend: {
		                    x: 'left',
		                    y: 'top',
		                    orient: 'vertical',
		                    data: gTupoksiArrJenis_
		                },

		                // Display toolbox
		                toolbox: {
		                    show: true,
		                    orient: 'vertical',
		                    feature: {
		                        mark: {
		                            show: true,
		                            title: {
		                                mark: 'Markline switch',
		                                markUndo: 'Undo markline',
		                                markClear: 'Clear markline'
		                            }
		                        },
		                        dataView: {
		                            show: true,
		                            readOnly: false,
		                            title: 'View data',
		                            lang: ['View chart data', 'Close', 'Update']
		                        },
		                        magicType: {
		                            show: true,
		                            title: {
		                                pie: 'Switch to pies',
		                                funnel: 'Switch to funnel',
		                            },
		                            type: ['pie', 'funnel']
		                        },
		                        restore: {
		                            show: true,
		                            title: 'Restore'
		                        },
		                        saveAsImage: {
		                            show: true,
		                            title: 'Same as image',
		                            lang: ['Save']
		                        }
		                    }
		                },

		                // Enable drag recalculate
		                calculable: true,

		                // Add series
		                series: [
		                    {
		                        name: 'Tupoksi',
		                        type: 'pie',
		                        radius: ['15%', '73%'],
		                        center: ['50%', '57%'],
		                        roseType: 'area',

		                        // Funnel
		                        width: '40%',
		                        height: '78%',
		                        x: '30%',
		                        y: '17.5%',
		                        max: 450,
		                        sort: 'ascending',

		                        data: gTupoksiArrData
		                    }
		                ]
		            };

		            rose_diagram_visible2_options = {

		                // Add title
		                title: {
		                    text: 'PENERIMAAN LAYANAN PENGUNGSI',
		                    // subtext: 'Senior front end developer',
		                    x: 'center'
		                },

		                // Add tooltip
		                tooltip: {
		                    trigger: 'item',
		                    formatter: "{a} <br/>{b}: {c} ({d}%)"
		                },

		                // Add legend
		                legend: {
		                    x: 'left',
		                    y: 'top',
		                    orient: 'vertical',
		                    data: (gPldp_ArrNegara_.length > 0) ? gPldp_ArrNegara_ : ["Jumlah"]
		                },

		                // Display toolbox
		                toolbox: {
		                    show: true,
		                    orient: 'vertical',
		                    feature: {
		                        mark: {
		                            show: true,
		                            title: {
		                                mark: 'Markline switch',
		                                markUndo: 'Undo markline',
		                                markClear: 'Clear markline'
		                            }
		                        },
		                        dataView: {
		                            show: true,
		                            readOnly: false,
		                            title: 'View data',
		                            lang: ['View chart data', 'Close', 'Update']
		                        },
		                        magicType: {
		                            show: true,
		                            title: {
		                                pie: 'Switch to pies',
		                                funnel: 'Switch to funnel',
		                            },
		                            type: ['pie', 'funnel']
		                        },
		                        restore: {
		                            show: true,
		                            title: 'Restore'
		                        },
		                        saveAsImage: {
		                            show: true,
		                            title: 'Same as image',
		                            lang: ['Save']
		                        }
		                    }
		                },

		                // Enable drag recalculate
		                calculable: true,

		                // Add series
		                series: [
		                    {
		                        name: 'PLP',
		                        type: 'pie',
		                        radius: ['15%', '73%'],
		                        center: ['50%', '57%'],
		                        roseType: 'area',

		                        // Funnel
		                        width: '40%',
		                        height: '78%',
		                        x: '30%',
		                        y: '17.5%',
		                        max: 450,
		                        sort: 'ascending',

		                        data: (gPldp_ArrData.length > 0) ? gPldp_ArrData : [{ value : 0, name : "Jumlah"}]
		                    }
		                ]
		            };

		            console.log(gRmArrJenis_);
		            console.log(gRmArrPagu);

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
		                    data: gRmArrJenis_
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
		                        data: gRmArrPagu,
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
		                        data: gRmArrTarget,
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
		                        data: gRmArrRelisasi,
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
		                        data: gRmArrSisa,
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

		            basic_bars_options = {

		                // Setup grid
		                grid: {
		                    x: 95,
		                    x2: 35,
		                    y: 35,
		                    y2: 25
		                },

		                // Add tooltip
		                tooltip: {
		                    trigger: 'axis',
		                    axisPointer: {
		                        type: 'shadow'
		                    }
		                },

		                // Add legend
		                legend: {
		                    data: ['Jumlah']
		                },

		                // Enable drag recalculate
		                calculable: true,

		                // Horizontal axis
		                xAxis: [{
		                    type: 'value',
		                    boundaryGap: [0, 0.01]
		                }],

		                // Vertical axis
		                yAxis: [{
		                    type: 'category',
		                    data: gPnpArrUraian_
		                }],

		                // Add series
		                series: [
		                    {
		                        name: 'Jumlah',
		                        type: 'bar',
		                        itemStyle: {
		                            normal: {
		                                color: '#2EC7C9'
		                            }
		                        },
		                        data: gPnpArrJumlah
		                    }
		                ]
		            };

		            basic_pie.setOption(basic_pie_options);
		            rose_diagram_visible.setOption(rose_diagram_visible_options);
		            rose_diagram_visible2.setOption(rose_diagram_visible2_options);
		            basic_columns.setOption(basic_columns_options);
		            basic_bars.setOption(basic_bars_options);

		            window.onresize = function () {
		                setTimeout(function () {
		                    basic_pie.resize();
		                    rose_diagram_visible.resize();
		                    rose_diagram_visible2.resize();
		                    basic_columns.resize();
		                    basic_bars.resize();
		                }, 200);
		            }
		        }
		    );
		});

	}catch(err){
		//
	}


</script>
@stop
