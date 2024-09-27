<?php

namespace App\Http\Controllers\TU;
use App\Http\Controllers\Controller as mCtl;
use Illuminate\Http\Request;
use App\Model as M;
use Helper, DB;
use Carbon\Carbon;

class KepegawaianController extends mCtl
{

    protected $request;

    public function __construct(Request $req) {
    }

    public function bezetting(Request $req){
        $periode = $req->periode;

      	//
        $bezetting = DB::table("tu_kepegawaian_bezetting")->where("BZTG_PERIODE", $periode)->get();

        $data["ctl_periode"] = $periode;
        $data["ctl_refJenisKelamin"] = Helper::getReference("JENIS_KELAMIN");
        $data["ctl_refJenisGolongan"] = Helper::getReference("GOLONGAN");
        $data["ctl_refJenisPangkat"] = Helper::getReference("PANGKAT");
        $data["ctl_data"] = $bezetting;
        //dd($bezetting);

    	return view("main.tu.kepegawaian.bezetting", $data);
    }


    public function bezettingSave(Request $req){
        $periode = $req->periode;
        $nama = $req->nama;
        $jenisKelamin = $req->jenisKelamin;
        $jabatan = $req->jabatan;
        $eselon = $req->eselon;
        $golongan = $req->golongan;
        $pangkat = $req->pangkat;
        $tmt = $req->tmt;
        $pendidikan = $req->pendidikan;
        $diklatTeknis = $req->diklatTeknis;
        $diklatPenjenjangan = $req->diklatPenjenjangan;
        $diklatLain = $req->diklatLain;
        $keterangan = ($req->keterangan != null) ? $req->keterangan : "-";
        if( 
            !isset($periode)||
            !isset($nama)||
            !isset($jenisKelamin)||
            !isset($jabatan)||
            !isset($eselon)||
            !isset($golongan)||
            !isset($pangkat)||
            !isset($tmt)||
            !isset($pendidikan)||
            !isset($diklatTeknis)||
            !isset($diklatPenjenjangan)||
            !isset($diklatLain)||
            !isset($keterangan)
        )   return Helper::composeReply2("ERROR", "Parameter tidak lengkap");

        DB::table("tu_kepegawaian_bezetting")->insertGetId([
            "BZTG_PERIODE" => $periode,
            "BZTG_NAMA" => $nama,
            "BZTG_JENIS_KELAMIN" => $jenisKelamin,
            "BZTG_JABATAN" => $jabatan,
            "BZTG_ESELON" => $eselon,
            "BZTG_GOLONGAN" => $golongan,
            "BZTG_PANGKAT" => $pangkat,
            "BZTG_TMT" => $tmt,
            "BZTG_PENDIDIKAN" => $pendidikan,
            "BZTG_DIKLAT_TEKNIS" => $diklatTeknis,
            "BZTG_DIKLAT_PENJENJANGAN" => $diklatPenjenjangan,
            "BZTG_DIKLAT_LAINNYA" => $diklatLain,
            "BZTG_KETERANGAN" => $keterangan
        ]);

        return Helper::composeReply2("SUCCESS", "Berhasil menyimpan data");
    }


    public function bezettingDetail(Request $req){
        $id = $req->id;
        if(!isset($id)){
            return Helper::composeReply2("ERROR", "Parameter tidak lengkap");
        }

        $data = DB::table("tu_kepegawaian_bezetting")->where("BZTG_ID", $id)->first();
        if(!isset($data)){
            return Helper::composeReply2("Teradi kesalahan, data tidak ditemukan");
        }

        return Helper::composeReply2("SUCCESS", "Data", $data);
    }


