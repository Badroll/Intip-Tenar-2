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
            <li>Input</li>
            <li class="active">Penerimaan Layanan Deteni</li>
        </ul>
    </div>
    <br>
</div>
@stop

@section('content')
<input type="hidden" name="_token" class="_token" value="{{ csrf_token() }}" />

<div class="panel panel-flat">
    <div class="panel-heading">
        <h4 class="panel-titletext-bold"><b>PENERIMAAN LAYANAN DETENI</b></h4>
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
        <div class="toggle-show">
            <hr>
            <div class="col-lg-12">
                <form class="form-horizontal" method="post">
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Kewarganegaraan</label>
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-md-4">
                                    <select class="select" id="negara" onchange="filter()">
                                        <option value="__PILIH__">-- Pilih Negara --</option>
                                        @foreach($ctl_refNegara as $aData)
                                            <option value="{{ $aData->NGR_KODE }}" 
                                                @if($aData->NGR_KODE == $ctl_negara)
                                                {{ "selected" }}
                                                @endif 
                                            >
                                            {{ $aData->NGR_NAMA }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Laki-laki</label>
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" class="form-control force-number summary-trigger" value="{{ (isset($ctl_data)) ? $ctl_data->PLDP_LAKI : '0' }}" id="laki">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Perempuan</label>
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" class="form-control force-number summary-trigger" value="{{ (isset($ctl_data)) ? $ctl_data->PLDP_PEREMPUAN : '0' }}" id="perempuan">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <label class="col-lg-2 control-label">Jumlah</label>
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" class="form-control text-bold" value="{{ (isset($ctl_data)) ? $ctl_data->PLDP_LAKI + $ctl_data->PLDP_PEREMPUAN : '0' }}" disabled id="jumlah">
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div class="text-right">
                        <button type="button" class="btn bg-green-700 btn-labeled btn-labeled-right ml-10" onclick="simpan()"><b><i class="icon-check"></i></b> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        
	    <table class="table datatable-basic">
	        <thead>
	            <tr>
	                <th style="text-align:left;" class="text-bold">KEWARGANEGARAAN</th>
	                <th style="text-align:left;" class="text-bold">LAKI-LAKI</th>
	                <th style="text-align:left;" class="text-bold">PEREMPUAN</th>
	                <th style="text-align:left;" class="text-bold">JUMLAH</th>
	            </tr>
	        </thead>
	        <tbody>
                @if(count($ctl_dataAll) > 0)
                    @foreach($ctl_dataAll as $aData)
        	            <tr>
        	                <!-- <td>
        	                    <select class="select" id="negara" onchange="filter()" disabled>
                                    <option value="__PILIH__">-- Pilih Negara --</option>
                                    @foreach($ctl_refNegara as $aData2)
                                    	<option value="{{ $aData2->NGR_KODE }}" 
                                    		@if($aData2->NGR_KODE == $aData->PLDP_NEGARA)
                                    		{{ "selected" }}
                                    		@endif 
                                    	>
                                    	{{ $aData2->NGR_NAMA }}
                                    </option>
                                    @endforeach
                              	</select>
        	                </td> -->
                            <td>
                                {{ $aData->NGR_NAMA }}
                            </td>
        	                <td>
        	                  	<input type="text" class="form-control force-number summary-trigger" value="{{ $aData->PLDP_LAKI }}" disabled>
        	                </td>
        	                <td>
        	                  	<input type="text" class="form-control force-number summary-trigger" value="{{ $aData->PLDP_PEREMPUAN }}" disabled>
        	                </td>
        	                <td>
        	                  	<input type="text" class="form-control text-bold" value="{{ $aData->PLDP_LAKI + $aData->PLDP_PEREMPUAN }}" disabled>
        	                </td>
        	            </tr>
                    @endforeach
                @endif
	        </tbody>
	    </table>
  	</div>
</div>
@stop

@section('script')
<script type="text/javascript">
    $(document).ready(function(){

        $("#periode").datepicker('update', "{{ $ctl_periode }}");
        $("#periode").on('changeDate', function(selected){
            filter();
        });

        $(".summary-trigger").focusout(function(){
            // summaryTrigger(["laki", "perempuan"], "jumlah");
        });

    });


    function filter(){
    	var periode = $("#periode").val();
    	var negara = $("#negara").val();
    	window.location = "{{ url('main/'.Helper::uri2()) }}?negara="+negara+"&periode="+periode
    }


    function simpan(){
    	var periode = $("#periode").val();
    	var negara = $("#negara").val();
    	var laki = $("#laki").val();
    	var perempuan = $("#perempuan").val();

    	var formData = new FormData();
    	formData.append("periode", periode);
    	formData.append("negara", negara);
    	formData.append("laki", laki);
    	formData.append("perempuan", perempuan);
        formData.append("_token", "{{ csrf_token() }}");

        createOverlay("Proses...");
        $.ajax({
            type  : "POST",
            url   : "{{ url('main/'.Helper::uri2().'/update') }}",
            cache: false,
            contentType: false,
            processData: false,
            data  : formData,
            success : function(data) {
                gOverlay.hide();
                if(data["STATUS"] == "SUCCESS") {
                    notify("s", data["MESSAGE"]);
                    delayReload();
                }
                else notify("e", data["MESSAGE"]);
            },
            error : function(error) {
            	gOverlay.hide();
                notify("e", "Network/server error\r\n" + error);
            }
        });
    }

</script>
@stop
