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
            <li class="active">Indikator Kinerja Pelaksanaan Anggaran (IKPA)</li>
        </ul>
    </div>
    <br>
</div>
@stop

@section('content')
<input type="hidden" name="_token" class="_token" value="{{ csrf_token() }}" />

<div class="panel panel-flat">
    <div class="panel-heading">
        <h4 class="panel-titletext-bold"><b>INDIKATOR KINERJA PELAKSANAAN ANGGARAN (IKPA)</b></h4>
        <br>
        <div class="form-group">
            <label class="control-label col-lg-1">Periode</label>
            <div class="col-lg-10">
                <div class="row">
                    <div class="col-md-4">
                        <input class="form-control force-number" id="periode" />
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
	var gArrData = [ {NO : "01",BULAN : "Januari",NILAI_AKHIR : 0.0},
					{NO : "02",BULAN : "Febuari",NILAI_AKHIR : 0.0},
					{NO : "03",BULAN : "Maret",NILAI_AKHIR : 0.0},
					{NO : "04",BULAN : "April",NILAI_AKHIR : 0.0},
					{NO : "05",BULAN : "Mei",NILAI_AKHIR : 0.0},
					{NO : "06",BULAN : "Juni",NILAI_AKHIR : 0.0},
					{NO : "07",BULAN : "Juli",NILAI_AKHIR : 0.0},
					{NO : "08",BULAN : "Agustus",NILAI_AKHIR : 0.0},
					{NO : "09",BULAN : "September",NILAI_AKHIR : 0.0},
					{NO : "10",BULAN : "Oktober",NILAI_AKHIR : 0.0},
					{NO : "11",BULAN : "November",NILAI_AKHIR : 0.0},
					{NO : "12",BULAN : "Desember",NILAI_AKHIR : 0.0}
	];


    $(document).ready(function(){

    	$("#periode").val( "{{ $ctl_periode }}");
    	$("#periode").focusout(function(){
    		filter();
    	});

    	var dataJSON = "{{ $ctl_data }}";
        var dataJSON2 = parseToString(dataJSON);
        var data = JSON.parse(dataJSON2);
        for (var i = 0; i < data.length; i++){
        	var prd = data[i]["IKPA_PERIODE"].split("-");
        	for (var i2 = 0; i2 < gArrData.length; i2++){
        		if(gArrData[i2]["NO"] == prd[1]){
        			gArrData[i2]["NILAI_AKHIR"] = data[i]["IKPA_NILAI_AKHIR"];
        		}
        	}
        }

        console.log(gArrData);

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
	                    data: ['Nilai Akhir']
	                },

	                // Enable drag recalculate
	                calculable: true,

	                // Horizontal axis
	                xAxis: [{
	                    type: 'category',
	                    data: [ gArrData[0]["BULAN"],
	                    		gArrData[1]["BULAN"],
	                    		gArrData[2]["BULAN"],
	                    		gArrData[3]["BULAN"],
	                    		gArrData[4]["BULAN"],
	                    		gArrData[5]["BULAN"],
	                    		gArrData[6]["BULAN"],
	                    		gArrData[7]["BULAN"],
	                    		gArrData[8]["BULAN"],
	                    		gArrData[9]["BULAN"],
	                    		gArrData[10]["BULAN"],
	                    		gArrData[11]["BULAN"] ]
	                }],

	                // Vertical axis
	                yAxis: [{
	                    type: 'value'
	                }],

	                // Add series
	                series: [
	                    {
	                        name: 'Nilai Akhir',
	                        type: 'bar',
	                        data: [gArrData[0]["NILAI_AKHIR"],
	                        		gArrData[1]["NILAI_AKHIR"],
	                        		gArrData[2]["NILAI_AKHIR"],
	                        		gArrData[3]["NILAI_AKHIR"],
	                        		gArrData[4]["NILAI_AKHIR"],
	                        		gArrData[5]["NILAI_AKHIR"],
	                        		gArrData[6]["NILAI_AKHIR"],
	                        		gArrData[7]["NILAI_AKHIR"],
	                        		gArrData[8]["NILAI_AKHIR"],
	                        		gArrData[9]["NILAI_AKHIR"],
	                        		gArrData[10]["NILAI_AKHIR"],
	                        		gArrData[11]["NILAI_AKHIR"]],
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
