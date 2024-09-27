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
            <li class="active"> Laporan Bezetting Pegawai</li>
        </ul>
    </div>
    <br>
</div>
@stop

@section('content')
<input type="hidden" name="_token" class="_token" value="{{ csrf_token() }}" />

<div class="panel panel-flat">
    <div class="panel-heading">
        <h4 class="panel-titletext-bold"><b>LAPORAN BEZETTING PEGAWAI</b></h4>
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
                <button type="button" class="btn bg-blue-700 btn-labeled btn-labeled-right ml-10" onclick="tambah()"><b><i class="icon-plus3"></i></b> Tambah</button>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th style="text-align:left;" class="text-bold">NAMA</th>
                    <th style="text-align:left;" class="text-bold">JENIS KELAMIN</th>
                    <th style="text-align:left;" class="text-bold">JABATAN</th>
                    <th style="text-align:left;" class="text-bold">ESELON</th>
                    <th style="text-align:left;" class="text-bold">PANGKAT</th>
                    <th style="text-align:left;" class="text-bold">GOLONGAN</th>
                    <th style="text-align:left;" class="text-bold">TMT</th>
                    <th style="text-align:left;" class="text-bold">PENDIDIKAN</th>
                    <th style="text-align:left;" class="text-bold">DIKLAT TEKNIS</th>
                    <th style="text-align:left;" class="text-bold">DIKLAT PENJENJANGAN</th>
                    <th style="text-align:left;" class="text-bold">DIKLAT LAINNYA</th>
                    <th style="text-align:left;" class="text-bold">KETERANGAN</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @if(count($ctl_data) > 0)
                    @foreach($ctl_data as $aData)
                    <tr>
                        <td>{{ $aData->BZTG_NAMA }}</td>
                        <td>{{ Helper::getReferenceInfo("JENIS_KELAMIN", $aData->BZTG_JENIS_KELAMIN) }}</td>
                        <td>{{ $aData->BZTG_JABATAN }}</td>
                        <td>{{ $aData->BZTG_ESELON }}</td>
                        <td>{{ Helper::getReferenceInfo("PANGKAT", $aData->BZTG_PANGKAT) }}</td>
                        <td>{{ Helper::getReferenceInfo("GOLONGAN", $aData->BZTG_GOLONGAN) }}</td>
                        <td>{{ $aData->BZTG_TMT }}</td>
                        <td>{{ $aData->BZTG_PENDIDIKAN }}</td>
                        <td>{{ $aData->BZTG_DIKLAT_TEKNIS }}</td>
                        <td>{{ $aData->BZTG_DIKLAT_PENJENJANGAN }}</td>
                        <td>{{ $aData->BZTG_DIKLAT_LAINNYA }}</td>
                        <td><p>{{ substr($aData->BZTG_KETERANGAN, 0, 25) }}</p></td>
                        <td>
                            <div class="toggle-show">
                                <!-- <ul class="icons-list">
                                    <li class="dropdown">
                                        <a href="#" class="label label-danger dropdown-toggle" data-toggle="dropdown">
                                            Aksi <span class='caret'></span>
                                        </a>

                                        <ul class="dropdown-menu dropdown-menu-center">
                                          <li style="color: #fff;">
                                              <a href="javascript:edit('{{ $aData->BZTG_ID }}')">
                                              <i class="icon-pen-plus"></i> Edit Resto </a>
                                          </li>
                                          <li>
                                              <a href="javascript:hapus('{{ $aData->BZTG_ID }}')">
                                              <i class="icon-trash"></i> Hapus</a>
                                          </li>
                                        </ul>
                                    </li>
                                </ul> -->
                                <a href="javascript:detail('{{ $aData->BZTG_ID }}')"><span class="label label-info" style="padding: 7px;">Edit</span></a>
                                <a href="javascript:hapus('{{ $aData->BZTG_ID }}')"><span class="label label-danger" style="padding: 7px;" onclick="hapus()">Hapus</span></a>
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
                        <label class="col-lg-4 control-label text-semibold">Nama</label>
                        <div class="col-lg-8"><input class="form-control" type="text" id="nama"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label text-semibold">Jenis Kelamin</label>
                        <div class="col-lg-8">
                            <select class="select" id="jenisKelamin">
                                @if(isset($ctl_refJenisKelamin) && count($ctl_refJenisKelamin) > 0)
                                    @foreach($ctl_refJenisKelamin as $aData)
                                        <option value="{{ $aData->R_ID }}">{{ $aData->R_INFO }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label text-semibold">Jabatan</label>
                        <div class="col-lg-8"><input class="form-control" type="text" id="jabatan"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label text-semibold">Eselon</label>
                        <div class="col-lg-8"><input class="form-control" type="text" id="eselon"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label text-semibold">Pangkat</label>
                        <div class="col-lg-8">
                            <select class="select" id="pangkat">
                                @if(isset($ctl_refJenisPangkat) && count($ctl_refJenisPangkat) > 0)
                                    @foreach($ctl_refJenisPangkat as $aData)
                                        <option value="{{ $aData->R_ID }}">{{ $aData->R_INFO }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label text-semibold">Golongan</label>
                        <div class="col-lg-8">
                            <select class="select" id="golongan">
                                @if(isset($ctl_refJenisGolongan) && count($ctl_refJenisGolongan) > 0)
                                    @foreach($ctl_refJenisGolongan as $aData)
                                        <option value="{{ $aData->R_ID }}">{{ $aData->R_INFO }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label text-semibold">TMT</label>
                        <div class="col-lg-8"><input class="form-control" type="text" id="tmt"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label text-semibold">Pendidikan</label>
                        <div class="col-lg-8"><input class="form-control" type="text" id="pendidikan"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label text-semibold">Diklat Teknis</label>
                        <div class="col-lg-8"><input class="form-control" type="text" id="diklatTeknis"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label text-semibold">Diklat Penjenjangan</label>
                        <div class="col-lg-8"><input class="form-control" type="text" id="diklatPenjenjangan"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label text-semibold">Diklat Lainnya</label>
                        <div class="col-lg-8"><input class="form-control" type="text" id="diklatLain"></div>
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
                        <label class="col-lg-4 control-label text-semibold">Nama</label>
                        <div class="col-lg-8"><input class="form-control" type="text" id="nama_"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label text-semibold">Jenis Kelamin</label>
                        <div class="col-lg-8">
                            <select class="select" id="jenisKelamin_">
                                @if(isset($ctl_refJenisKelamin) && count($ctl_refJenisKelamin) > 0)
                                    @foreach($ctl_refJenisKelamin as $aData)
                                        <option value="{{ $aData->R_ID }}">{{ $aData->R_INFO }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label text-semibold">Jabatan</label>
                        <div class="col-lg-8"><input class="form-control" type="text" id="jabatan_"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label text-semibold">Eselon</label>
                        <div class="col-lg-8"><input class="form-control" type="text" id="eselon_"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label text-semibold">Pangkat</label>
                        <div class="col-lg-8">
                            <select class="select" id="pangkat_">
                                @if(isset($ctl_refJenisPangkat) && count($ctl_refJenisPangkat) > 0)
                                    @foreach($ctl_refJenisPangkat as $aData)
                                        <option value="{{ $aData->R_ID }}">{{ $aData->R_INFO }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label text-semibold">Golongan</label>
                        <div class="col-lg-8">
                            <select class="select" id="golongan_">
                                @if(isset($ctl_refJenisGolongan) && count($ctl_refJenisGolongan) > 0)
                                    @foreach($ctl_refJenisGolongan as $aData)
                                        <option value="{{ $aData->R_ID }}">{{ $aData->R_INFO }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label text-semibold">TMT</label>
                        <div class="col-lg-8"><input class="form-control" type="text" id="tmt_"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label text-semibold">Pendidikan</label>
                        <div class="col-lg-8"><input class="form-control" type="text" id="pendidikan_"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label text-semibold">Diklat Teknis</label>
                        <div class="col-lg-8"><input class="form-control" type="text" id="diklatTeknis_"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label text-semibold">Diklat Penjenjangan</label>
                        <div class="col-lg-8"><input class="form-control" type="text" id="diklatPenjenjangan_"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label text-semibold">Diklat Lainnya</label>
                        <div class="col-lg-8"><input class="form-control" type="text" id="diklatLain_"></div>
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
        var nama = $("#nama").val();
        var jenisKelamin = $("#jenisKelamin").val();
        var jabatan = $("#jabatan").val();
        var eselon = $("#eselon").val();
        var pangkat = $("#pangkat").val();
        var golongan = $("#golongan").val();
        var tmt = $("#tmt").val();
        var pendidikan = $("#pendidikan").val();
        var diklatTeknis = $("#diklatTeknis").val();
        var diklatPenjenjangan = $("#diklatPenjenjangan").val();
        var diklatLain = $("#diklatLain").val();
        var keterangan = $("#keterangan").val();

        if(nama != "" && jabatan != "" && eselon != "" && tmt != "" && pendidikan != "" && diklatTeknis != "" && diklatPenjenjangan != "" && diklatLain != ""){
            $("#mdlAdd").modal("toggle");
            var formData = new FormData();
            formData.append("periode", periode);
            formData.append("nama", nama);
            formData.append("jenisKelamin", jenisKelamin);
            formData.append("jabatan", jabatan);
            formData.append("eselon", eselon);
            formData.append("pangkat", pangkat);
            formData.append("golongan", golongan);
            formData.append("tmt", tmt);
            formData.append("pendidikan", pendidikan);
            formData.append("diklatTeknis", diklatTeknis);
            formData.append("diklatPenjenjangan", diklatPenjenjangan);
            formData.append("diklatLain", diklatLain);
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
                            $("#id_").val(data["PAYLOAD"]["BZTG_ID"]);
                            $("#nama_").val(data["PAYLOAD"]["BZTG_NAMA"]);
                            $("#jenisKelamin_").select2("val", data["PAYLOAD"]["BZTG_JENIS_KELAMIN"]);
                            $("#jabatan_").val(data["PAYLOAD"]["BZTG_JABATAN"]);
                            $("#eselon_").val(data["PAYLOAD"]["BZTG_ESELON"]);
                            $("#pangkat_").select2("val", data["PAYLOAD"]["BZTG_PANGKAT"]);
                            $("#golongan_").select2("val", data["PAYLOAD"]["BZTG_GOLONGAN"]);
                            $("#tmt_").val(data["PAYLOAD"]["BZTG_TMT"]);
                            $("#pendidikan_").val(data["PAYLOAD"]["BZTG_PENDIDIKAN"]);
                            $("#diklatTeknis_").val(data["PAYLOAD"]["BZTG_DIKLAT_TEKNIS"]);
                            $("#diklatPenjenjangan_").val(data["PAYLOAD"]["BZTG_DIKLAT_PENJENJANGAN"]);
                            $("#diklatLain_").val(data["PAYLOAD"]["BZTG_DIKLAT_LAINNYA"]);
                            $("#keterangan_").val(data["PAYLOAD"]["BZTG_KETERANGAN"]);
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


    function copy(){
        var periode = $("#periode").val();

        swal({
            title: "Konfirmasi",
            text: "Salin Data Bezetting Pegawai dari Bulan Sebelumnya ?",
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


    function update(){
        
        
        var id = $("#id_").val();
        var nama = $("#nama_").val();
        var jenisKelamin = $("#jenisKelamin_").val();
        var jabatan = $("#jabatan_").val();
        var eselon = $("#eselon_").val();
        var pangkat = $("#pangkat_").val();
        var golongan = $("#golongan_").val();
        var tmt = $("#tmt_").val();
        var pendidikan = $("#pendidikan_").val();
        var diklatTeknis = $("#diklatTeknis_").val();
        var diklatPenjenjangan = $("#diklatPenjenjangan_").val();
        var diklatLain = $("#diklatLain_").val();
        var keterangan = $("#keterangan_").val();

        if(nama != "" && jabatan != "" && eselon != "" && tmt != "" && pendidikan != "" && diklatTeknis != "" && diklatPenjenjangan != "" && diklatLain != ""){
            $("#mdlEdit").modal("toggle");
            var formData = new FormData();
            formData.append("id", id);
            formData.append("nama", nama);
            formData.append("jenisKelamin", jenisKelamin);
            formData.append("jabatan", jabatan);
            formData.append("eselon", eselon);
            formData.append("pangkat", pangkat);
            formData.append("golongan", golongan);
            formData.append("tmt", tmt);
            formData.append("pendidikan", pendidikan);
            formData.append("diklatTeknis", diklatTeknis);
            formData.append("diklatPenjenjangan", diklatPenjenjangan);
            formData.append("diklatLain", diklatLain);
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
