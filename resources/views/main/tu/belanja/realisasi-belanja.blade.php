@extends('master')

@section('style')
<!-- 
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"> -->
@stop

@section('breadcrumb')
<div class="page-header">
    <div class="breadcrumb-line breadcrumb-line-wide">
        <ul class="breadcrumb">
            <li><a href="{{ url('main') }}">Beranda</a></li>
            <li>Input</li>
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
                    <th></th>
                    <th></th>
                    <th colspan="2" style="text-align:center;" class="text-bold">TARGET</th>
                    <th colspan="2" style="text-align:center;" class="text-bold">REALISASI</th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <th style="text-align:left;" class="text-bold">JENIS BELANJA</th>
                    <th style="text-align:left;" class="text-bold">
                        PAGU
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </th>
                    <th style="text-align:left;" class="text-bold">
                        RP
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </th>
                    <th style="text-align:left;" class="text-bold">%</th>
                    <th style="text-align:left;" class="text-bold">
                        RP
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </th>
                    <th style="text-align:left;" class="text-bold">%</th>
                    <th style="text-align:left;" class="text-bold">SISA DANA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    <th style="text-align:left;" class="text-bold">KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                @if(count($ctl_data) > 0)
                    @php
                        $sum_RM_PAGU = 0;
                        $sum_RM_TARGET_RP = 0;
                        $sum_RM_REALISASI_RP = 0;
                        $sum_RM_SISA_DANA = 0;
                    @endphp
                    @foreach($ctl_data as $aData)
                        @php
                            $sum_RM_PAGU += $aData->RM_PAGU;
                            $sum_RM_TARGET_RP += $aData->RM_TARGET_RP;
                            $sum_RM_REALISASI_RP += $aData->RM_REALISASI_RP;
                            $sum_RM_SISA_DANA += $aData->RM_SISA_DANA;
                        @endphp
                        <tr>
                            <td>
                                {{ Helper::getReferenceInfo("JENIS_BELANJA", $aData->RM_JENIS) }}
                            </td>
                            <td>
                                <input type="text" class="form-control numeric-input-idr" value="{{ $aData->RM_PAGU }}" id="pagu_{{ $aData->RM_ID }}" onchange="calculateTarget('{{ $aData->RM_ID }}'); calculateRealisasi('{{ $aData->RM_ID }}'); calculateSisa('{{ $aData->RM_ID }}');">
                            </td>
                            <td>
                                <input type="text" class="form-control numeric-input-idr" value="{{ $aData->RM_TARGET_RP }}" id="targetRp_{{ $aData->RM_ID }}" onchange="calculateTarget('{{ $aData->RM_ID }}');">
                            </td>
                            <td>
                                <input type="text" class="form-control" onkeypress="return isNumberKey(event)" value="{{ $aData->RM_TARGET_PERSEN }}" id="targetPersen_{{ $aData->RM_ID }}" disabled>
                            </td>
                            <td>
                                <input type="text" class="form-control numeric-input-idr" value="{{ $aData->RM_REALISASI_RP }}" id="realisasiRp_{{ $aData->RM_ID }}" onchange="calculateRealisasi('{{ $aData->RM_ID }}'); calculateSisa('{{ $aData->RM_ID }}');">
                            </td>
                            <td>
                                <input type="text" class="form-control" onkeypress="return isNumberKey(event)" value="{{ $aData->RM_REALISASI_PERSEN }}" id="realisasiPersen_{{ $aData->RM_ID }}" disabled>
                            </td>
                            <td>
                                <input type="text" class="form-control numeric-input-idr" value="{{ $aData->RM_SISA_DANA }}" id="sisa_{{ $aData->RM_ID }}" disabled>
                            </td>
                            <td>
                                <input type="text" class="form-control" value="{{ $aData->RM_KETERANGAN }}" id="keterangan_{{ $aData->RM_ID }}">
                            </td>
                        </tr>
                    @endforeach
                        <tr>
                            <td><b>TOTAL</b></td>
                            <td><input type="text" class="form-control text-bold numeric-input-idr" value="{{ $sum_RM_PAGU }}" disabled></td>
                            <td><input type="text" class="form-control text-bold numeric-input-idr" value="{{ $sum_RM_TARGET_RP }}" disabled></td>
                            <td><input type="text" class="form-control text-bold" id="totalPersenTarget"  disabled></td>
                            <td><input type="text" class="form-control text-bold numeric-input-idr" value="{{ $sum_RM_REALISASI_RP }}" disabled></td>
                            <td><input type="text" class="form-control text-bold" id="totalPersenRealisasi"  disabled></td>
                            <td><input type="text" class="form-control text-bold numeric-input-idr" value="{{ $sum_RM_SISA_DANA }}" disabled></td>
                            <td>&nbsp;</td>
                        </tr>
                @else
                @endif
            </tbody>
        </table>
    </div>
