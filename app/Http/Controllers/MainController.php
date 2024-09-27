<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller as mCtl;
use Illuminate\Http\Request;
use App\Model as M;
use Helper, DB;
use Carbon\Carbon;

class MainController
{

    protected $request;
    protected $countLoad;

    public function __construct(Request $req) {
        $this->countLoad = 1;
    }


    public function tes(Request $req){
        return Helper::composeReply2("SUCCESS", "tes from MainController", date("Y-m-d H:i:s"));
    }


    public function tes2(Request $req){
        DB::beginTransaction();
        $arr = [1, 2];
        try {
            // DB::table("_setting")->insert(["SET_ID" => date("YmdHis"), "SET_VALUE" => "-", "SET_INFO" => "-"]);
            // DB::table("_setting")->insert(["SET_ID" => "_1", "SET_VALUE" => "-", "SET_INFO" => $arr[3]]);
            //DB::table("_setting")->insert(["SET_ID" => "_1", "SET_VALUE" => "-", "SET_INFO" => "-"]);
            //DB::table("_setting")->where("SET_ID", "_1")->update(["SET_VALUE" => "hm"]);

            DB::table("pldp")->where("PLDP_PERIODE", "2021-05")->delete();
            DB::table("tupoksi")->where("TPKS_PERIODE", "2021-05")->delete();
            DB::table("tu_belanja_realisasi_belanja")->where("RM_PERIODE", "2021-05")->delete();
            DB::table("tu_belanja_realisasi_pendapatan")->where("PNP_PERIODE", "2021-05")->delete();
        } catch (\Exception $e) {
            DB::rollback();
            return "Terjadi kesalahan internal".$e;
        } 

        DB::commit();
        return "YYY";
    }


    public function parseJSON(Request $req){
        //$data = json_decode($req->jsonStr);
        $data = DB::table("tu_umum_sarpras")->where("SARPRAS_PERIODE", "2021-07")->get();
        return Helper::composeReply2("SUCCESS", $data);
    }


