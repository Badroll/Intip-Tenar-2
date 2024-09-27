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
            <li class="active"> Rekapitulasi Pegawai</li>
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
        <div class="toggle-show">
            <div class="text-right">
                <button type="button" class="btn bg-orange-700 btn-labeled btn-labeled-right ml-10" onclick="copy()" id="btnCopy"><b><i class="icon-copy3"></i></b> Salin Data dari Bulan Sebelumnya</button>
                <button type="button" class="btn bg-green-700 btn-labeled btn-labeled-right ml-10" onclick="simpan()" id="btnSave"><b><i class="icon-check"></i></b> Simpan</button>
            </div>
        </div>
    </div>
   
    <div class="panel-body">
        <table class="table datatable-basic" style="width: 100%;">
            <thead>
                <tr>
                    <th></th>
                    <th colspan="4" style="text-align:center;" class="text-bold">PANGKAT</th>
                    <th colspan="2" style="text-align:center;" class="text-bold">TEKNIS</th>
                    <th colspan="2" style="text-align:center;" class="text-bold">NON TEKNIS</th>
                    <th colspan="2" style="text-align:center;" class="text-bold">STRUKTURAL</th>
                    <th colspan="2" style="text-align:center;" class="text-bold">NON STRUKTURAL</th>
                    <th></th>
                </tr>
                <tr>
                    <th style="text-align:left;" class="text-bold">GOLONGAN</th>
                    <th style="text-align:left;" class="text-bold">A&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    <th style="text-align:left;" class="text-bold">B&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    <th style="text-align:left;" class="text-bold">C&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    <th style="text-align:left;" class="text-bold">D&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    <th style="text-align:left;" class="text-bold">LAKI-LAKI</th>
                    <th style="text-align:left;" class="text-bold">PEREMPUAN</th>
                    <th style="text-align:left;" class="text-bold">LAKI-LAKI</th>
                    <th style="text-align:left;" class="text-bold">PEREMPUAN</th>
                    <th style="text-align:left;" class="text-bold">LAKI-LAKI</th>
                    <th style="text-align:left;" class="text-bold">PEREMPUAN</th>
                    <th style="text-align:left;" class="text-bold">LAKI-LAKI</th>
                    <th style="text-align:left;" class="text-bold">PEREMPUAN</th>
                    <th style="text-align:left;" class="text-bold">JUMLAH&nbsp;&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @if(count($ctl_data) > 0)
                    @php
                        $sum_REKP_PANGKAT_A = 0;
                        $sum_REKP_PANGKAT_B = 0;
                        $sum_REKP_PANGKAT_C = 0;
                        $sum_REKP_PANGKAT_D = 0;
                        $sum_REKP_TEKNIS_LAKI = 0;
                        $sum_REKP_TEKNIS_PEREMPUAN = 0;
                        $sum_REKP_NONTEKNIS_LAKI = 0;
                        $sum_REKP_NONTEKNIS_PEREMPUAN = 0;
                        $sum_REKP_STRUKTURAL_LAKI = 0;
                        $sum_REKP_STRUKTURAL_PEREMPUAN = 0;
                        $sum_REKP_NONSTRUKTURAL_LAKI = 0;
                        $sum_REKP_NONSTRUKTURAL_PEREMPUAN = 0;
                        $sum_TOTAL = 0;
                    @endphp
                    @foreach($ctl_data as $aData)
                        @php
                            $sum_REKP_PANGKAT_A += $aData->REKP_PANGKAT_A;
                            $sum_REKP_PANGKAT_B += $aData->REKP_PANGKAT_B;
                            $sum_REKP_PANGKAT_C += $aData->REKP_PANGKAT_C;
                            $sum_REKP_PANGKAT_D += $aData->REKP_PANGKAT_D;
                            $sum_REKP_TEKNIS_LAKI += $aData->REKP_TEKNIS_LAKI;
                            $sum_REKP_TEKNIS_PEREMPUAN += $aData->REKP_TEKNIS_PEREMPUAN;
                            $sum_REKP_NONTEKNIS_LAKI += $aData->REKP_NONTEKNIS_LAKI;
                            $sum_REKP_NONTEKNIS_PEREMPUAN += $aData->REKP_NONTEKNIS_PEREMPUAN;
                            $sum_REKP_STRUKTURAL_LAKI += $aData->REKP_STRUKTURAL_LAKI;
                            $sum_REKP_STRUKTURAL_PEREMPUAN += $aData->REKP_STRUKTURAL_PEREMPUAN;
                            $sum_REKP_NONSTRUKTURAL_LAKI += $aData->REKP_NONSTRUKTURAL_LAKI;
                            $sum_REKP_NONSTRUKTURAL_PEREMPUAN += $aData->REKP_NONSTRUKTURAL_PEREMPUAN;

                            $sum_ROW = $aData->REKP_PANGKAT_A + $aData->REKP_PANGKAT_B + $aData->REKP_PANGKAT_C + $aData->REKP_PANGKAT_D;

                            $sum_TOTAL += $sum_ROW;
                        @endphp

                        <!-- 
                         + $aData->REKP_TEKNIS_LAKI + $aData->REKP_TEKNIS_PEREMPUAN + $aData->REKP_NONTEKNIS_LAKI + $aData->REKP_NONTEKNIS_PEREMPUAN + $aData->REKP_STRUKTURAL_LAKI + $aData->REKP_STRUKTURAL_PEREMPUAN + $aData->REKP_NONSTRUKTURAL_LAKI + $aData->REKP_NONSTRUKTURAL_PEREMPUAN
                         -->
                        <tr>
                            <td>
                                {{ Helper::getReferenceInfo("GOLONGAN", $aData->REKP_GOLONGAN) }}
                            </td>
                            <td>
                                <input type="text" class="form-control force-number" value="{{ $aData->REKP_PANGKAT_A }}" id="pangkatA_{{ $aData->REKP_ID }}">
                            </td>
                            <td>
                                <input type="text" class="form-control force-number" value="{{ $aData->REKP_PANGKAT_B }}" id="pangkatB_{{ $aData->REKP_ID }}">
                            </td>
                            <td>
                                <input type="text" class="form-control force-number" value="{{ $aData->REKP_PANGKAT_C }}" id="pangkatC_{{ $aData->REKP_ID }}">
                            </td>
                            <td>
                                <input type="text" class="form-control force-number" value="{{ $aData->REKP_PANGKAT_D }}" id="pangkatD_{{ $aData->REKP_ID }}">
                            </td>

                            <td>
                                <input type="text" class="form-control force-number" value="{{ $aData->REKP_TEKNIS_LAKI }}" id="teknisL_{{ $aData->REKP_ID }}">
                            </td>
                            <td>
                                <input type="text" class="form-control force-number" value="{{ $aData->REKP_TEKNIS_PEREMPUAN }}" id="teknisP_{{ $aData->REKP_ID }}">
                            </td>
                            <td>
                                <input type="text" class="form-control force-number" value="{{ $aData->REKP_NONTEKNIS_LAKI }}" id="nonteknisL_{{ $aData->REKP_ID }}">
                            </td>
                            <td>
                                <input type="text" class="form-control force-number" value="{{ $aData->REKP_NONTEKNIS_PEREMPUAN }}" id="nonteknisP_{{ $aData->REKP_ID }}">
                            </td>
                            <td>
                                <input type="text" class="form-control force-number" value="{{ $aData->REKP_STRUKTURAL_LAKI }}" id="strukturalL_{{ $aData->REKP_ID }}">
                            </td>
                            <td>
                                <input type="text" class="form-control force-number force-number" value="{{ $aData->REKP_STRUKTURAL_PEREMPUAN }}" id="strukturalP_{{ $aData->REKP_ID }}">
                            </td>
                            <td>
                                <input type="text" class="form-control force-number" value="{{ $aData->REKP_NONSTRUKTURAL_LAKI }}" id="nonstrukturalL_{{ $aData->REKP_ID }}">
                            </td>
                            <td>
                                <input type="text" class="form-control force-number" value="{{ $aData->REKP_NONSTRUKTURAL_PEREMPUAN }}" id="nonstrukturalP_{{ $aData->REKP_ID }}">
                            </td>
                            <td>
                                <input type="text" class="form-control" value="{{ $sum_ROW }}" disabled>
                            </td>
                        </tr>
                    @endforeach
                        <tr style="font-weight: bold;">
                            <td>TOTAL</td>
                            <td><input type="text" class="form-control text-bold" value="{{ $sum_REKP_PANGKAT_A }}" disabled></td>
                            <td><input type="text" class="form-control text-bold" value="{{ $sum_REKP_PANGKAT_B }}" disabled></td>
                            <td><input type="text" class="form-control text-bold" value="{{ $sum_REKP_PANGKAT_C }}" disabled></td>
                            <td><input type="text" class="form-control text-bold" value="{{ $sum_REKP_PANGKAT_D }}" disabled></td>
                            <td><input type="text" class="form-control text-bold" value="{{ $sum_REKP_TEKNIS_LAKI }}" disabled></td>
                            <td><input type="text" class="form-control text-bold" value="{{ $sum_REKP_TEKNIS_PEREMPUAN }}" disabled></td>
                            <td><input type="text" class="form-control text-bold" value="{{ $sum_REKP_NONTEKNIS_LAKI }}" disabled></td>
                            <td><input type="text" class="form-control text-bold" value="{{ $sum_REKP_NONTEKNIS_PEREMPUAN }}" disabled></td>
                            <td><input type="text" class="form-control text-bold" value="{{ $sum_REKP_STRUKTURAL_LAKI }}" disabled></td>
                            <td><input type="text" class="form-control text-bold" value="{{ $sum_REKP_STRUKTURAL_PEREMPUAN }}" disabled></td>
                            <td><input type="text" class="form-control text-bold" value="{{ $sum_REKP_NONSTRUKTURAL_LAKI }}" disabled></td>
                            <td><input type="text" class="form-control text-bold" value="{{ $sum_REKP_NONSTRUKTURAL_PEREMPUAN }}" disabled></td>
                            <td><input type="text" class="form-control text-bold" value="{{ $sum_TOTAL }}" disabled></td>
                        </tr>
                @else
                @endif
            </tbody>
        </table>

        <hr>
        <br>
        <h5>Pegawai Pemerintah Non Pegawai Negeri</h5>

        <table class="table datatable-basic" style="width: 100%;">
            <thead>
                <tr>
                    <th style="text-align:center;" class="text-bold">JENIS</th>
                    <th style="text-align:center;" class="text-bold">LAKI-LAKI</th>
                    <th style="text-align:center;" class="text-bold">PEREMPUAN</th>
                    <th style="text-align:center;" class="text-bold">JUMLAH</th>
                </tr>
            </thead>
            <tbody>
                @if(count($ctl_data2) > 0)
                    @foreach($ctl_data2 as $aData)
                        <tr>
                            <td style="width: 25%;">
                                {{ Helper::getReferenceInfo("JENIS_PPNPN", $aData->REKP_JENIS) }}
                            </td>
                            <td style="width: 25%;">
                                <input type="text" class="form-control force-number summary-trigger" value="{{ $aData->REKP_LAKI }}" id="laki_{{ $aData->REKP_ID }}">
                            </td>
                            <td style="width: 25%;">
                                <input type="text" class="form-control force-number summary-trigger" value="{{ $aData->REKP_PEREMPUAN }}" id="perempuan_{{ $aData->REKP_ID }}">
                            </td>
                            <td style="width: 25%;">
                                <input type="text" class="form-control text-bold" value="{{ $aData->REKP_LAKI + $aData->REKP_PEREMPUAN }}" disabled id="jumlah_{{ $aData->REKP_ID }}">
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

