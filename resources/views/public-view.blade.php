@extends('master2')

@section('content')
<input type="hidden" name="_token" class="_token" value="{{ csrf_token() }}" />

<div class="panel panel-flat">
    <div class="panel-heading">
        <h4 class="panel-titletext-bold" align="center"><b>LAPORAN KINERJA BULANAN</b></h4>
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
        <br><br>
        <div class="form-group">
			<div class="checkbox">
				<label>
					<input type="checkbox" checked="checked" onchange="toggleGrafik();">
					GRAFIK
				</label>
			</div>

			<div class="checkbox">
				<label>
					<input type="checkbox" checked="checked" onchange="toggleTable();">
					TABEL
				</label>
			</div>
		</div>
    </div>

    <div class="panel-body">
    	<div id="divGrafik">
    		<hr>
    		<h5 align="center"><b>GRAFIK</b></h5>

			<div class="row">
				<!-- Realisasi Belanja -->
				<div class="chart-container">
					<h5>LAPORAN REALISASI BELANJA</h5>
					<div class="chart has-fixed-height" id="basic_columns"></div>
				</div>
			</div>
			<hr>
			<br>

			<div class="row">
				<!-- Realisasi Pendapatan -->
				<div class="chart-container">
					<h5>LAPORAN RELISASI PENDAPATAN</h5>
					<div class="chart has-fixed-height" id="basic_bars"></div>
				</div>
			</div>
			<br>
			<hr>
			<br>

			<div class="row">
				<!-- PLD -->
				<div class="col-md-6">
					<div class="panel panel-flat">
						<div class="panel-body">
							<div class="chart-container has-scroll">
								<div class="chart has-fixed-height has-minimum-width" id="basic_pie"></div>
							</div>
						</div>
					</div>
				</div>
				<!-- PLP -->
				<div class="col-md-6">
					<div class="panel panel-flat">
						<div class="panel-body">
							<div class="chart-container has-scroll">
								<div class="chart has-fixed-height has-minimum-width" id="rose_diagram_visible2"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<hr>
			<br>

			<div class="row">
				<!-- Tupoksi -->
				<div class="col-md-6">
					<div class="panel panel-flat">
						<div class="panel-body">
							<div class="chart-container has-scroll">
								<div class="chart has-fixed-height has-minimum-width" id="rose_diagram_visible"></div>
							</div>
						</div>
					</div>
				</div>
				<!-- IKPA -->
				<div class="col-md-6">
					<div class="panel panel-flat">
						<div class="panel-body">
							<div class="chart-container has-scroll">
								<div class="chart has-fixed-height has-minimum-width" id="basic_donut"></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<hr>
			<br>
			<!-- Rekapitulasi -->
			<div class="chart-container">
				<h5>REKAPITULASI PEGAWAI</h4>
				<div class="chart has-fixed-height" id="basic_columns2"></div>
			</div>
			<br>
			<!-- Rekapitulasi 2 -->
			<div class="chart-container">
				<h5>REKAPITULASI PEGAWAI (NON PEGAWAI NEGERI)</h5>
				<div class="chart has-fixed-height" id="basic_bars2"></div>
			</div>
		</div>

		<div id="divTabel">
		<hr>

			<h5 align="center"><b>TABEL</b></h5>

			<h5>LAPORAN REALISASI BELANJA</h5>
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
	                @if(count($ctl_rm) > 0)
	                    @php
	                        $sum_RM_PAGU = 0;
	                        $sum_RM_TARGET_RP = 0;
	                        $sum_RM_REALISASI_RP = 0;
	                        $sum_RM_SISA_DANA = 0;
	                    @endphp
	                    @foreach($ctl_rm as $aData)
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
	                                <input type="text" class="form-control numeric-input-idr" value="{{ $aData->RM_PAGU }}" id="pagu_{{ $aData->RM_ID }}"disabled>
	                            </td>
	                            <td>
	                                <input type="text" class="form-control numeric-input-idr" value="{{ $aData->RM_TARGET_RP }}" id="targetRp_{{ $aData->RM_ID }}"disabled>
	                            </td>
	                            <td>
	                                <input type="text" class="form-control" value="{{ $aData->RM_TARGET_PERSEN }}" id="targetPersen_{{ $aData->RM_ID }}" disabled>
	                            </td>
	                            <td>
	                                <input type="text" class="form-control numeric-input-idr" value="{{ $aData->RM_REALISASI_RP }}" id="realisasiRp_{{ $aData->RM_ID }}"disabled>
	                            </td>
	                            <td>
	                                <input type="text" class="form-control" value="{{ $aData->RM_REALISASI_PERSEN }}" id="realisasiPersen_{{ $aData->RM_ID }}" disabled>
	                            </td>
	                            <td>
	                                <input type="text" class="form-control numeric-input-idr" value="{{ $aData->RM_SISA_DANA }}" id="sisa_{{ $aData->RM_ID }}" disabled>
	                            </td>
	                            <td>
	                                <input type="text" class="form-control" value="{{ $aData->RM_KETERANGAN }}" id="keterangan_{{ $aData->RM_ID }}"disabled>
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

	        <hr>
	        <h5>LAPORAN REALISASI PENDAPATAN</h5>
	        <table class="table datatable-basic" style="width: 100%;">
	            <thead>
	                <tr>
	                    <th style="text-align:left;" class="text-bold">URAIAN</th>
	                    <th style="text-align:left;" class="text-bold">JUMLAH</th>
	                </tr>
	            </thead>
	            <tbody>
	                @if(count($ctl_pnp) > 0)
	                    @foreach($ctl_pnp as $aData)
	                        <tr>
	                            <td>
	                                {{ Helper::getReferenceInfo("PENDAPATAN_URAIAN", $aData->PNP_URAIAN) }} 
	                            </td>
	                            <td>
	                                <input type="text" class="form-control numeric-input-idr" value="{{ $aData->PNP_JUMLAH }}" id="jumlah_{{ $aData->PNP_ID }}" disabled>
	                            </td>
	                        </tr>
	                    @endforeach
	                @else
	                @endif
	            </tbody>
	        </table>

	        <hr>
	        <h5>INDIKATOR KINERJA PELAKSANAAN ANGGARAN</h5>
	        <table class="table" style="width: 100%;">
	            <thead>
	                <tr>
	                    <th style="text-align:left;" class="text-bold">NILAI AKHIR</th>
	                </tr>
	            </thead>
	            <tbody>
	                @if(count($ctl_ikpa) > 0)
	                    @foreach($ctl_ikpa as $aData)
	                    <tr>
	                        <td>
	                            <input type="text" class="form-control" value="{{ $aData->IKPA_NILAI_AKHIR }}" id="nilaiAkhir_{{ $aData->IKPA_ID }}" disabled>
	                        </td>
	                    </tr>
	                    @endforeach
	                @else
	                @endif
	            </tbody>
	        </table>

	        <hr>
	        <h5>PENERIMAAN LAYANAN DETENI</h5>
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
	                @if(count($ctl_pldp) > 0)
	                    @foreach($ctl_pldp as $aData)
	        	            <tr>
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

		    <hr>
		    <h5>PENERIMAAN LAYANAN PENGUNGSI</h5>
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
	                @if(count($ctl_pldp_) > 0)
	                    @foreach($ctl_pldp_ as $aData)
	        	            <tr>
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

		    <hr>
		    <h5>TUPOKSI</h5>
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
	                @if(count($ctl_tupoksi) > 0)
	                    @foreach($ctl_tupoksi as $aData)
	                    <tr>
	                        <td style="width: 25%;">
	                            {{ Helper::getReferenceInfo("JENIS_TUPOKSI", $aData->TPKS_JENIS) }}
	                        </td>
	                        <td style="width: 25%;">
	                            <input type="text" class="form-control force-number summary-trigger" value="{{ $aData->TPKS_LAKI }}" id="laki_{{ $aData->TPKS_ID }}" disabled>
	                        </td>
	                        <td style="width: 25%;">
	                            <input type="text" class="form-control force-number summary-trigger" value="{{ $aData->TPKS_PEREMPUAN }}" id="perempuan_{{ $aData->TPKS_ID }}" disabled>
	                        </td>
	                        <td style="width: 25%;">
	                            <input type="text" class="form-control text-bold" value="{{ $aData->TPKS_LAKI + $aData->TPKS_PEREMPUAN }}" disabled id="jumlah_{{ $aData->TPKS_ID }}" disabled>
	                        </td>
	                    </tr>
	                    @endforeach
	                @else
	                @endif
	            </tbody>
	        </table>

	        <hr>
	        <h5>REKAPITULASI PEGAWAI</h5>
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
	                @if(count($ctl_rekapitulasi) > 0)
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
	                    @foreach($ctl_rekapitulasi as $aData)
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
	                                <input type="text" class="form-control force-number" value="{{ $aData->REKP_PANGKAT_A }}" id="pangkatA_{{ $aData->REKP_ID }}"disabled>
	                            </td>
	                            <td>
	                                <input type="text" class="form-control force-number" value="{{ $aData->REKP_PANGKAT_B }}" id="pangkatB_{{ $aData->REKP_ID }}"disabled>
	                            </td>
	                            <td>
	                                <input type="text" class="form-control force-number" value="{{ $aData->REKP_PANGKAT_C }}" id="pangkatC_{{ $aData->REKP_ID }}"disabled>
	                            </td>
	                            <td>
	                                <input type="text" class="form-control force-number" value="{{ $aData->REKP_PANGKAT_D }}" id="pangkatD_{{ $aData->REKP_ID }}"disabled>
	                            </td>

	                            <td>
	                                <input type="text" class="form-control force-number" value="{{ $aData->REKP_TEKNIS_LAKI }}" id="teknisL_{{ $aData->REKP_ID }}"disabled>
	                            </td>
	                            <td>
	                                <input type="text" class="form-control force-number" value="{{ $aData->REKP_TEKNIS_PEREMPUAN }}" id="teknisP_{{ $aData->REKP_ID }}"disabled>
	                            </td>
	                            <td>
	                                <input type="text" class="form-control force-number" value="{{ $aData->REKP_NONTEKNIS_LAKI }}" id="nonteknisL_{{ $aData->REKP_ID }}"disabled>
	                            </td>
	                            <td>
	                                <input type="text" class="form-control force-number" value="{{ $aData->REKP_NONTEKNIS_PEREMPUAN }}" id="nonteknisP_{{ $aData->REKP_ID }}"disabled>
	                            </td>
	                            <td>
	                                <input type="text" class="form-control force-number" value="{{ $aData->REKP_STRUKTURAL_LAKI }}" id="strukturalL_{{ $aData->REKP_ID }}"disabled>
	                            </td>
	                            <td>
	                                <input type="text" class="form-control force-number force-number" value="{{ $aData->REKP_STRUKTURAL_PEREMPUAN }}" id="strukturalP_{{ $aData->REKP_ID }}"disabled>
	                            </td>
	                            <td>
	                                <input type="text" class="form-control force-number" value="{{ $aData->REKP_NONSTRUKTURAL_LAKI }}" id="nonstrukturalL_{{ $aData->REKP_ID }}"disabled>
	                            </td>
	                            <td>
	                                <input type="text" class="form-control force-number" value="{{ $aData->REKP_NONSTRUKTURAL_PEREMPUAN }}" id="nonstrukturalP_{{ $aData->REKP_ID }}"disabled>
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

	        <br>
	        <h5>REKAPITULASI PEGAWAI (NON PEGAWAI NEGERI)</h5>
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
	                @if(count($ctl_rekapitulasi2) > 0)
	                    @foreach($ctl_rekapitulasi2 as $aData)
	                        <tr>
	                            <td style="width: 25%;">
	                                {{ Helper::getReferenceInfo("JENIS_PPNPN", $aData->REKP_JENIS) }}
	                            </td>
	                            <td style="width: 25%;">
	                                <input type="text" class="form-control force-number summary-trigger" value="{{ $aData->REKP_LAKI }}" id="laki_{{ $aData->REKP_ID }}" disabled>
	                            </td>
	                            <td style="width: 25%;">
	                                <input type="text" class="form-control force-number summary-trigger" value="{{ $aData->REKP_PEREMPUAN }}" id="perempuan_{{ $aData->REKP_ID }}"disabled>
	                            </td>
	                            <td style="width: 25%;">
	                                <input type="text" class="form-control text-bold" value="{{ $aData->REKP_LAKI + $aData->REKP_PEREMPUAN }}" disabled id="jumlah_{{ $aData->REKP_ID }}"disabled>
	                            </td>
	                        </tr>
	                    @endforeach
	                @else
	                @endif
	            </tbody>
	        </table>

		</div>

	</div>