    public function home(Request $req){
        $periode = $req->periode;

        DB::beginTransaction();

        //
        $data["ctl_pldp"] = DB::table("pldp as A")
                            ->join("negara as B", "A.PLDP_NEGARA", "=", "B.NGR_KODE")
                            ->where("A.PLDP_PERIODE", $periode)
                            ->where(function($query) {
                                $query->where('A.PLDP_LAKI', '!=', "0")
                                    ->orWhere('A.PLDP_PEREMPUAN', '!=', "0");
                            })
                            ->orderBy("NGR_NAMA", "desc")
                            ->get();
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_pldp"] as $aData) {
                $aData->PLDP_ID = (int) $aData->PLDP_ID;
                $aData->PLDP_LAKI = (int) $aData->PLDP_LAKI;
                $aData->PLDP_PEREMPUAN = (int) $aData->PLDP_PEREMPUAN;
            }
        }

        $data["ctl_pldp_"] = DB::table("pldp_ as A")
                            ->join("negara as B", "A.PLDP_NEGARA", "=", "B.NGR_KODE")
                            ->where("A.PLDP_PERIODE", $periode)
                            ->where(function($query) {
                                $query->where('A.PLDP_LAKI', '!=', "0")
                                    ->orWhere('A.PLDP_PEREMPUAN', '!=', "0");
                            })
                            ->orderBy("NGR_NAMA", "desc")
                            ->get();
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_pldp_"] as $aData) {
                $aData->PLDP_ID = (int) $aData->PLDP_ID;
                $aData->PLDP_LAKI = (int) $aData->PLDP_LAKI;
                $aData->PLDP_PEREMPUAN = (int) $aData->PLDP_PEREMPUAN;
            }
        }

        $data["ctl_tupoksi"] = DB::table("tupoksi as A")
                            ->join("_reference as B", "A.TPKS_JENIS", "=", "B.R_ID")
                            ->where("A.TPKS_PERIODE", $periode)->get();
        if(count($data["ctl_tupoksi"]) < 1){
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
            $data["ctl_tupoksi"] = DB::table("tupoksi")->where("TPKS_PERIODE", $req->periode)->get();
        }
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_tupoksi"] as $aData) {
                $aData->TPKS_ID = (int) $aData->TPKS_ID;
                $aData->TPKS_LAKI = (int) $aData->TPKS_LAKI;
                $aData->TPKS_PEREMPUAN = (int) $aData->TPKS_PEREMPUAN;
            }
        }

        //
        $data["ctl_rm"] = DB::table("tu_belanja_realisasi_belanja as A")
                            ->join("_reference as B", "A.RM_JENIS", "=", "B.R_ID")
                            ->where("A.RM_PERIODE", $periode)->get();
        if(count($data["ctl_rm"]) < 1){
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
            $data["ctl_rm"] = DB::table("tu_belanja_realisasi_belanja")->where("RM_PERIODE", $req->periode)->get();
        }
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_rm"] as $aData) {
                $aData->RM_ID = (int) $aData->RM_ID;
                $aData->RM_PAGU = (int) $aData->RM_PAGU;
                $aData->RM_TARGET_RP = (int) $aData->RM_TARGET_RP;
                $aData->RM_TARGET_PERSEN = (float) $aData->RM_TARGET_PERSEN;
                $aData->RM_REALISASI_RP = (int) $aData->RM_REALISASI_RP;
                $aData->RM_REALISASI_PERSEN = (float) $aData->RM_REALISASI_PERSEN;
                $aData->RM_SISA_DANA = (int) $aData->RM_SISA_DANA;
            }
        }

        //
        $data["ctl_pnp"] = DB::table("tu_belanja_realisasi_pendapatan as A")
                            ->join("_reference as B", "A.PNP_URAIAN", "=", "B.R_ID")
                            ->where("A.PNP_PERIODE", $periode)->get();
        if(count($data["ctl_pnp"]) < 1){
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
            $data["ctl_pnp"] = DB::table("tu_belanja_realisasi_pendapatan")->where("PNP_PERIODE", $req->periode)->get();
        }
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_pnp"] as $aData) {
                $aData->PNP_ID = (int) $aData->PNP_ID;
                $aData->PNP_JUMLAH = (int) $aData->PNP_JUMLAH;
            }
        }

        DB::commit();
        //dd($data["ctl_rm"]);

        $data["ctl_periode"] = $periode;

        // case bug aneh di grafik frontend
        if($this->countLoad == 1){
            $this->countLoad++;
            return $this->home($req);
        }

    	return view("main.home", $data);
    }


    // PLDP
    public function pldp(Request $req){
        $periode = $req->periode;
        $negara = $req->negara;
        if(!isset($negara)){
            return redirect()->back()->with("warning", "Paramter tidak lengkap");
        }

        $dataNegara = DB::table("negara")->where("NGR_KODE", $negara)->first();
        if($negara != "__PILIH__" && !isset($dataNegara)){
            return redirect()->back()->with("warning", "kode negara tidak valid");
        }

        //
        $pldp = DB::table("pldp")->where("PLDP_PERIODE", $periode)->where("PLDP_NEGARA", $negara)->first();
        if(!isset($pldp) && $negara != "__PILIH__"){
            $insert = DB::table("pldp")->insertGetId([
                "PLDP_PERIODE" => $periode,
                "PLDP_NEGARA" => $negara
                ]);

            $pldp = DB::table("pldp")->where("PLDP_ID", $insert)->first();
        }
        $refNegara = DB::table("negara")->get();

        $pldpAll = DB::table("pldp as A")
            ->join("negara as B", "A.PLDP_NEGARA", "=", "B.NGR_KODE")
            ->where("A.PLDP_PERIODE", $periode)
            ->where(function($query) {
                $query->where('A.PLDP_LAKI', '!=', "0")
                    ->orWhere('A.PLDP_PEREMPUAN', '!=', "0");
                })
            ->get();
        //dd($pldpAll);

        //
        $data["ctl_periode"] = $periode;
        $data["ctl_negara"] = $negara;
        $data["ctl_refNegara"] = $refNegara;
        $data["ctl_data"] = $pldp;
        $data["ctl_dataAll"] = $pldpAll;

        return view("main.pldp", $data);
    }


    public function pldpUpdate(Request $req){
        $periode = $req->periode;
        $negara = $req->negara;
        $laki = $req->laki;
        $perempuan = $req->perempuan;
        if(!isset($periode) || !isset($negara) || !isset($laki) || !isset($perempuan)){
            return Helper::composeReply2("ERROR", "Parameter tidak lengkap");
        }

        $pldp = DB::table("pldp")->where("PLDP_PERIODE", $periode)->where("PLDP_NEGARA", $negara)->first();
        if(!isset($pldp))   return Helper::composeReply2("ERROR", "Data tidak valid, harap iperiksa kembali inputan anda");

        $update = DB::table("pldp")->where("PLDP_NEGARA", $negara)->where("PLDP_PERIODE", $periode)->update([
            "PLDP_LAKI" => $laki,
            "PLDP_PEREMPUAN" => $perempuan
            ]);
        
        return Helper::composeReply2("SUCCESS", "Data tersimpan");
    }


    // PLDP_
    public function pldp_(Request $req){
        $periode = $req->periode;
        $negara = $req->negara;
        if(!isset($negara)){
            return redirect()->back()->with("warning", "Paramter tidak lengkap");
        }

        $dataNegara = DB::table("negara")->where("NGR_KODE", $negara)->first();
        if($negara != "__PILIH__" && !isset($dataNegara)){
            return redirect()->back()->with("warning", "kode negara tidak valid");
        }

        //
        $pldp_ = DB::table("pldp_")->where("PLDP_PERIODE", $periode)->where("PLDP_NEGARA", $negara)->first();
        if(!isset($pldp_) && $negara != "__PILIH__"){
            $insert = DB::table("pldp_")->insertGetId([
                "PLDP_PERIODE" => $periode,
                "PLDP_NEGARA" => $negara
                ]);

            $pldp_ = DB::table("pldp_")->where("PLDP_ID", $insert)->first();
        }
        $refNegara = DB::table("negara")->get();

        $pldpAll = DB::table("pldp_ as A")
            ->join("negara as B", "A.PLDP_NEGARA", "=", "B.NGR_KODE")
            ->where("A.PLDP_PERIODE", $periode)
            ->where(function($query) {
                $query->where('A.PLDP_LAKI', '!=', "0")
                    ->orWhere('A.PLDP_PEREMPUAN', '!=', "0");
                })
            ->get();
        //dd($pldpAll);

        //
        $data["ctl_periode"] = $periode;
        $data["ctl_negara"] = $negara;
        $data["ctl_refNegara"] = $refNegara;
        $data["ctl_data"] = $pldp_;
        $data["ctl_dataAll"] = $pldpAll;

        return view("main.pldp_", $data);
    }


    public function pldp_Update(Request $req){
        $periode = $req->periode;
        $negara = $req->negara;
        $laki = $req->laki;
        $perempuan = $req->perempuan;
        if(!isset($periode) || !isset($negara) || !isset($laki) || !isset($perempuan)){
            return Helper::composeReply2("ERROR", "Parameter tidak lengkap");
        }

        $pldp_ = DB::table("pldp_")->where("PLDP_PERIODE", $periode)->where("PLDP_NEGARA", $negara)->first();
        if(!isset($pldp_))   return Helper::composeReply2("ERROR", "Data tidak valid, harap iperiksa kembali inputan anda");

        $update = DB::table("pldp_")->where("PLDP_NEGARA", $negara)->where("PLDP_PERIODE", $periode)->update([
            "PLDP_LAKI" => $laki,
            "PLDP_PEREMPUAN" => $perempuan
            ]);
        
        return Helper::composeReply2("SUCCESS", "Data tersimpan");
    }


    // tupoksi
    public function tupoksi(Request $req){
        $periode = $req->periode;

        DB::beginTransaction();
        
        $tupoksi = DB::table("tupoksi")->where("TPKS_PERIODE", $periode)->get();
        if(!isset($tupoksi) || count($tupoksi) < 1){
            $arrJenis = Helper::getReference("JENIS_TUPOKSI");
            try {
                foreach ($arrJenis as $aData) {
                    DB::table("tupoksi")->insert([
                        "TPKS_PERIODE" => $periode,
                        "TPKS_JENIS" => $aData->R_ID
                    ]);
                }
            } catch (\Exception $e) {
                DB::rollback();
                return Helper::composeReply2("ERROR", "Terjadi kesalahan internal");
            } 
            $tupoksi = DB::table("tupoksi")->where("TPKS_PERIODE", $periode)->get();
        }

        DB::commit();

        $data["ctl_periode"] = $periode;
        $data["ctl_data"] = $tupoksi;

    	return view("main.tupoksi", $data);
    }


    public function tupoksiUpdate(Request $req){
        $data = $req->data;
        if(!isset($data)){
            return Helper::composeReply2("ERROR", "Parameter tidak lengkap");
        }
        $dataJSON = json_decode($data);

        DB::beginTransaction();

        try {
            foreach($dataJSON as $aData) {
                DB::table("tupoksi")->where("TPKS_ID", $aData->TPKS_ID)->update([
                        "TPKS_LAKI" => $aData->TPKS_LAKI,
                        "TPKS_PEREMPUAN" => $aData->TPKS_PEREMPUAN
                    ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return Helper::composeReply2("ERROR", "Terjadi kesalahan internal");
        }

        DB::commit();

        return Helper::composeReply2("SUCCESS", "Berhasil menyimpan data");
    }


    public function publicView(Request $req){
        $periode = $req->periode;

        DB::beginTransaction();

        //
        $data["ctl_pldp"] = DB::table("pldp as A")
                            ->join("negara as B", "A.PLDP_NEGARA", "=", "B.NGR_KODE")
                            ->where("A.PLDP_PERIODE", $periode)
                            ->where(function($query) {
                                $query->where('A.PLDP_LAKI', '!=', "0")
                                    ->orWhere('A.PLDP_PEREMPUAN', '!=', "0");
                            })
                            ->orderBy("NGR_NAMA", "desc")
                            ->get();
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_pldp"] as $aData) {
                $aData->PLDP_ID = (int) $aData->PLDP_ID;
                $aData->PLDP_LAKI = (int) $aData->PLDP_LAKI;
                $aData->PLDP_PEREMPUAN = (int) $aData->PLDP_PEREMPUAN;
            }
        }

        $data["ctl_pldp_"] = DB::table("pldp_ as A")
                            ->join("negara as B", "A.PLDP_NEGARA", "=", "B.NGR_KODE")
                            ->where("A.PLDP_PERIODE", $periode)
                            ->where(function($query) {
                                $query->where('A.PLDP_LAKI', '!=', "0")
                                    ->orWhere('A.PLDP_PEREMPUAN', '!=', "0");
                            })
                            ->orderBy("NGR_NAMA", "desc")
                            ->get();
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_pldp_"] as $aData) {
                $aData->PLDP_ID = (int) $aData->PLDP_ID;
                $aData->PLDP_LAKI = (int) $aData->PLDP_LAKI;
                $aData->PLDP_PEREMPUAN = (int) $aData->PLDP_PEREMPUAN;
            }
        }

        $data["ctl_tupoksi"] = DB::table("tupoksi as A")
                            ->join("_reference as B", "A.TPKS_JENIS", "=", "B.R_ID")
                            ->where("A.TPKS_PERIODE", $periode)->get();
        if(count($data["ctl_tupoksi"]) < 1){
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
            $data["ctl_tupoksi"] = DB::table("tupoksi")->where("TPKS_PERIODE", $req->periode)->get();
        }
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_tupoksi"] as $aData) {
                $aData->TPKS_ID = (int) $aData->TPKS_ID;
                $aData->TPKS_LAKI = (int) $aData->TPKS_LAKI;
                $aData->TPKS_PEREMPUAN = (int) $aData->TPKS_PEREMPUAN;
            }
        }

        //
        $data["ctl_rm"] = DB::table("tu_belanja_realisasi_belanja as A")
                            ->join("_reference as B", "A.RM_JENIS", "=", "B.R_ID")
                            ->where("A.RM_PERIODE", $periode)->get();
        if(count($data["ctl_rm"]) < 1){
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
            $data["ctl_rm"] = DB::table("tu_belanja_realisasi_belanja")->where("RM_PERIODE", $req->periode)->get();
        }
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_rm"] as $aData) {
                $aData->RM_ID = (int) $aData->RM_ID;
                $aData->RM_PAGU = (int) $aData->RM_PAGU;
                $aData->RM_TARGET_RP = (int) $aData->RM_TARGET_RP;
                $aData->RM_TARGET_PERSEN = (float) $aData->RM_TARGET_PERSEN;
                $aData->RM_REALISASI_RP = (int) $aData->RM_REALISASI_RP;
                $aData->RM_REALISASI_PERSEN = (float) $aData->RM_REALISASI_PERSEN;
                $aData->RM_SISA_DANA = (int) $aData->RM_SISA_DANA;
            }
        }

        //
        $data["ctl_pnp"] = DB::table("tu_belanja_realisasi_pendapatan as A")
                            ->join("_reference as B", "A.PNP_URAIAN", "=", "B.R_ID")
                            ->where("A.PNP_PERIODE", $periode)->get();
        if(count($data["ctl_pnp"]) < 1){
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
            $data["ctl_pnp"] = DB::table("tu_belanja_realisasi_pendapatan")->where("PNP_PERIODE", $req->periode)->get();
        }
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_pnp"] as $aData) {
                $aData->PNP_ID = (int) $aData->PNP_ID;
                $aData->PNP_JUMLAH = (int) $aData->PNP_JUMLAH;
            }
        }

        //
        $data["ctl_ikpa"] = DB::table("tu_ikpa")->where("IKPA_PERIODE", "LIKE", $req->periode ."%")->get();
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_ikpa"] as $aData) {
                $aData->IKPA_ID = (int) $aData->IKPA_ID;
                $aData->IKPA_NILAI_AKHIR = (float) $aData->IKPA_NILAI_AKHIR;
            }
        }

        //
        $data["ctl_rekapitulasi"] = DB::table("tu_kepegawaian_rekapitulasi")->where("REKP_PERIODE", $req->periode)->get();
        if(count($data["ctl_rekapitulasi"]) < 1){
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
            $data["ctl_rekapitulasi"] = DB::table("tu_kepegawaian_rekapitulasi")->where("REKP_PERIODE", $req->periode)->get();
        }
        foreach ($data["ctl_rekapitulasi"] as $aData) {
            $aData->REKP_GOLONGAN_ = Helper::getReferenceInfo("GOLONGAN", $aData->REKP_GOLONGAN);
        }
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_rekapitulasi"] as $aData) {
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

        $data["ctl_rekapitulasi2"] = DB::table("tu_kepegawaian_rekapitulasi_ppnpn")->where("REKP_PERIODE", $req->periode)->get();
        if(count($data["ctl_rekapitulasi2"]) < 1){
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
            $data["ctl_rekapitulasi2"] = DB::table("tu_kepegawaian_rekapitulasi_ppnpn")->where("REKP_PERIODE", $req->periode)->get();
        }
        foreach ($data["ctl_rekapitulasi2"] as $aData) {
            $aData->REKP_JENIS_ = Helper::getReferenceInfo("JENIS_PPNPN", $aData->REKP_JENIS);
        }
        if(env("MYSQLND_ENABLE") == "0"){//FORCE PARSE
            foreach ($data["ctl_rekapitulasi2"] as $aData) {
                $aData->REKP_ID = (int) $aData->REKP_ID;
                $aData->REKP_LAKI = (int) $aData->REKP_LAKI;
                $aData->REKP_PEREMPUAN = (int) $aData->REKP_PEREMPUAN;
            }
        }


        DB::commit();
        //dd($data["ctl_rm"]);

        $data["ctl_periode"] = $periode;

        // case bug aneh di grafik frontend
        if($this->countLoad == 1){
            $this->countLoad++;
            return $this->publicView($req);
        }
        //dd($data);
        return view("public-view", $data);
    }

}