<?php

namespace App\Http\Controllers\TU;
use App\Http\Controllers\Controller as mCtl;
use Illuminate\Http\Request;
use App\Model as M;
use Helper, DB;
use Carbon\Carbon;

class BelanjaController extends mCtl
{

    protected $request;

    public function __construct(Request $req) {
    }

    public function realisasiBelanja(Request $req){
        $periode = $req->periode;

        DB::beginTransaction();
        //
        $rm = DB::table("tu_belanja_realisasi_belanja")->where("RM_PERIODE", $periode)->get();
        if(!isset($rm) || count($rm) < 1){
            $arrJenis = Helper::getReference("JENIS_BELANJA");
            try {
                foreach ($arrJenis as $aData) {
                    DB::table("tu_belanja_realisasi_belanja")->insert([
                        "RM_PERIODE" => $periode,
                        "RM_JENIS" => $aData->R_ID
                    ]);
                }
            } catch (\Exception $e) {
                DB::rollback();
                return Helper::composeReply2("ERROR", "Terjadi kesalahan internal");
            } 
            $rm = DB::table("tu_belanja_realisasi_belanja")->where("RM_PERIODE", $periode)->get();
        }

        DB::commit();

        $data["ctl_periode"] = $periode;
        $data["ctl_data"] = $rm;
        

    	return view("main.tu.belanja.realisasi-belanja", $data);
    }

    public function realisasiBelanjaUpdate(Request $req){
        $data = $req->data;
        if(!isset($data)){
            return Helper::composeReply2("ERROR", "Parameter tidak lengkap");
        }
        $dataJSON = json_decode($data);
        
        DB::beginTransaction();
        
        try {
            foreach($dataJSON as $aData) {
                DB::table("tu_belanja_realisasi_belanja")->where("RM_ID", $aData->RM_ID)->update([
                        "RM_PAGU" => $aData->RM_PAGU,
                        "RM_TARGET_RP" => $aData->RM_TARGET_RP,
                        "RM_TARGET_PERSEN" => $aData->RM_TARGET_PERSEN,
                        "RM_REALISASI_RP" => $aData->RM_REALISASI_RP,
                        "RM_REALISASI_PERSEN" => $aData->RM_REALISASI_PERSEN,
                        "RM_SISA_DANA" => $aData->RM_SISA_DANA,
                        "RM_KETERANGAN" => $aData->RM_KETERANGAN
                    ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return Helper::composeReply2("ERROR", "Terjadi kesalahan internal ");
        }

        DB::commit();

        return Helper::composeReply2("SUCCESS", "Berhasil menyimpan data");
    }


    public function realisasiPendapatan(Request $req){
        $periode = $req->periode;

        DB::beginTransaction();
        //
        $pnp = DB::table("tu_belanja_realisasi_pendapatan")->where("PNP_PERIODE", $periode)->get();
        if(!isset($pnp) || count($pnp) < 1){
            $arrUraian = Helper::getReference("PENDAPATAN_URAIAN");
            try {
                foreach ($arrUraian as $aData) {
                    DB::table("tu_belanja_realisasi_pendapatan")->insert([
                        "PNP_PERIODE" => $periode,
                        "PNP_URAIAN" => $aData->R_ID
                    ]);
                }
            } catch (\Exception $e) {
                DB::rollback();
                return Helper::composeReply2("ERROR", "Terjadi kesalahan internal");
            } 
            $pnp = DB::table("tu_belanja_realisasi_pendapatan")->where("PNP_PERIODE", $periode)->get();
        }

        DB::commit();

        $data["ctl_periode"] = $periode;
        $data["ctl_data"] = $pnp;

        return view("main.tu.belanja.realisasi-pendapatan", $data);
    }

    public function realisasiPendapatanUpdate(Request $req){
        $data = $req->data;
        if(!isset($data)){
            return Helper::composeReply2("ERROR", "Parameter tidak lengkap");
        }
        $dataJSON = json_decode($data);

        DB::beginTransaction();
        
        try {
            foreach($dataJSON as $aData) {
                DB::table("tu_belanja_realisasi_pendapatan")->where("PNP_ID", $aData->PNP_ID)->update([
                        "PNP_JUMLAH" => $aData->PNP_JUMLAH
                    ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return Helper::composeReply2("ERROR", "Terjadi kesalahan internal ");
        }

        DB::commit();

        return Helper::composeReply2("SUCCESS", "Berhasil menyimpan data");
    }


}
