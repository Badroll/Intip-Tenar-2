<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller as mCtl;
use Illuminate\Http\Request;
use App\Model as M;
use Helper, DB;
use Carbon\Carbon;

class GrafikController
{

    protected $request;

    public function __construct(Request $req) {
    }

    public function pldp(Request $req){
        $data["ctl_periode"] = $req->periode;
        $data["ctl_data"] = DB::table("pldp")->where("PLDP_PERIODE", $req->periode)->get();
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_data"] as $aData) {
                $aData->PLDP_ID = (int) $aData->PLDP_ID;
                $aData->PLDP_LAKI = (int) $aData->PLDP_LAKI;
                $aData->PLDP_PEREMPUAN = (int) $aData->PLDP_PEREMPUAN;
            }
        }
        return view("main.grafik.pldp", $data);
    }

    public function pldp_(Request $req){
        $data["ctl_periode"] = $req->periode;
        $data["ctl_data"] = DB::table("pldp_")->where("PLDP_PERIODE", $req->periode)->get();
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_data"] as $aData) {
                $aData->PLDP_ID = (int) $aData->PLDP_ID;
                $aData->PLDP_LAKI = (int) $aData->PLDP_LAKI;
                $aData->PLDP_PEREMPUAN = (int) $aData->PLDP_PEREMPUAN;
            }
        }
        return view("main.grafik.pldp_", $data);
    }

    public function tupoksi(Request $req){
        $data["ctl_periode"] = $req->periode;

        DB::beginTransaction();
        $data["ctl_data"] = DB::table("tupoksi")->where("TPKS_PERIODE", $req->periode)->get();
        if(count($data["ctl_data"]) < 1){
            $arrJenis = Helper::getReference("JENIS_TUPOKSI");
            try {
                foreach ($arrJenis as $aData) {
                    DB::table("tupoksi")->insert([
                        "TPKS_PERIODE" => $req->periode,
                        "TPKS_JENIS" => $aData->R_ID
                    ]);
                }
            } catch (\Exception $e) {
                DB::rollback();
                return Helper::composeReply2("ERROR", "Terjadi kesalahan internal");
            } 
            $data["ctl_data"] = DB::table("tupoksi")->where("TPKS_PERIODE", $req->periode)->get();
        }
        foreach ($data["ctl_data"] as $aData) {
            $aData->TPKS_JENIS_ = Helper::getReferenceInfo("JENIS_TUPOKSI", $aData->TPKS_JENIS);
        }
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_data"] as $aData) {
                $aData->TPKS_ID = (int) $aData->TPKS_ID;
                $aData->TPKS_LAKI = (int) $aData->TPKS_LAKI;
                $aData->TPKS_PEREMPUAN = (int) $aData->TPKS_PEREMPUAN;
            }
        }
        DB::commit();

        return view("main.grafik.tupoksi", $data);
    }

    public function tuBelanjaRealisasiBelanja(Request $req){
        $data["ctl_periode"] = $req->periode;

        DB::beginTransaction();
        $data["ctl_data"] = DB::table("tu_belanja_realisasi_belanja")->where("RM_PERIODE", $req->periode)->get();
        if(count($data["ctl_data"]) < 1){
            $arrJenis = Helper::getReference("JENIS_BELANJA");
            try {
                foreach ($arrJenis as $aData) {
                    DB::table("tu_belanja_realisasi_belanja")->insert([
                        "RM_PERIODE" => $req->periode,
                        "RM_JENIS" => $aData->R_ID
                    ]);
                }
            } catch (\Exception $e) {
                DB::rollback();
                return Helper::composeReply2("ERROR", "Terjadi kesalahan internal");
            } 
            $data["ctl_data"] = DB::table("tu_belanja_realisasi_belanja")->where("RM_PERIODE", $req->periode)->get();
        }
        foreach ($data["ctl_data"] as $aData) {
            $aData->RM_JENIS_ = Helper::getReferenceInfo("JENIS_BELANJA", $aData->RM_JENIS);
        }
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_data"] as $aData) {
                $aData->RM_ID = (int) $aData->RM_ID;
                $aData->RM_PAGU = (int) $aData->RM_PAGU;
                $aData->RM_TARGET_RP = (int) $aData->RM_TARGET_RP;
                $aData->RM_TARGET_PERSEN = (float) $aData->RM_TARGET_PERSEN;
                $aData->RM_REALISASI_RP = (int) $aData->RM_REALISASI_RP;
                $aData->RM_REALISASI_PERSEN = (float) $aData->RM_REALISASI_PERSEN;
                $aData->RM_SISA_DANA = (int) $aData->RM_SISA_DANA;
            }
        }
        DB::commit();
        
        return view("main.grafik.tu-belanja-realisasi-belanja", $data);
    }

    public function tuBelanjaRealisasiPendapatan(Request $req){
        $data["ctl_periode"] = $req->periode;

        DB::beginTransaction();
        $data["ctl_data"] = DB::table("tu_belanja_realisasi_pendapatan")->where("PNP_PERIODE", $req->periode)->get();
        if(count($data["ctl_data"]) < 1){
            $arrJenis = Helper::getReference("PENDAPATAN_URAIAN");
            try {
                foreach ($arrJenis as $aData) {
                    DB::table("tu_belanja_realisasi_pendapatan")->insert([
                        "PNP_PERIODE" => $req->periode,
                        "PNP_URAIAN" => $aData->R_ID
                    ]);
                }
            } catch (\Exception $e) {
                DB::rollback();
                return Helper::composeReply2("ERROR", "Terjadi kesalahan internal");
            } 
            $data["ctl_data"] = DB::table("tu_belanja_realisasi_pendapatan")->where("PNP_PERIODE", $req->periode)->get();
        }
        foreach ($data["ctl_data"] as $aData) {
            $aData->PNP_URAIAN_ = Helper::getReferenceInfo("PENDAPATAN_URAIAN", $aData->PNP_URAIAN);
        }
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_data"] as $aData) {
                $aData->PNP_ID = (int) $aData->PNP_ID;
                $aData->PNP_JUMLAH = (int) $aData->PNP_JUMLAH;
            }
        }
        DB::commit();
        
        return view("main.grafik.tu-belanja-realisasi-pendapatan", $data);
    }

    public function tuIKPA(Request $req){
        $data["ctl_periode"] = $req->periode;
        $data["ctl_data"] = DB::table("tu_ikpa")->where("IKPA_PERIODE", "LIKE", $req->periode ."%")->get();
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_data"] as $aData) {
                $aData->IKPA_ID = (int) $aData->IKPA_ID;
                $aData->IKPA_NILAI_AKHIR = (float) $aData->IKPA_NILAI_AKHIR;
            }
        }
        
        return view("main.grafik.tu-ikpa", $data);
    }

    public function tuKepegawaianBezetting(Request $req){
        $data["ctl_periode"] = $req->periode;
        $data["ctl_data"] = DB::table("tu_kepegawaian_bezetting")->where("BZTG_PERIODE", $req->periode)->get();
        foreach ($data["ctl_data"] as $aData) {
            $aData->BZTG_JENIS_KELAMIN_ = Helper::getReferenceInfo("JENIS_KELAMIN", $aData->BZTG_JENIS_KELAMIN);
            $aData->BZTG_GOLONGAN_ = Helper::getReferenceInfo("GOLONGAN", $aData->BZTG_GOLONGAN);
            $aData->BZTG_PANGKAT_ = Helper::getReferenceInfo("PANGKAT", $aData->BZTG_PANGKAT);
        }
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_data"] as $aData) {
                $aData->BZTG_ID = (int) $aData->BZTG_ID;
            }
        }
        return view("main.grafik.tu-kepegawaian-bezetting", $data);
    }

    public function tuKepegawaianRekap(Request $req){
        $data["ctl_periode"] = $req->periode;

        DB::beginTransaction();

        $data["ctl_data"] = DB::table("tu_kepegawaian_rekapitulasi")->where("REKP_PERIODE", $req->periode)->get();
        if(count($data["ctl_data"]) < 1){
            $arrJenis = Helper::getReference("GOLONGAN");
            try {
                foreach ($arrJenis as $aData) {
                    DB::table("tu_kepegawaian_rekapitulasi")->insert([
                        "REKP_PERIODE" => $req->periode,
                        "REKP_GOLONGAN" => $aData->R_ID
                    ]);
                }
            } catch (\Exception $e) {
                DB::rollback();
                return Helper::composeReply2("ERROR", "Terjadi kesalahan internal");
            } 
            $data["ctl_data"] = DB::table("tu_kepegawaian_rekapitulasi")->where("REKP_PERIODE", $req->periode)->get();
        }
        foreach ($data["ctl_data"] as $aData) {
            $aData->REKP_GOLONGAN_ = Helper::getReferenceInfo("GOLONGAN", $aData->REKP_GOLONGAN);
        }
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_data"] as $aData) {
                $aData->REKP_ID = (int) $aData->REKP_ID;
                $aData->REKP_PANGKAT_A = (int) $aData->REKP_PANGKAT_A;
                $aData->REKP_PANGKAT_B = (int) $aData->REKP_PANGKAT_B;
                $aData->REKP_PANGKAT_C = (int) $aData->REKP_PANGKAT_C;
                $aData->REKP_PANGKAT_D = (int) $aData->REKP_PANGKAT_D;
                $aData->REKP_TEKNIS_LAKI = (int) $aData->REKP_TEKNIS_LAKI;
                $aData->REKP_TEKNIS_PEREMPUAN = (int) $aData->REKP_TEKNIS_PEREMPUAN;
                $aData->REKP_NONTEKNIS_LAKI = (int) $aData->REKP_NONTEKNIS_LAKI;
                $aData->REKP_NONTEKNIS_PEREMPUAN = (int) $aData->REKP_NONTEKNIS_PEREMPUAN;
                $aData->REKP_STRUKTURAL_LAKI = (int) $aData->REKP_STRUKTURAL_LAKI;
                $aData->REKP_STRUKTURAL_PEREMPUAN = (int) $aData->REKP_STRUKTURAL_PEREMPUAN;
                $aData->REKP_NONSTRUKTURAL_LAKI = (int) $aData->REKP_NONSTRUKTURAL_LAKI;
                $aData->REKP_NONSTRUKTURAL_PEREMPUAN = (int) $aData->REKP_NONSTRUKTURAL_PEREMPUAN;
            }
        }

        $data["ctl_data2"] = DB::table("tu_kepegawaian_rekapitulasi_ppnpn")->where("REKP_PERIODE", $req->periode)->get();
        if(count($data["ctl_data2"]) < 1){
            $arrJenis = Helper::getReference("JENIS_PPNPN");
            try {
                foreach ($arrJenis as $aData) {
                    DB::table("tu_kepegawaian_rekapitulasi_ppnpn")->insert([
                        "REKP_PERIODE" => $req->periode,
                        "REKP_JENIS" => $aData->R_ID
                    ]);
                }
            } catch (\Exception $e) {
                DB::rollback();
                return Helper::composeReply2("ERROR", "Terjadi kesalahan internal");
            } 
            $data["ctl_data2"] = DB::table("tu_kepegawaian_rekapitulasi_ppnpn")->where("REKP_PERIODE", $req->periode)->get();
        }
        foreach ($data["ctl_data2"] as $aData) {
            $aData->REKP_JENIS_ = Helper::getReferenceInfo("JENIS_PPNPN", $aData->REKP_JENIS);
        }
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_data2"] as $aData) {
                $aData->REKP_ID = (int) $aData->REKP_ID;
                $aData->REKP_LAKI = (int) $aData->REKP_LAKI;
                $aData->REKP_PEREMPUAN = (int) $aData->REKP_PEREMPUAN;
            }
        }

        DB::commit();
        
        return view("main.grafik.tu-kepegawaian-rekapitulasi", $data);
    }

    public function tuKepegawaianCuti(Request $req){
        $data["ctl_periode"] = $req->periode;
        $data["ctl_data"] = DB::table("tu_kepegawaian_cuti")->where("CUTI_PERIODE", $req->periode)->get();
        foreach ($data["ctl_data"] as $aData) {
            $aData->CUTI_ALASAN_ = Helper::getReferenceInfo("ALASAN_CUTI", $aData->CUTI_ALASAN);
        }
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_data"] as $aData) {
                $aData->CUTI_ID = (int) $aData->CUTI_ID;
                $aData->CUTI_JUMLAH = (int) $aData->CUTI_JUMLAH;
            }
        }
        return view("main.grafik.tu-kepegawaian-cuti", $data);
    }

    public function tuKepegawaianPembinaan(Request $req){
        $data["ctl_periode"] = $req->periode;
        $data["ctl_data"] = DB::table("tu_kepegawaian_pembinaan")->where("PBNN_PERIODE", $req->periode)->get();
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_data"] as $aData) {
                $aData->PBNN_ID = (int) $aData->PBNN_ID;
            }
        }
        return view("main.grafik.tu-kepegawaian-pembinaan", $data);
    }

    public function tuUmumPersuratan(Request $req){
        $data["ctl_periode"] = $req->periode;
        $data["ctl_data"] = DB::table("tu_umum_persuratan")->where("SRT_PERIODE", $req->periode)->get();
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_data"] as $aData) {
                $aData->SRT_ID = (int) $aData->SRT_ID;
                $aData->SRT_MASUK = (int) $aData->SRT_MASUK;
                $aData->SRT_KELUAR = (int) $aData->SRT_KELUAR;
                $aData->SRT_KEPUTUSAN = (int) $aData->SRT_KEPUTUSAN;
                $aData->SRT_PERINTAH = (int) $aData->SRT_PERINTAH;
            }
        }
        return view("main.grafik.tu-umum-persuratan", $data);
    }

    public function tuUmumKendaraan(Request $req){
        $data["ctl_periode"] = $req->periode;
        $data["ctl_data"] = DB::table("tu_umum_kendaraan")->where("KNDRN_PERIODE", $req->periode)->get();
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_data"] as $aData) {
                $aData->KNDRN_ID = (int) $aData->KNDRN_ID;
            }
        }
        return view("main.grafik.tu-umum-kendaraan", $data);
    }

    public function tuUmumSarpras(Request $req){
        $data["ctl_periode"] = $req->periode;
        $data["ctl_data"] = DB::table("tu_umum_sarpras")->where("SARPRAS_PERIODE", $req->periode)->get();
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_data"] as $aData) {
                $aData->SARPRAS_ID = (int) $aData->SARPRAS_ID;
                $aData->SARPRAS_JUMLAH = (int) $aData->SARPRAS_JUMLAH;
            }
        }
        return view("main.grafik.tu-umum-sarpras", $data);
    }

    public function tuUmumBangunan(Request $req){
        $data["ctl_periode"] = $req->periode;
        $data["ctl_data"] = DB::table("tu_umum_bangunan")->where("BGNN_PERIODE", $req->periode)->get();
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_data"] as $aData) {
                $aData->BGNN_ID = (int) $aData->BGNN_ID;
            }
        }
        return view("main.grafik.tu-umum-bangunan", $data);
    }

}