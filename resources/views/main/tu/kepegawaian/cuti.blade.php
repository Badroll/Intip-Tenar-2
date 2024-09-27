@extends('master')

@section('style')
@stop

@section('breadcrumb')
<div class="page-header">
    <div class="breadcrumb-line breadcrumb-line-wide">
        <ul class="breadcrumb">
            <li><a href="{{ url('main') }}">Beranda</a></li>
            <li>Input</li>
            <li>Tata Usaha</li>
            <li>Urusan Kepegawaian</li>
            <li class="active"> Data Cuti Pegawai</li>
        </ul>
    </div>
    <br>
</div>
@stop

@section('content')
<input type="hidden" name="_token" class="_token" value="{{ csrf_token() }}" />

<div class="panel panel-flat">
    <div class="panel-heading">
        <h4 class="panel-titletext-bold"><b>DATA CUTI PEGAWAI</b></h4>
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
        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th style="text-align:left;" class="text-bold">ALASAN</th>
                    <th style="text-align:left;" class="text-bold">JUMLAH</th>
                    <th style="text-align:left;" class="text-bold">KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                @if(count($ctl_data) > 0)
                    @php
                        $sum_CUTI_JUMLAH = 0;
                    @endphp
                    @foreach($ctl_data as $aData)
                        @php
                            $sum_CUTI_JUMLAH += $aData->CUTI_JUMLAH;

                        @endphp
                        <tr>
                            <td>
                                {{ Helper::getReferenceInfo("ALASAN_CUTI", $aData->CUTI_ALASAN) }}
                            </td>
                            <td>
                                <input type="text" class="form-control" value="{{ $aData->CUTI_JUMLAH }}" id="jumlah_{{ $aData->CUTI_ID }}">
                            </td>
                            <td>
                                <input type="text" class="form-control" value="{{ $aData->CUTI_KETERANGAN }}" id="keterangan_{{ $aData->CUTI_ID }}">
                            </td>
                        </tr>
                    @endforeach
                        <tr style="font-weight: bold;">
                            <td>TOTAL</td>
                            <td><input type="text" class="form-control text-bold" value="{{ $sum_CUTI_JUMLAH }}" disabled></td>
                            <td>&nbsp;</td>
                        </tr>
                @else
                @endif
            </tbody>
        </table>
    </div>
</div>         
                
@stop

@section('script')
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
            arrId.push(data[i]["CUTI_ID"]);
        }

        gArrId = arrId;

    });


    function filter(){
        var periode = $("#periode").val();
        window.location = "{{ url('main/'.Helper::allUri(4)) }}?periode="+periode
    }


    function simpan(id){
        
        
        var arrData = [];
        for (var i = 0; i < gArrId.length; i++){
            var id = gArrId[i];
            var data = {
                CUTI_ID : id,
                CUTI_JUMLAH : $("#jumlah_" + id).val(),
                CUTI_KETERANGAN : $("#keterangan_" + id).val().replaceAll('"', "'")
            }
            arrData.push(data);
        }

        var formData = new FormData();
        formData.append("data", JSON.stringify(arrData));
        formData.append("_token", "{{ csrf_token() }}");

        createOverlay("Proses...");
        $.ajax({
            type  : "POST",
            url   : "{{ url('main/'.Helper::allUri(4).'/update') }}",
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
