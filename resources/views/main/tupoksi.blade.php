@extends('master')

@section('style')<!-- 
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"> --><!-- 
<link rel="stylesheet" type="text/css" href="{!! url('/') !!}/lib/js/plugins/datatables/dataTables.bootstrap.css"> -->
@stop

@section('breadcrumb')
<div class="page-header">
    <div class="breadcrumb-line breadcrumb-line-wide">
        <ul class="breadcrumb">
            <li><a href="{{ url('main') }}">Beranda</a></li>
            <li>Input</li>
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

        <div class="toggle-show">
            <div class="text-right">
                <button type="button" class="btn bg-green-700 btn-labeled btn-labeled-right ml-10" onclick="simpan()" id="btnSave"><b><i class="icon-check"></i></b> Simpan</button>
            </div>
        </div>

    </div>

    <div class="panel-body">
        <table class="table datatable-basic" style="width: 100%;">
            <thead>
                <tr>
                    <th style="text-align:left;" class="text-bold" style="width: 25%;">JENIS TUPOKSI</th>
                    <th style="text-align:left;" class="text-bold" style="width: 25%;">LAKI-LAKI</th>
                    <th style="text-align:left;" class="text-bold" style="width: 25%;">PEREMPUAN</th>
                    <th style="text-align:left;" class="text-bold" style="width: 25%;">JUMLAH</th>
                </tr>
            </thead>
            <tbody>
                @if(count($ctl_data) > 0)
                    @foreach($ctl_data as $aData)
                    <tr>
                        <td style="width: 25%;">
                            {{ Helper::getReferenceInfo("JENIS_TUPOKSI", $aData->TPKS_JENIS) }}
                        </td>
                        <td style="width: 25%;">
                            <input type="text" class="form-control force-number summary-trigger" value="{{ $aData->TPKS_LAKI }}" id="laki_{{ $aData->TPKS_ID }}">
                        </td>
                        <td style="width: 25%;">
                            <input type="text" class="form-control force-number summary-trigger" value="{{ $aData->TPKS_PEREMPUAN }}" id="perempuan_{{ $aData->TPKS_ID }}">
                        </td>
                        <td style="width: 25%;">
                            <input type="text" class="form-control text-bold" value="{{ $aData->TPKS_LAKI + $aData->TPKS_PEREMPUAN }}" disabled id="jumlah_{{ $aData->TPKS_ID }}">
                        </td>
                    </tr>
                    @endforeach
                @else
                @endif
            </tbody>
        </table>
    </div>
</div>
@stop

@section('script')<!-- 
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> --> <!-- 
<script type="text/javascript" src="{!! url('/') !!}/lib/js/plugins/tables/datatables/datatables.min.js"></script> -->
<script type="text/javascript">

    var gArrId;

    $(document).ready(function(){

        $("#periode").datepicker('update', "{{ $ctl_periode }}");
        $("#periode").on('changeDate', function(selected){
            filter();
        });

        // setup data
        var dataJSON = "{{ $ctl_data }}";
        var dataJSON2 = parseToString(dataJSON);
        var data = JSON.parse(dataJSON2);

        if(data.length < 1){
            $("#btnSave").attr("disabled", "");
        }

        var arrId = [];
        for (var i = 0; i < data.length; i++){
            arrId.push(data[i]["TPKS_ID"]);
        }

        gArrId = arrId;


        $(".summary-trigger").focusout(function(){
            // for (var i = 0; i < gArrId.length; i++){
            //     summaryTrigger([ "laki_"+gArrId[i], "perempuan_"+gArrId[i] ], "jumlah_"+gArrId[i]);
            // }
        });

    });


    function filter(){
        var periode = $("#periode").val();
        window.location = "{{ url('main/'.Helper::uri2()) }}?periode="+periode
    }


    function simpan(id){
        var arrData = [];
        for (var i = 0; i < gArrId.length; i++){
            var id = gArrId[i];
            var data = {
                TPKS_ID : id,
                TPKS_LAKI : $("#laki_" + id).val(),
                TPKS_PEREMPUAN : $("#perempuan_" + id).val()
            }
            if(
                data.TPKS_LAKI.trim() == "" ||
                data.TPKS_PEREMPUAN.trim() == ""
                ){
                notify("e", "Mohon lengkapi isian");
                return;
            }
            arrData.push(data);
        }

        var formData = new FormData();
        formData.append("data", JSON.stringify(arrData));
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
