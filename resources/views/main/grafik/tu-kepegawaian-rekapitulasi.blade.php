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
            <li>Urusan Kepegawaian</li>
            <li class="active">Rekapitulasi Pegawai</li>
        </ul>
    </div>
    <br>
</div>
@stop

@section('content')
<input type="hidden" name="_token" class="_token" value="{{ csrf_token() }}" />

<div class="panel panel-flat">
    <div class="panel-heading">
        <h4 class="panel-titletext-bold"><b>REKAPITULASI PEGAWAI</b></h4>
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

		<hr>
		<br>
		<h5>Pegawai Pemerintah Non Pegawai Negeri</h5>
		<br>

		<div class="chart-container">
			<div class="chart has-fixed-height" id="basic_columns2"></div>
		</div>
	</div>

</div>
@stop

@section('script')
<script type="text/javascript">
	var gArrGolongan_ = [];
	var gArrPangkatA = [];
	var gArrPangkatB = [];
	var gArrPangkatC = [];
	var gArrPangkatD = [];
	var gArrTeknisL = [];
	var gArrTeknisP = [];
	var gArrNonteknisL = [];
	var gArrNonteknisP = [];
	var gArrStruktrualL = [];
	var gArrStruktrualP = [];
	var gArrNonstruktrualL = [];
	var gArrNonstruktrualP = [];

	var gArrJenis_ = [];
	var gArrL = [];
	var gArrP = [];
    $(document).ready(function(){

    	$("#periode").datepicker('update', "{{ $ctl_periode }}");
    	$("#periode").on('changeDate', function(selected){
            filter();
        });

    	var dataJSON = "{{ $ctl_data }}";
        var dataJSON2 = parseToString(dataJSON);
        var data = JSON.parse(dataJSON2);
        for (var i = 0; i < data.length; i++){
        	gArrGolongan_.push(data[i]["REKP_GOLONGAN_"]);
        	gArrPangkatA.push(data[i]["REKP_PANGKAT_A"]);
        	gArrPangkatB.push(data[i]["REKP_PANGKAT_B"]);
        	gArrPangkatC.push(data[i]["REKP_PANGKAT_C"]);
        	gArrPangkatD.push(data[i]["REKP_PANGKAT_D"]);
        	gArrTeknisL.push(data[i]["REKP_TEKNIS_LAKI"]);
        	gArrTeknisP.push(data[i]["REKP_TEKNIS_PEREMPUAN"]);
        	gArrNonteknisL.push(data[i]["REKP_NONTEKNIS_LAKI"]);
        	gArrNonteknisP.push(data[i]["REKP_NONTEKNIS_PEREMPUAN"]);
        	gArrStruktrualL.push(data[i]["REKP_STRUKTURAL_LAKI"]);
        	gArrStruktrualP.push(data[i]["REKP_STRUKTURAL_PEREMPUAN"]);
        	gArrNonstruktrualL.push(data[i]["REKP_NONSTRUKTURAL_LAKI"]);
        	gArrNonstruktrualP.push(data[i]["REKP_NONSTRUKTURAL_PEREMPUAN"]);
        }

        dataJSON = "{{ $ctl_data2 }}";
        dataJSON2 = parseToString(dataJSON);
        data = JSON.parse(dataJSON2);
        for (var i = 0; i < data.length; i++){
        	gArrJenis_.push(data[i]["REKP_JENIS_"]);
        	gArrL.push(data[i]["REKP_LAKI"]);
        	gArrP.push(data[i]["REKP_PEREMPUAN"]);
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
	            var basic_columns2 = ec.init(document.getElementById('basic_columns2'), limitless);

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
	                    data: ['Pangkat A', 'Pangkat B', 'Pangkat C', 'Pangkat D', 'Teknis L', 'Teknis P', 'Non Teknis L', 'Non Teknis P', 'Struktural L', 'Struktural P', 'Non Struktural L', 'Non Struktural P']
	                },

	                // Enable drag recalculate
	                calculable: true,

	                // Horizontal axis
	                xAxis: [{
	                    type: 'category',
	                    data: gArrGolongan_
	                }],

	                // Vertical axis
	                yAxis: [{
	                    type: 'value'
	                }],

	                // Add series
	                series: [
	                    {
	                        name: 'Pangkat A',
	                        type: 'bar',
	                        data: gArrPangkatA,
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
	                        name: 'Pangkat B',
	                        type: 'bar',
	                        data: gArrPangkatB,
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
	                        name: 'Pangkat C',
	                        type: 'bar',
	                        data: gArrPangkatC,
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
	                        name: 'Pangkat D',
	                        type: 'bar',
	                        data: gArrPangkatD,
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
	                        name: 'Teknis L',
	                        type: 'bar',
	                        data: gArrTeknisL,
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
	                        name: 'Teknis P',
	                        type: 'bar',
	                        data: gArrTeknisP,
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
	                        name: 'Non Teknis L',
	                        type: 'bar',
	                        data: gArrNonteknisL,
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
	                        name: 'Non Teknis P',
	                        type: 'bar',
	                        data: gArrNonteknisP,
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
	                        name: 'Struktural L',
	                        type: 'bar',
	                        data: gArrStruktrualL,
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
	                        name: 'Struktural P',
	                        type: 'bar',
	                        data: gArrStruktrualP,
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
	                        name: 'Non Struktural L',
	                        type: 'bar',
	                        data: gArrNonstruktrualL,
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
	                        name: 'Non Struktural P',
	                        type: 'bar',
	                        data: gArrNonstruktrualP,
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

	            basic_columns_options2 = {

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
	                        data: gArrL,
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
	                        data: gArrP,
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
	                        data: gArrL.map(function (num, idx) {
							  return num + gArrP[idx];
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
	            basic_columns2.setOption(basic_columns_options2);

	            window.onresize = function () {
	                setTimeout(function () {
	                    basic_columns.resize();
	                    basic_columns2.resize();
	                }, 200);
	            }
	        }
	    );
	});


</script>
@stop
