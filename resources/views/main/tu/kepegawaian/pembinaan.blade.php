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
            <li class="active"> Pembinaan Pegawai</li>
        </ul>
    </div>
    <br>
</div>
@stop

@section('content')
<input type="hidden" name="_token" class="_token" value="{{ csrf_token() }}" />

<div class="panel panel-flat">
    <div class="panel-heading">
        <h4 class="panel-titletext-bold"><b>PEMBINAAN PEGAWAI</b></h4>
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
                <button type="button" class="btn bg-blue-700 btn-labeled btn-labeled-right ml-10" onclick="tambah()"><b><i class="icon-plus3"></i></b> Tambah</button>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th style="text-align:left;" class="text-bold">JENIS KEGIATAN</th>
                    <th style="text-align:left;" class="text-bold">KETERANGAN</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @if(count($ctl_data) > 0)
                    @foreach($ctl_data as $aData)
                    <tr>
                        <td>{{ $aData->PBNN_JENIS }}</td>
                        <td><p>{{ substr($aData->PBNN_KETERANGAN, 0, 50) }}</p></td>
                        <td>
                            <div class="toggle-show">
                                <a href="javascript:detail('{{ $aData->PBNN_ID }}')"><span class="label label-info" style="padding: 7px;">Edit</span></a>
                                <a href="javascript:hapus('{{ $aData->PBNN_ID }}')"><span class="label label-danger" style="padding: 7px;" onclick="hapus()">Hapus</span></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @else
                @endif
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL -->
<div id="mdlAdd" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content --modal-lg">
            <div class="modal-header bg-teal-400" style="background: #0d004c">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h6 class="modal-title"> Tambah Data</h6>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="post" action="">
                <div class="col-lg-12">

                    <div class="form-group">
                        <label class="col-lg-4 control-label text-semibold">Periode</label>
                        <div class="col-lg-8"><input class="form-control periodeMdl" type="text" disabled></div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label text-semibold">Jenis Kegiatan</label>
                        <div class="col-lg-8"><input class="form-control" type="text" id="jenis"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label text-semibold">Keterangan</label>
                        <div class="col-lg-8"><input class="form-control" type="text" id="keterangan"></div>
                    </div>

                  <!-- -->
                </div>
                </form>
            </div>

            <div class="modal-footer">
                
                <button type="button" class="btn btn-success btn-labeled btn-xs" onclick="simpan()"><b><i class="icon-checkmark2"></i></b> Simpan </button>
            </div>
        </div>
    </div>
</div>

<div id="mdlEdit" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content --modal-lg">
            <div class="modal-header bg-teal-400" style="background: #0d004c">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h6 class="modal-title"> Edit Data</h6>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="post" action="">
                <div class="col-lg-12">

                    <input type="hidden" id="id_">

                    <div class="form-group">
                        <label class="col-lg-4 control-label text-semibold">Periode</label>
                        <div class="col-lg-8"><input class="form-control periodeMdl" type="text" disabled></div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label text-semibold">Jenis</label>
                        <div class="col-lg-8"><input class="form-control" type="text" id="jenis_"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label text-semibold">Keterangan</label>
                        <div class="col-lg-8"><input class="form-control" type="text" id="keterangan_"></div>
                    </div>

                  <!-- -->
                </div>
                </form>
            </div>

            <div class="modal-footer">
                
                <button type="button" class="btn btn-success btn-labeled btn-xs" onclick="update()"><b><i class="icon-checkmark2"></i></b> Update </button>
            </div>
        </div>
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
        $(".periodeMdl").val(bulanIndo("{{ $ctl_periode }}"));

    });


    function filter(){
        var periode = $("#periode").val();
        window.location = "{{ url('main/'.Helper::allUri(4)) }}?periode="+periode
    }


    function tambah(){
        $("#mdlAdd").modal("show");
    }


    function simpan(){
        
        
        var periode = $("#periode").val();
        var jenis = $("#jenis").val();
        var keterangan = $("#keterangan").val();

        if(jenis != ""){
            $("#mdlAdd").modal("toggle");
            var formData = new FormData();
            formData.append("periode", periode);
            formData.append("jenis", jenis);
            formData.append("keterangan", keterangan);
            formData.append("_token", "{{ csrf_token() }}");
            createOverlay("Proses...");
            $.ajax({
                type  : "POST",
                url   : "{{ url('main/'.Helper::allUri(4).'/save') }}",
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
                    else{
                        notify("e", data["MESSAGE"]);
                    }
                },
                error : function(error) {
                    gOverlay.hide();
                    notify("e", "Network/server error\r\n" + error);
                }
            });
        }else{
            notify("e", "Mohon lenkgapi isian");
        }
    }


    function detail(id){
        createOverlay("Proses...");
        $.ajax({
            type  : "GET",
            url   : "{{ url('main/'.Helper::allUri(4).'/detail') }}",
            data  :  {
                    "id" : id,
                    "_token" : "{{ csrf_token() }}"
            },
            success : function(data) {
                gOverlay.hide();
                if(data["STATUS"] == "SUCCESS") {
                    var payload = data["PAYLOAD"];
                        $('#mdlEdit').on('shown.bs.modal', function() {
                            $("#id_").val(data["PAYLOAD"]["PBNN_ID"]);
                            $("#jenis_").val(data["PAYLOAD"]["PBNN_JENIS"]);
                            $("#keterangan_").val(data["PAYLOAD"]["PBNN_KETERANGAN"]);
                        })
                        $("#mdlEdit").modal("show");
                }
                else{
                    notify("e", data["MESSAGE"]);
                }
            },
            error : function(error) {
                gOverlay.hide();
                notify("e", "Network/server error\r\n" + error);
            }
        });
    }


    function update(){
        
        
        var id = $("#id_").val();
        var jenis = $("#jenis_").val();
        var keterangan = $("#keterangan_").val();

        if(jenis != ""){
            $("#mdlEdit").modal("toggle");
            var formData = new FormData();
            formData.append("id", id);
            formData.append("jenis", jenis);
            formData.append("keterangan", keterangan);
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
                    else{
                        notify("e", data["MESSAGE"]);
                    }
                },
                error : function(error) {
                    gOverlay.hide();
                    notify("e", "Network/server error\r\n" + error);
                }
            });
        }else{
            notify("e", "Mohon lenkgapi isian");
        }
    }


    function hapus(id){
        
        
        swal({
            title: "Konfirmasi",
            text: "Hapus data ini ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya",
            cancelButtonText: "Batal",
            closeOnConfirm: true,
            html: true
        },
        function(){
            var formData = new FormData();
            formData.append("id", id);
            formData.append("_token", "{{ csrf_token() }}");
            createOverlay("Proses...");
            $.ajax({
                type  : "POST",
                url   : "{{ url('main/'.Helper::allUri(4).'/delete') }}",
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
                    else{
                        notify("e", data["MESSAGE"]);
                    }
                },
                error : function(error) {
                    gOverlay.hide();
                    notify("e", "Network/server error\r\n" + error);
                }
            });
        });
    }

</script>
@stop