</div>         
                
@stop

@section('script')<!-- 
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> -->
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
        var arrPaguId = [];
        for (var i = 0; i < data.length; i++){
            arrId.push(data[i]["RM_ID"]);
        }

        gArrId = arrId;


        var sum_RM_PAGU = parseFloat("{{ $sum_RM_PAGU }}");
        var sum_RM_TARGET_RP = parseFloat("{{ $sum_RM_TARGET_RP }}");
        var sum_RM_REALISASI_RP = parseFloat("{{ $sum_RM_REALISASI_RP }}");

        if(sum_RM_TARGET_RP != 0 && sum_RM_PAGU != 0){
            var res = (sum_RM_TARGET_RP / sum_RM_PAGU) * 100;
            $("#totalPersenTarget").val(res.toFixed(2));
        }else{
            $("#totalPersenTarget").val(0);
        }

        if(sum_RM_REALISASI_RP != 0 && sum_RM_PAGU != 0){
            var res2 = (sum_RM_REALISASI_RP / sum_RM_PAGU) * 100;
            $("#totalPersenRealisasi").val(res2.toFixed(2));
        }else{
            $("#totalPersenRealisasi").val(0);
        }


        // var gArrPagu;
        // $(".summary-trigger").focusout(function(){
        //     for (var i = 0; i < gArrId.length; i++){
        //         gArrPagu.push("pagu_"+gArrId[i]);
        //     }
        //     summaryTrigger([ "pagu_"+gArrId[i], "perempuan_"+gArrId[i] ], "jumlah_"+gArrId[i]);
        // });

    });


    function filter(){
        var periode = $("#periode").val();
        window.location = "{{ url('main/'.Helper::allUri(4)) }}?periode="+periode
    }



    function calculateTarget(id){
        var pagu = parseFloat($("#pagu_"+id).autoNumeric("get"));
        var rp = parseFloat($("#targetRp_"+id).autoNumeric("get"));
        if(pagu != 0 && rp != 0){
            var res = (rp / pagu) * 100;
            $("#targetPersen_"+id).val(res.toFixed(2));
        }else{
            $("#targetPersen_"+id).val(0);
        }
    }

    function calculateRealisasi(id){
        var pagu = parseFloat($("#pagu_"+id).autoNumeric("get"));
        var rp = parseFloat($("#realisasiRp_"+id).autoNumeric("get"));
        if(pagu != 0 && rp != 0){
            var res = (rp / pagu) * 100;
            $("#realisasiPersen_"+id).val(res.toFixed(2));
        }else{
            $("#realisasiPersen_"+id).val(0);
        }
    }


    function calculateSisa(id){
        var pagu = $("#pagu_"+id).autoNumeric("get");
        var realisasi = $("#realisasiRp_"+id).autoNumeric("get");
        $("#sisa_"+id).autoNumeric("set", pagu - realisasi);
    }


    function simpan(id){
        
        
        var arrData = [];
        for (var i = 0; i < gArrId.length; i++){
            var id = gArrId[i];
            var data = {
                RM_ID : id,
                RM_PAGU : $("#pagu_" + id).autoNumeric("get"),
                RM_TARGET_RP : $("#targetRp_" + id).autoNumeric("get"),
                RM_TARGET_PERSEN : $("#targetPersen_" + id).val(),
                RM_REALISASI_RP : $("#realisasiRp_" + id).autoNumeric("get"),
                RM_REALISASI_PERSEN : $("#realisasiPersen_" + id).val(),
                RM_SISA_DANA : $("#sisa_" + id).autoNumeric("get"),
                RM_KETERANGAN : $("#keterangan_" + id).val().replaceAll('"', "'")
            };
            if(
                data.RM_PAGU.trim() == "" ||
                data.RM_TARGET_RP.trim() == "" ||
                data.RM_TARGET_PERSEN.trim() == "" ||
                data.RM_REALISASI_RP.trim() == "" ||
                data.RM_REALISASI_PERSEN.trim() == "" ||
                data.RM_SISA_DANA.trim() == ""
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