    public function bezettingUpdate(Request $req){
        $id = $req->id;
        $nama = $req->nama;
        $jenisKelamin = $req->jenisKelamin;
        $jabatan = $req->jabatan;
        $eselon = $req->eselon;
        $golongan = $req->golongan;
        $pangkat = $req->pangkat;
        $tmt = $req->tmt;
        $pendidikan = $req->pendidikan;
        $diklatTeknis = $req->diklatTeknis;
        $diklatPenjenjangan = $req->diklatPenjenjangan;
        $diklatLain = $req->diklatLain;
        $keterangan = ($req->keterangan != null) ? $req->keterangan : "-";
        if( 
            !isset($id)||
            !isset($nama)||
            !isset($jenisKelamin)||
            !isset($jabatan)||
            !isset($eselon)||
            !isset($golongan)||
            !isset($pangkat)||
            !isset($tmt)||
            !isset($pendidikan)||
            !isset($diklatTeknis)||
            !isset($diklatPenjenjangan)||
            !isset($diklatLain)||
            !isset($keterangan)
        )   return Helper::composeReply2("ERROR", "Parameter tidak lengkap");

        DB::table("tu_kepegawaian_bezetting")->where("BZTG_ID", $id)->update([
            "BZTG_NAMA" => $nama,
            "BZTG_JENIS_KELAMIN" => $jenisKelamin,
            "BZTG_JABATAN" => $jabatan,
            "BZTG_ESELON" => $eselon,
            "BZTG_GOLONGAN" => $golongan,
            "BZTG_PANGKAT" => $pangkat,
            "BZTG_TMT" => $tmt,
            "BZTG_PENDIDIKAN" => $pendidikan,
            "BZTG_DIKLAT_TEKNIS" => $diklatTeknis,
            "BZTG_DIKLAT_PENJENJANGAN" => $diklatPenjenjangan,
            "BZTG_DIKLAT_LAINNYA" => $diklatLain,
            "BZTG_KETERANGAN" => $keterangan
        ]);

        return Helper::composeReply2("SUCCESS", "Berhasil memperbarui data");
    }