</div>
@stop

@section('script')
<script type="text/javascript">
	var gTupoksiArrJenis_ = [];
	// var gTupoksiArrJumlah = [];
	var gTupoksiArrData = [];

	var gPldpArrNegara_ = [];
	// var gPldpArrJumlah = [];
	var gPldpArrData = [];

	var gPldp_ArrNegara_ = [];
	var gPldp_ArrData = [];

	var gIkpaArrJenis = [];
	var gIkpaArrData = [];

	var gRmArrJenis_ = [];
	var gRmArrPagu = [];
	var gRmArrTarget = [];
	var gRmArrRelisasi = [];
	var gRmArrSisa = [];

	var gPnpArrUraian_ = [];
	var gPnpArrJumlah = [];
	var gPnpArrTarget = [];
	var gPnpArrRelisasi = [];
	var gPnpArrSisa = [];

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
	var gArrJumlah = [];

	var gCheckTabel = true;
	var gCheckGrafik = true;

    $(document).ready(function(){

    	try {

	    	$("#periode").datepicker('update', "{{ $ctl_periode }}");
	    	$("#periode").on('changeDate', function(selected){
	            filter();
	        });

	        var dataJSON = "{{ $ctl_pldp }}";
	        var dataJSON2 = parseToString(dataJSON);
	        var data = JSON.parse(dataJSON2);
	        for (var i = 0; i < data.length; i++){
	        	gPldpArrNegara_.push(data[i]["NGR_NAMA"]);
	        	// gPldpArrJumlah.push(data[i]["PLDP_LAKI"] + data[i]["PLDP_PEREMPUAN"]);
	        	gPldpArrData.push( { value : data[i]["PLDP_LAKI"] + data[i]["PLDP_PEREMPUAN"], name : data[i]["NGR_NAMA"]} );
	        }

	        dataJSON = "{{ $ctl_pldp_ }}";
	        dataJSON2 = parseToString(dataJSON);
	        data = JSON.parse(dataJSON2);
	        for (var i = 0; i < data.length; i++){
	        	gPldp_ArrNegara_.push(data[i]["NGR_NAMA"]);
	        	// gPldpArrJumlah.push(data[i]["PLDP_LAKI"] + data[i]["PLDP_PEREMPUAN"]);
	        	gPldp_ArrData.push( { value : data[i]["PLDP_LAKI"] + data[i]["PLDP_PEREMPUAN"], name : data[i]["NGR_NAMA"]} );
	        }

	        dataJSON = "{{ $ctl_tupoksi }}";
	        dataJSON2 = parseToString(dataJSON);
	        data = JSON.parse(dataJSON2);
	        for (var i = 0; i < data.length; i++){
	        	gTupoksiArrJenis_.push(data[i]["R_INFO"]);
	        	// gTupoksiArrJumlah.push(data[i]["TPKS_LAKI"] + data[i]["TPKS_PEREMPUAN"]);
	        	gTupoksiArrData.push( { value : data[i]["TPKS_LAKI"] + data[i]["TPKS_PEREMPUAN"], name : data[i]["R_INFO"]} );
	        }

	        dataJSON = "{{ $ctl_ikpa }}";
	        dataJSON2 = parseToString(dataJSON);
	        data = JSON.parse(dataJSON2);
	        gIkpaArrJenis.push("Nilai Akhir");
	        gIkpaArrJenis.push("-");
	        if(data.length == 0){
	        	gIkpaArrData.push( { value : 0, name : "Nilai Akhir"} );
		        gIkpaArrData.push( { value : 100, name : "-"} );
	        }else{
		        for (var i = 0; i < data.length; i++){
		        	gIkpaArrData.push( { value : data[i]["IKPA_NILAI_AKHIR"], name : "Nilai Akhir"} );
		        	gIkpaArrData.push( { value : (100 - data[i]["IKPA_NILAI_AKHIR"]).toFixed(2), name : "-"} );
		        }
	        }

	        dataJSON = "{{ $ctl_rm }}";
	        dataJSON2 = parseToString(dataJSON);
	        data = JSON.parse(dataJSON2);
	        for (var i = 0; i < data.length; i++){
	        	gRmArrJenis_.push(data[i]["R_INFO"]);
	        	gRmArrPagu.push(data[i]["RM_PAGU"]);
	        	gRmArrTarget.push(data[i]["RM_TARGET_RP"]);
	        	gRmArrRelisasi.push(data[i]["RM_REALISASI_RP"]);
	        	gRmArrSisa.push(data[i]["RM_SISA_DANA"]);
	        }

	        dataJSON = "{{ $ctl_pnp }}";
	        dataJSON2 = parseToString(dataJSON);
	        data = JSON.parse(dataJSON2);
	        for (var i = 0; i < data.length; i++){
	        	gPnpArrUraian_.push(data[i]["R_INFO"].replaceAll(" ", "\n"));
	        	gPnpArrJumlah.push(data[i]["PNP_JUMLAH"]);
	        }

	        dataJSON = "{{ $ctl_rekapitulasi }}";
	        dataJSON2 = parseToString(dataJSON);
	        data = JSON.parse(dataJSON2);
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

	        dataJSON = "{{ $ctl_rekapitulasi2 }}";
	        dataJSON2 = parseToString(dataJSON);
	        data = JSON.parse(dataJSON2);
	        for (var i = 0; i < data.length; i++){
	        	gArrJenis_.push(data[i]["REKP_JENIS_"].replaceAll(" ", "\n"));
	        	gArrL.push(data[i]["REKP_LAKI"]);
	        	gArrP.push(data[i]["REKP_PEREMPUAN"]);
	        	gArrJumlah.push(data[i]["REKP_LAKI"] + data[i]["REKP_PEREMPUAN"]);
	        }

		}catch(err){
			//
		}

    });

	function toggleTable(){
		gCheckTabel = gCheckTabel ? false : true;
		if(gCheckTabel){
			$("#divTabel").css("display", "inline");
		}else{
			$("#divTabel").css("display", "none");
		}
	}

	function toggleGrafik(){
		gCheckGrafik = gCheckGrafik ? false : true;
		if(gCheckGrafik){
			$("#divGrafik").css("display", "inline");
		}else{
			$("#divGrafik").css("display", "none");
		}
	}

    function filter(){
    	var periode = $("#periode").val();
    	window.location = "{{ url('public-view/') }}?periode="+periode
    }

    try{
    	//
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
		            'echarts/chart/pie',
		            'echarts/chart/funnel',
		            'echarts/chart/bar',
		            'echarts/chart/line'
		        ],


		        // Charts setup
		        function (ec, limitless) {
		            var basic_pie = ec.init(document.getElementById('basic_pie'), limitless);
		            var rose_diagram_visible = ec.init(document.getElementById('rose_diagram_visible'), limitless);
		            var rose_diagram_visible2 = ec.init(document.getElementById('rose_diagram_visible2'), limitless);
            		var basic_donut = ec.init(document.getElementById('basic_donut'), limitless);
		            var basic_columns = ec.init(document.getElementById('basic_columns'), limitless);
		            var basic_bars = ec.init(document.getElementById('basic_bars'), limitless);
		            var basic_columns2 = ec.init(document.getElementById('basic_columns2'), limitless);
		            var basic_bars2 = ec.init(document.getElementById('basic_bars2'), limitless);

		            basic_pie_options = {

		                // Add title
		                title: {
		                    text: 'PENERIMAAN LAYANAN DETENI',
		                    // subtext: 'Open source information',
		                    x: 'center'
		                },

		                // Add tooltip
		                tooltip: {
		                    trigger: 'item',
		                    formatter: "{a} <br/>{b}: {c} ({d}%)"
		                },

		                // Add legend
		                legend: {
		                    orient: 'vertical',
		                    x: 'left',
		                    data: (gPldpArrNegara_.length > 0) ? gPldpArrNegara_ : ["Jumlah"]
		                },

		                // Display toolbox
		                toolbox: {
		                    show: true,
		                    orient: 'vertical',
		                    feature: {
		                        mark: {
		                            show: true,
		                            title: {
		                                mark: 'Markline switch',
		                                markUndo: 'Undo markline',
		                                markClear: 'Clear markline'
		                            }
		                        },
		                        dataView: {
		                            show: true,
		                            readOnly: false,
		                            title: 'View data',
		                            lang: ['View chart data', 'Close', 'Update']
		                        },
		                        magicType: {
		                            show: true,
		                            title: {
		                                pie: 'Switch to pies',
		                                funnel: 'Switch to funnel',
		                            },
		                            type: ['pie', 'funnel'],
		                            option: {
		                                funnel: {
		                                    x: '25%',
		                                    y: '20%',
		                                    width: '50%',
		                                    height: '70%',
		                                    funnelAlign: 'left',
		                                    max: 1548
		                                }
		                            }
		                        },
		                        restore: {
		                            show: true,
		                            title: 'Restore'
		                        },
		                        saveAsImage: {
		                            show: true,
		                            title: 'Same as image',
		                            lang: ['Save']
		                        }
		                    }
		                },

		                // Enable drag recalculate
		                calculable: true,

		                // Add series
		                series: [{
		                    name: 'PLD',
		                    type: 'pie',
		                    radius: '70%',
		                    center: ['50%', '57.5%'],
		                    data: (gPldpArrData.length > 0) ? gPldpArrData : [{ value : 0, name : "Jumlah"}]
		                }]
		            };

		            rose_diagram_visible_options = {

		                // Add title
		                title: {
		                    text: 'TUPOKSI',
		                    // subtext: 'Senior front end developer',
		                    x: 'center'
		                },

		                // Add tooltip
		                tooltip: {
		                    trigger: 'item',
		                    formatter: "{a} <br/>{b}: {c} ({d}%)"
		                },

		                // Add legend
		                legend: {
		                    x: 'left',
		                    y: 'top',
		                    orient: 'vertical',
		                    data: gTupoksiArrJenis_
		                },

		                // Display toolbox
		                toolbox: {
		                    show: true,
		                    orient: 'vertical',
		                    feature: {
		                        mark: {
		                            show: true,
		                            title: {
		                                mark: 'Markline switch',
		                                markUndo: 'Undo markline',
		                                markClear: 'Clear markline'
		                            }
		                        },
		                        dataView: {
		                            show: true,
		                            readOnly: false,
		                            title: 'View data',
		                            lang: ['View chart data', 'Close', 'Update']
		                        },
		                        magicType: {
		                            show: true,
		                            title: {
		                                pie: 'Switch to pies',
		                                funnel: 'Switch to funnel',
		                            },
		                            type: ['pie', 'funnel']
		                        },
		                        restore: {
		                            show: true,
		                            title: 'Restore'
		                        },
		                        saveAsImage: {
		                            show: true,
		                            title: 'Same as image',
		                            lang: ['Save']
		                        }
		                    }
		                },

		                // Enable drag recalculate
		                calculable: true,

		                // Add series
		                series: [
		                    {
		                        name: 'Tupoksi',
		                        type: 'pie',
		                        radius: ['15%', '73%'],
		                        center: ['50%', '57%'],
		                        roseType: 'area',

		                        // Funnel
		                        width: '40%',
		                        height: '78%',
		                        x: '30%',
		                        y: '17.5%',
		                        max: 450,
		                        sort: 'ascending',

		                        data: gTupoksiArrData
		                    }
		                ]
		            };

		            rose_diagram_visible2_options = {

		                // Add title
		                title: {
		                    text: 'PENERIMAAN LAYANAN PENGUNGSI',
		                    // subtext: 'Senior front end developer',
		                    x: 'center'
		                },

		                // Add tooltip
		                tooltip: {
		                    trigger: 'item',
		                    formatter: "{a} <br/>{b}: {c} ({d}%)"
		                },

		                // Add legend
		                legend: {
		                    x: 'left',
		                    y: 'top',
		                    orient: 'vertical',
		                    data: (gPldp_ArrNegara_.length > 0) ? gPldp_ArrNegara_ : ["Jumlah"]
		                },

		                // Display toolbox
		                toolbox: {
		                    show: true,
		                    orient: 'vertical',
		                    feature: {
		                        mark: {
		                            show: true,
		                            title: {
		                                mark: 'Markline switch',
		                                markUndo: 'Undo markline',
		                                markClear: 'Clear markline'
		                            }
		                        },
		                        dataView: {
		                            show: true,
		                            readOnly: false,
		                            title: 'View data',
		                            lang: ['View chart data', 'Close', 'Update']
		                        },
		                        magicType: {
		                            show: true,
		                            title: {
		                                pie: 'Switch to pies',
		                                funnel: 'Switch to funnel',
		                            },
		                            type: ['pie', 'funnel']
		                        },
		                        restore: {
		                            show: true,
		                            title: 'Restore'
		                        },
		                        saveAsImage: {
		                            show: true,
		                            title: 'Same as image',
		                            lang: ['Save']
		                        }
		                    }
		                },

		                // Enable drag recalculate
		                calculable: true,

		                // Add series
		                series: [
		                    {
		                        name: 'PLP',
		                        type: 'pie',
		                        radius: ['15%', '73%'],
		                        center: ['50%', '57%'],
		                        roseType: 'area',

		                        // Funnel
		                        width: '40%',
		                        height: '78%',
		                        x: '30%',
		                        y: '17.5%',
		                        max: 450,
		                        sort: 'ascending',

		                        data: (gPldp_ArrData.length > 0) ? gPldp_ArrData : [{ value : 0, name : "Jumlah"}]
		                    }
		                ]
		            };

		            basic_donut_options = {

		                // Add title
		                title: {
		                    text: 'INDIKATOR KINERJA PELAKSANAAN ANGGARAN',
		                    x: 'center'
		                },

		                // Add legend
		                legend: {
		                    orient: 'vertical',
		                    x: 'left',
		                    data: gIkpaArrJenis
		                },

		                // Display toolbox
		                toolbox: {
		                    show: true,
		                    orient: 'vertical',
		                    feature: {
		                        mark: {
		                            show: true,
		                            title: {
		                                mark: 'Markline switch',
		                                markUndo: 'Undo markline',
		                                markClear: 'Clear markline'
		                            }
		                        },
		                        dataView: {
		                            show: true,
		                            readOnly: false,
		                            title: 'View data',
		                            lang: ['View chart data', 'Close', 'Update']
		                        },
		                        magicType: {
		                            show: true,
		                            title: {
		                                pie: 'Switch to pies',
		                                funnel: 'Switch to funnel',
		                            },
		                            type: ['pie', 'funnel'],
		                            option: {
		                                funnel: {
		                                    x: '25%',
		                                    y: '20%',
		                                    width: '50%',
		                                    height: '70%',
		                                    funnelAlign: 'left',
		                                    max: 1548
		                                }
		                            }
		                        },
		                        restore: {
		                            show: true,
		                            title: 'Restore'
		                        },
		                        saveAsImage: {
		                            show: true,
		                            title: 'Same as image',
		                            lang: ['Save']
		                        }
		                    }
		                },

		                // Enable drag recalculate
		                calculable: true,

		                // Add series
		                series: [
		                    {
		                        name: 'Browsers',
		                        type: 'pie',
		                        radius: ['50%', '70%'],
		                        center: ['50%', '57.5%'],
		                        itemStyle: {
		                            normal: {
		                                label: {
		                                    show: true
		                                },
		                                labelLine: {
		                                    show: true
		                                }
		                            },
		                            emphasis: {
		                                label: {
		                                    show: true,
		                                    formatter: '{b}' + '\n\n' + '{d}%',
		                                    position: 'center',
		                                    textStyle: {
		                                        fontSize: '17',
		                                        fontWeight: '500'
		                                    }
		                                }
		                            }
		                        },

		                        data: gIkpaArrData
		                    }
		                ]
		            };

		            //

		            basic_columns_options = {

		                // Setup grid
		                grid: echartGrid,

		                // Add tooltip
		                tooltip: {
		                    trigger: 'axis'
		                },

		                // Add legend
		                legend: {
		                    data: ['Pagu', 'Target', 'Realisasi', 'Sisa Dana']
		                },

		                // Enable drag recalculate
		                calculable: true,

		                // Horizontal axis
		                xAxis: [{
		                    type: 'category',
		                    data: gRmArrJenis_
		                }],

		                // Vertical axis
		                yAxis: [{
		                    type: 'value'
		                }],

		                // Add series
		                series: [
		                    {
		                        name: 'Pagu',
		                        type: 'bar',
		                        data: gRmArrPagu,
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
		                        name: 'Target',
		                        type: 'bar',
		                        data: gRmArrTarget,
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
		                        name: 'Realisasi',
		                        type: 'bar',
		                        data: gRmArrRelisasi,
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
		                        name: 'Sisa Dana',
		                        type: 'bar',
		                        data: gRmArrSisa,
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

		            basic_bars_options = {

		                // Setup grid
		                grid: {
		                    x: 95,
		                    x2: 35,
		                    y: 35,
		                    y2: 25
		                },

		                // Add tooltip
		                tooltip: {
		                    trigger: 'axis',
		                    axisPointer: {
		                        type: 'shadow'
		                    }
		                },

		                // Add legend
		                legend: {
		                    data: ['Jumlah']
		                },

		                // Enable drag recalculate
		                calculable: true,

		                // Horizontal axis
		                xAxis: [{
		                    type: 'value',
		                    boundaryGap: [0, 0.01]
		                }],

		                // Vertical axis
		                yAxis: [{
		                    type: 'category',
		                    data: gPnpArrUraian_
		                }],

		                // Add series
		                series: [
		                    {
		                        name: 'Jumlah',
		                        type: 'bar',
		                        itemStyle: {
		                            normal: {
		                                color: '#2EC7C9'
		                            }
		                        },
		                        data: gPnpArrJumlah
		                    }
		                ]
		            };

		            basic_columns2_options = {

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

		            basic_bars2_options = {

		                // Setup grid
		                grid: {
		                    x: 95,
		                    x2: 35,
		                    y: 35,
		                    y2: 25
		                },

		                // Add tooltip
		                tooltip: {
		                    trigger: 'axis',
		                    axisPointer: {
		                        type: 'shadow'
		                    }
		                },

		                // Add legend
		                legend: {
		                    data: ['Laki-laki', 'Perempuan', 'Jumlah']
		                },

		                // Enable drag recalculate
		                calculable: true,

		                // Horizontal axis
		                xAxis: [{
		                    type: 'value',
		                    boundaryGap: [0, 0]
		                }],

		                // Vertical axis
		                yAxis: [{
		                    type: 'category',
		                    data: gArrJenis_
		                }],

		                // Add series
		                series: [
		                    {
		                        name: 'Laki-laki',
		                        type: 'bar',
		                        itemStyle: {
		                            normal: {
		                                color: '#2EC7C9'
		                            }
		                        },
		                        data: gArrL
		                    },
		                    {
		                        name: 'Perempuan',
		                        type: 'bar',
		                        itemStyle: {
		                            normal: {
		                                color: '#B6A2DE'
		                            }
		                        },
		                        data: gArrP
		                    },
		                    {
		                        name: 'Jumlah',
		                        type: 'bar',
		                        itemStyle: {
		                            normal: {
		                                color: '#5AB1EF'
		                            }
		                        },
		                        data: gArrJumlah
		                    }
		                ]
		            };

		      //       basic_bars2_options = {

		      //           // Setup grid
		      //           grid: {
				    //         x: 35,
				    //         x2: 25,
				    //         y: 60,
				    //         y2: 50
				    //     },

		      //           // Add tooltip
		      //           tooltip: {
		      //               trigger: 'axis'
		      //           },

		      //           // Add legend
		      //           legend: {
		      //               data: ['Laki-laki', 'Perempuan', 'Jumlah']
		      //           },

		      //           // Enable drag recalculate
		      //           calculable: true,

		      //           // Horizontal axis
		      //           xAxis: [{
		      //               type: 'category',
		      //               data: gArrJenis_
		      //           }],

		      //           // Vertical axis
		      //           yAxis: [{
		      //               type: 'value'
		      //           }],

		      //           // Add series
		      //           series: [
		      //               {
		      //                   name: 'Laki-laki',
		      //                   type: 'bar',
		      //                   data: gArrL,
		      //                   itemStyle: {
		      //                       normal: {
		      //                           label: {
		      //                               show: true,
		      //                               textStyle: {
		      //                                   fontWeight: 500
		      //                               }
		      //                           }
		      //                       }
		      //                   },
		      //                   markLine: {
		      //                       data: [{type: 'average', name: 'Average'}]
		      //                   }
		      //               },
		      //               {
		      //                   name: 'Perempuan',
		      //                   type: 'bar',
		      //                   data: gArrP,
		      //                   itemStyle: {
		      //                       normal: {
		      //                           label: {
		      //                               show: true,
		      //                               textStyle: {
		      //                                   fontWeight: 500
		      //                               }
		      //                           }
		      //                       }
		      //                   },
		      //                   markLine: {
		      //                       data: [{type: 'average', name: 'Average'}]
		      //                   }
		      //               },
		      //               {
		      //                   name: 'Jumlah',
		      //                   type: 'bar',
		      //                   data: gArrL.map(function (num, idx) {
								//   return num + gArrP[idx];
								// }),
		      //                   itemStyle: {
		      //                       normal: {
		      //                           label: {
		      //                               show: true,
		      //                               textStyle: {
		      //                                   fontWeight: 500
		      //                               }
		      //                           }
		      //                       }
		      //                   },
		      //                   markLine: {
		      //                       data: [{type: 'average', name: 'Average'}]
		      //                   }
		      //               }
		      //           ]
		      //       };

		            basic_pie.setOption(basic_pie_options);
		            rose_diagram_visible.setOption(rose_diagram_visible_options);
		            rose_diagram_visible2.setOption(rose_diagram_visible2_options);
		            basic_donut.setOption(basic_donut_options);
		            //
		            basic_columns.setOption(basic_columns_options);
		            basic_bars.setOption(basic_bars_options);
		            basic_columns2.setOption(basic_columns2_options);
		            basic_bars2.setOption(basic_bars2_options);

		            window.onresize = function () {
		                setTimeout(function () {
		                    basic_pie.resize();
		                    rose_diagram_visible.resize();
		                    rose_diagram_visible2.resize();
		                    basic_donut.resize();
		                    //
		                    basic_columns.resize();
		                    basic_bars.resize();
		                    basic_columns2.resize();
		                    basic_bars2.resize();
		                }, 200);
		            }
		        }
		    );
		});

	}catch(err){
		//
	}


</script>
@stop
