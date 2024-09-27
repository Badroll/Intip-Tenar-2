@extends('master')

@section('style')
@stop

@section('breadcrumb')
<div class="page-header">
    <div class="breadcrumb-line breadcrumb-line-wide">
        <ul class="breadcrumb">
            <li><a href="{{ url('main') }}">Beranda</a></li>
            <li><a href="#"> Tata Usaha</a></li>
            <li><a href="#"> Urusan Umum</a></li>
            <li class="active"> Tata Persuratan</li>
        </ul>
    </div>
    <br>
</div>
@stop

@section('content')
<input type="hidden" name="_token" class="_token" value="{{ csrf_token() }}" />

<div class="panel panel-flat">
    <div class="panel-heading">
        <h4 class="panel-titletext-bold"><b>TATA PERSURATAN</b></h4>
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
                <button type="button" class="btn bg-green-700 btn-labeled btn-labeled-right ml-10" onclick="simpan('{{ $ctl_data->SRT_ID }}')" id="btnSave"><b><i class="icon-check"></i></b> Simpan</button>
            </div>
        </div>
    </div>
   
    <div class="panel-body">
        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th style="text-align:left;" class="text-bold">SURAT MASUK</th>
                    <th style="text-align:left;" class="text-bold">SURAT KELUAR</th>
                    <th style="text-align:left;" class="text-bold">SURAT KEPUTUSAN</th>
                    <th style="text-align:left;" class="text-bold">SURAT PERINTAH</th>
                    <th style="text-align:left;" class="text-bold">JUMLAH</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($ctl_data))
                    @php
                    $sum_TOTAL = 0;
                        $sum_TOTAL += $ctl_data->SRT_MASUK;
                        $sum_TOTAL += $ctl_data->SRT_KELUAR;
                        $sum_TOTAL += $ctl_data->SRT_KEPUTUSAN;
                        $sum_TOTAL += $ctl_data->SRT_PERINTAH;
                    @endphp
                    <tr>
                        <td>
                            <input type="text" class="form-control force-number" value="{{ $ctl_data->SRT_MASUK }}" id="masuk">
                        </td>
                        <td>
                            <input type="text" class="form-control force-number" value="{{ $ctl_data->SRT_KELUAR }}" id="keluar">
                        </td>
                        <td>
                            <input type="text" class="form-control force-number" value="{{ $ctl_data->SRT_KEPUTUSAN }}" id="keputusan">
                        </td>
                        <td>
                            <input type="text" class="form-control force-number" value="{{ $ctl_data->SRT_PERINTAH }}" id="perintah">
                        </td>
                        <td>
                            <input type="text" class="form-control force-number" value="{{ $sum_TOTAL }}" disabled>
                        </td>
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

    $(document).ready(function(){

        $("#periode").datepicker('update', "{{ $ctl_periode }}");
        $("#periode").on('changeDate', function(selected){
            filter();
        });

    });


    function filter(){
        var periode = $("#periode").val();
        window.location = "{{ url('main/'.Helper::allUri(4)) }}?periode="+periode
    }


    function simpan(id){
        
        
        var masuk = $("#masuk").val();
        var keluar = $("#keluar").val();
        var keputusan = $("#keputusan").val();
        var perintah = $("#perintah").val();

        var formData = new FormData();
        formData.append("id", id);
        formData.append("masuk", masuk);
        formData.append("keluar", keluar);
        formData.append("keputusan", keputusan);
        formData.append("perintah", perintah);
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