    public function bezettingUpdateCopy(Request $req){
        $periode = $req->periode;
        $lastPeriode = strtotime($periode.' -1 month');
        $lastPeriodeStr = date('Y-m', $lastPeriode);

        DB::beginTransaction();

        $data = DB::table("tu_kepegawaian_bezetting")->where("BZTG_PERIODE", $lastPeriodeStr)->get();
        if(count($data) > 0){
            DB::table("tu_kepegawaian_bezetting")->where("BZTG_PERIODE", $periode)->delete();
            foreach ($data as $aData) {
                try {
                    DB::table("tu_kepegawaian_bezetting")->insertGetId([
                        "BZTG_PERIODE" => $periode,
                        "BZTG_NAMA" => $aData->BZTG_NAMA,
                        "BZTG_JENIS_KELAMIN" => $aData->BZTG_JENIS_KELAMIN,
                        "BZTG_JABATAN" => $aData->BZTG_JABATAN,
                        "BZTG_ESELON" => $aData->BZTG_ESELON,
                        "BZTG_GOLONGAN" => $aData->BZTG_GOLONGAN,
                        "BZTG_PANGKAT" => $aData->BZTG_PANGKAT,
                        "BZTG_TMT" => $aData->BZTG_TMT,
                        "BZTG_PENDIDIKAN" => $aData->BZTG_PENDIDIKAN,
                        "BZTG_DIKLAT_TEKNIS" => $aData->BZTG_DIKLAT_TEKNIS,
                        "BZTG_DIKLAT_PENJENJANGAN" => $aData->BZTG_DIKLAT_PENJENJANGAN,
                        "BZTG_DIKLAT_LAINNYA" => $aData->BZTG_DIKLAT_LAINNYA,
                        "BZTG_KETERANGAN" => $aData->BZTG_KETERANGAN
                    ]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return Helper::composeReply2("ERROR", "Terjadi kesalahan internal ");
                }
            }
        }

        DB::commit();

        return Helper::composeReply2("SUCCESS", "Berhasil menyalin data");
    }


    public function bezettingDelete(Request $req){
        $id = $req->id;
        if(!isset($id)){
            return Helper::composeReply2("ERROR", "Parameter tidak lengkap");
        }

        DB::table("tu_kepegawaian_bezetting")->where("BZTG_ID", $id)->delete();

        return Helper::composeReply2("SUCCESS", "Data terhapus");
    }


    public function rekap(Request $req){
        $periode = $req->periode;

        DB::beginTransaction();
        
        //
        $rekap = DB::table("tu_kepegawaian_rekapitulasi")->where("REKP_PERIODE", $periode)->get();
        if(!isset($rekap) || count($rekap) < 1){
            $arrGolongan = Helper::getReference("GOLONGAN");
            try {
                foreach ($arrGolongan as $aData) {
                    DB::table("tu_kepegawaian_rekapitulasi")->insert([
                        "REKP_PERIODE" => $periode,
                        "REKP_GOLONGAN" => $aData->R_ID
                    ]);
                }
            } catch (\Exception $e) {
                DB::rollback();
                return Helper::composeReply2("ERROR", "Terjadi kesalahan internal");
            } 
            $rekap = DB::table("tu_kepegawaian_rekapitulasi")->where("REKP_PERIODE", $periode)->get();
        }

        $rekap2 = DB::table("tu_kepegawaian_rekapitulasi_ppnpn")->where("REKP_PERIODE", $periode)->get();
        if(!isset($rekap2) || count($rekap2) < 1){
            $arrJenis = Helper::getReference("JENIS_PPNPN");
            try {
                foreach ($arrJenis as $aData) {
                    DB::table("tu_kepegawaian_rekapitulasi_ppnpn")->insert([
                        "REKP_PERIODE" => $periode,
                        "REKP_JENIS" => $aData->R_ID
                    ]);
                }
            } catch (\Exception $e) {
                DB::rollback();
                return Helper::composeReply2("ERROR", "Terjadi kesalahan internal");
            } 
            $rekap2 = DB::table("tu_kepegawaian_rekapitulasi_ppnpn")->where("REKP_PERIODE", $periode)->get();
        }

        DB::commit();

        $data["ctl_periode"] = $periode;
        $data["ctl_data"] = $rekap;
        $data["ctl_data2"] = $rekap2;

        return view("main.tu.kepegawaian.rekapitulasi", $data);
    }

    public function rekapUpdate(Request $req){
        $data = $req->data;
        $data2 = $req->data2;
        if(!isset($data) || !isset($data2)){
            return Helper::composeReply2("ERROR", "Parameter tidak lengkap");
        }

        DB::beginTransaction();

        $dataJSON = json_decode($data);
        try {
            foreach($dataJSON as $aData) {
                DB::table("tu_kepegawaian_rekapitulasi")->where("REKP_ID", $aData->REKP_ID)->update([
                        "REKP_PANGKAT_A" => $aData->REKP_PANGKAT_A,
                        "REKP_PANGKAT_B" => $aData->REKP_PANGKAT_B,
                        "REKP_PANGKAT_C" => $aData->REKP_PANGKAT_C,
                        "REKP_PANGKAT_D" => $aData->REKP_PANGKAT_D,
                        "REKP_TEKNIS_LAKI" => $aData->REKP_TEKNIS_LAKI,
                        "REKP_TEKNIS_PEREMPUAN" => $aData->REKP_TEKNIS_PEREMPUAN,
                        "REKP_NONTEKNIS_LAKI" => $aData->REKP_NONTEKNIS_LAKI,
                        "REKP_NONTEKNIS_PEREMPUAN" => $aData->REKP_NONTEKNIS_PEREMPUAN,
                        "REKP_STRUKTURAL_LAKI" => $aData->REKP_STRUKTURAL_LAKI,
                        "REKP_STRUKTURAL_PEREMPUAN" => $aData->REKP_STRUKTURAL_PEREMPUAN,
                        "REKP_NONSTRUKTURAL_LAKI" => $aData->REKP_NONSTRUKTURAL_LAKI,
                        "REKP_NONSTRUKTURAL_PEREMPUAN" => $aData->REKP_NONSTRUKTURAL_PEREMPUAN
                    ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return Helper::composeReply2("ERROR", "Terjadi kesalahan internal ");
        }

        $dataJSON2 = json_decode($data2);
        try {
            foreach($dataJSON2 as $aData) {
                DB::table("tu_kepegawaian_rekapitulasi_ppnpn")->where("REKP_ID", $aData->REKP_ID)->update([
                        "REKP_LAKI" => $aData->REKP_LAKI,
                        "REKP_PEREMPUAN" => $aData->REKP_PEREMPUAN
                    ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return Helper::composeReply2("ERROR", "Terjadi kesalahan internal ");
        }

        DB::commit();

        return Helper::composeReply2("SUCCESS", "Berhasil menyimpan data");
    }


    public function rekapUpdateCopy(Request $req){
        $periode = $req->periode;
        $lastPeriode = strtotime($periode.' -1 month');
        $lastPeriodeStr = date('Y-m', $lastPeriode);

        DB::beginTransaction();

        $data = DB::table("tu_kepegawaian_rekapitulasi")->where("REKP_PERIODE", $lastPeriodeStr)->get();
        if(count($data) > 0){
            DB::table("tu_kepegawaian_rekapitulasi")->where("REKP_PERIODE", $periode)->delete();
            foreach ($data as $aData) {
                try {
                    DB::table("tu_kepegawaian_rekapitulasi")->insertGetId([
                        "REKP_PERIODE" => $periode,
                        "REKP_GOLONGAN" => $aData->REKP_GOLONGAN,
                        "REKP_PANGKAT_A" => $aData->REKP_PANGKAT_A,
                        "REKP_PANGKAT_B" => $aData->REKP_PANGKAT_B,
                        "REKP_PANGKAT_C" => $aData->REKP_PANGKAT_C,
                        "REKP_PANGKAT_D" => $aData->REKP_PANGKAT_D,
                        "REKP_TEKNIS_LAKI" => $aData->REKP_TEKNIS_LAKI,
                        "REKP_TEKNIS_PEREMPUAN" => $aData->REKP_TEKNIS_PEREMPUAN,
                        "REKP_NONTEKNIS_LAKI" => $aData->REKP_NONTEKNIS_LAKI,
                        "REKP_NONTEKNIS_PEREMPUAN" => $aData->REKP_NONTEKNIS_PEREMPUAN,
                        "REKP_STRUKTURAL_LAKI" => $aData->REKP_STRUKTURAL_LAKI,
                        "REKP_STRUKTURAL_PEREMPUAN" => $aData->REKP_STRUKTURAL_PEREMPUAN,
                        "REKP_NONSTRUKTURAL_LAKI" => $aData->REKP_NONSTRUKTURAL_LAKI,
                        "REKP_NONSTRUKTURAL_PEREMPUAN" => $aData->REKP_NONSTRUKTURAL_PEREMPUAN
                    ]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return Helper::composeReply2("ERROR", "Terjadi kesalahan internal");
                }
            }
        }

        $data2 = DB::table("tu_kepegawaian_rekapitulasi_ppnpn")->where("REKP_PERIODE", $lastPeriodeStr)->get();
        if(count($data2) > 0){
            DB::table("tu_kepegawaian_rekapitulasi_ppnpn")->where("REKP_PERIODE", $periode)->delete();
            foreach ($data2 as $aData) {
                try {
                    DB::table("tu_kepegawaian_rekapitulasi_ppnpn")->insertGetId([
                        "REKP_PERIODE" => $periode,
                        "REKP_JENIS" => $aData->REKP_JENIS,
                        "REKP_LAKI" => $aData->REKP_LAKI,
                        "REKP_PEREMPUAN" => $aData->REKP_PEREMPUAN
                    ]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return Helper::composeReply2("ERROR", "Terjadi kesalahan internal");
                }
            }
        }

        DB::commit();

        return Helper::composeReply2("SUCCESS", "Berhasil menyalin data");
    }


    public function cuti(Request $req){
        $periode = $req->periode;

        DB::beginTransaction();
        //
        $cuti = DB::table("tu_kepegawaian_cuti")->where("CUTI_PERIODE", $periode)->get();
        if(!isset($cuti) || count($cuti) < 1){
            $arrGolongan = Helper::getReference("ALASAN_CUTI");
            try {
                foreach ($arrGolongan as $aData) {
                    DB::table("tu_kepegawaian_cuti")->insert([
                        "CUTI_PERIODE" => $periode,
                        "CUTI_ALASAN" => $aData->R_ID
                    ]);
                }
            } catch (\Exception $e) {
                DB::rollback();
                return Helper::composeReply2("ERROR", "Terjadi kesalahan internal");
            } 
            $cuti = DB::table("tu_kepegawaian_cuti")->where("CUTI_PERIODE", $periode)->get();
        }

        DB::commit();

        $data["ctl_periode"] = $periode;
        $data["ctl_data"] = $cuti;

        return view("main.tu.kepegawaian.cuti", $data);
    }

    public function cutiUpdate(Request $req){
        $data = $req->data;
        if(!isset($data)){
            return Helper::composeReply2("ERROR", "Parameter tidak lengkap");
        }
        $dataJSON = json_decode($data);

        DB::beginTransaction();
        
        try {
            foreach($dataJSON as $aData) {
                DB::table("tu_kepegawaian_cuti")->where("CUTI_ID", $aData->CUTI_ID)->update([
                        "CUTI_JUMLAH" => $aData->CUTI_JUMLAH,
                        "CUTI_KETERANGAN" => $aData->CUTI_KETERANGAN
                    ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return Helper::composeReply2("ERROR", "Terjadi kesalahan internal");
        }

        DB::commit();

        return Helper::composeReply2("SUCCESS", "Berhasil menyimpan data");
    }


    public function pembinaan(Request $req){
        $periode = $req->periode;

        //
        $pembinaan = DB::table("tu_kepegawaian_pembinaan")->where("PBNN_PERIODE", $periode)->get();

        $data["ctl_periode"] = $periode;
        $data["ctl_data"] = $pembinaan;

        return view("main.tu.kepegawaian.pembinaan", $data);
    }


    public function pembinaanSave(Request $req){
        $periode = $req->periode;
        $jenis = $req->jenis;
        $keterangan = ($req->keterangan != null) ? $req->keterangan : "-";
        if( 
            !isset($periode)||
            !isset($jenis)||
            !isset($keterangan)
        )   return Helper::composeReply2("ERROR", "Parameter tidak lengkap");

        DB::table("tu_kepegawaian_pembinaan")->insertGetId([
            "PBNN_PERIODE" => $periode,
            "PBNN_JENIS" => $jenis,
            "PBNN_KETERANGAN" => $keterangan
        ]);

        return Helper::composeReply2("SUCCESS", "Berhasil menyimpan data");
    }


    public function pembinaanDetail(Request $req){
        $id = $req->id;
        if(!isset($id)){
            return Helper::composeReply2("ERROR", "Parameter tidak lengkap");
        }

        $data = DB::table("tu_kepegawaian_pembinaan")->where("PBNN_ID", $id)->first();
        if(!isset($data)){
            return Helper::composeReply2("Teradi kesalahan, data tidak ditemukan");
        }

        return Helper::composeReply2("SUCCESS", "Data", $data);
    }


    public function pembinaanUpdate(Request $req){
        $id = $req->id;
        $jenis = $req->jenis;
        $keterangan = ($req->keterangan != null) ? $req->keterangan : "-";
        if( 
            !isset($id)||
            !isset($jenis)||
            !isset($keterangan)
        )   return Helper::composeReply2("ERROR", "Parameter tidak lengkap");

        DB::table("tu_kepegawaian_pembinaan")->where("PBNN_ID", $id)->update([
            "PBNN_JENIS" => $jenis,
            "PBNN_KETERANGAN" => $keterangan
        ]);

        return Helper::composeReply2("SUCCESS", "Berhasil memperbarui data");
    }


    public function pembinaanDelete(Request $req){
        $id = $req->id;
        if(!isset($id)){
            return Helper::composeReply2("ERROR", "Parameter tidak lengkap");
        }

        DB::table("tu_kepegawaian_pembinaan")->where("PBNN_ID", $id)->delete();

        return Helper::composeReply2("SUCCESS", "Data terhapus");
    }


}