@section('script')
<!-- <script type="text/javascript" src="{!! url('/') !!}/lib/js/plugins/tables/datatables/datatables.min.js"></script> -->
<script type="text/javascript">
    
    var gArrId;
    var gArrId2;

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
            arrId.push(data[i]["REKP_ID"]);
        }
        gArrId = arrId;


        var dataJSON_ = "{{ $ctl_data2 }}";
        var dataJSON2_ = dataJSON_.replaceAll('&quot;', '"');
        var data2 = JSON.parse(dataJSON2_);
        if(data2.length < 1){
            $("#btnSave").attr("disabled", "");
        }
        var arrId2 = [];
        for (var i = 0; i < data2.length; i++){
            arrId2.push(data2[i]["REKP_ID"]);
        }
        gArrId2 = arrId2;

    });


    function filter(){
        var periode = $("#periode").val();
        window.location = "{{ url('main/'.Helper::allUri(4)) }}?periode="+periode
    }


    function copy(){
        var periode = $("#periode").val();
        
        swal({
            title: "Konfirmasi",
            text: "Salin Data Rekapitulasi Pegawai dari Bulan Sebelumnya ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#0288D1",
            confirmButtonText: "Ya",
            cancelButtonText: "Batal",
            closeOnConfirm: true,
            html: true
        },
        function(){
            var formData = new FormData();
            formData.append("periode", periode);
            formData.append("_token", "{{ csrf_token() }}");

            createOverlay("Proses...");
            $.ajax({
                type  : "POST",
                url   : "{{ url('main/'.Helper::allUri(4).'/update-copy') }}",
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
        });
    }


    function simpan(id){
        
        
        var arrData = [];
        for (var i = 0; i < gArrId.length; i++){
            var id = gArrId[i];
            var data = {
                REKP_ID : id,
                REKP_PANGKAT_A : $("#pangkatA_" + id).val(),
                REKP_PANGKAT_B : $("#pangkatB_" + id).val(),
                REKP_PANGKAT_C : $("#pangkatC_" + id).val(),
                REKP_PANGKAT_D : $("#pangkatD_" + id).val(),
                REKP_TEKNIS_LAKI : $("#teknisL_" + id).val(),
                REKP_TEKNIS_PEREMPUAN : $("#teknisP_" + id).val(),
                REKP_NONTEKNIS_LAKI : $("#nonteknisL_" + id).val(),
                REKP_NONTEKNIS_PEREMPUAN : $("#nonteknisP_" + id).val(),
                REKP_STRUKTURAL_LAKI : $("#strukturalL_" + id).val(),
                REKP_STRUKTURAL_PEREMPUAN : $("#strukturalP_" + id).val(),
                REKP_NONSTRUKTURAL_LAKI : $("#nonstrukturalL_" + id).val(),
                REKP_NONSTRUKTURAL_PEREMPUAN : $("#nonstrukturalP_" + id).val()
            }
            arrData.push(data);
        }

        var arrData2 = [];
        for (var i = 0; i < gArrId2.length; i++){
            var id2 = gArrId2[i];
            var data2 = {
                REKP_ID : id2,
                REKP_LAKI : $("#laki_" + id2).val(),
                REKP_PEREMPUAN : $("#perempuan_" + id2).val()
            }
            arrData2.push(data2);
        }

        var formData = new FormData();
        formData.append("data", JSON.stringify(arrData));
        formData.append("data2", JSON.stringify(arrData2));
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
