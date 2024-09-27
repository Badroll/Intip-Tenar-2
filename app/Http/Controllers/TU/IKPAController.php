<?php

namespace App\Http\Controllers\TU;
use App\Http\Controllers\Controller as mCtl;
use Illuminate\Http\Request;
use App\Model as M;
use Helper, DB;
use Carbon\Carbon;

class IKPAController extends mCtl
{

    protected $request;
    protected $dateLimit;

    public function __construct(Request $req) {
        $this->dateLimit = date("Y-m", strtotime("-1 months"));
    }

    public function ikpa(Request $req){
    	$periode = $req->periode;

        //
        $ikpa = DB::table("tu_ikpa")->where("IKPA_PERIODE", $periode)->get();
    	if(!isset($ikpa) || count($ikpa) < 1){
            DB::table("tu_ikpa")->insert([
                    "IKPA_PERIODE" => $periode
                ]);
            $ikpa = DB::table("tu_ikpa")->where("IKPA_PERIODE", $periode)->get();
        }

        $data["ctl_periode"] = $periode;
        $data["ctl_data"] = $ikpa;

    	return view("main.tu.ikpa", $data);
    }

    public function ikpaUpdate(Request $req){
        $data = $req->data;
        if(!isset($data)){
            return Helper::composeReply2("ERROR", "Parameter tidak lengkap");
        }
        $dataJSON = json_decode($data);

        DB::beginTransaction();

        try {
            foreach($dataJSON as $aData) {
                DB::table("tu_ikpa")->where("IKPA_ID", $aData->IKPA_ID)->update([
                        "IKPA_NILAI_AKHIR" => $aData->IKPA_NILAI_AKHIR
                    ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return Helper::composeReply2("ERROR", "Terjadi kesalahan internal");
        }

        DB::commit();

        return Helper::composeReply2("SUCCESS", "Berhasil menyimpan data");
    }

}