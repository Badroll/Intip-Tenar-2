<?php

namespace App\Http\Controllers\TU;
use App\Http\Controllers\Controller as mCtl;
use Illuminate\Http\Request;
use App\Model as M;
use Helper, DB;
use Carbon\Carbon;

class UmumController extends mCtl
{

    protected $request;

    public function __construct(Request $req) {
    }


    public function persuratan(Request $req){
        $periode = $req->periode;

        //
        $surat = DB::table("tu_umum_persuratan")->where("SRT_PERIODE", $periode)->first();
        if(!isset($surat)){
            DB::table("tu_umum_persuratan")->insert([
                "SRT_PERIODE" => $periode
            ]);
            $surat = DB::table("tu_umum_persuratan")->where("SRT_PERIODE", $periode)->first();
        }

        $data["ctl_periode"] = $periode;
        $data["ctl_data"] = $surat;

        return view("main.tu.umum.persuratan", $data);
    }


    public function persuratanUpdate(Request $req){
        $id = $req->id;
        $masuk = $req->masuk;
        $keluar = $req->keluar;
        $keputusan = $req->keputusan;
        $perintah = $req->perintah;
        if(!isset($id) || !isset($masuk) || !isset($keluar) || !isset($keputusan) || !isset($perintah)){
            return Helper::composeReply2("ERROR", "Parameter tidak lengkap");
        }
        
        DB::table("tu_umum_persuratan")->where("SRT_ID", $id)->update([
            "SRT_MASUK" => $masuk,
            "SRT_KELUAR" => $keluar,
            "SRT_KEPUTUSAN" => $keputusan,
            "SRT_PERINTAH" => $perintah
        ]);

        return Helper::composeReply2("SUCCESS", "Berhasil menyimpan data");
    }


    //
    public function kendaraan(Request $req){
        $periode = $req->periode;

        //
        $kendaraan = DB::table("tu_umum_kendaraan")->where("KNDRN_PERIODE", $periode)->get();

        $data["ctl_periode"] = $periode;
        $data["ctl_data"] = $kendaraan;

        return view("main.tu.umum.kendaraan", $data);
    }


    public function kendaraanSave(Request $req){
        $periode = $req->periode;
        $jenis = $req->jenis;
        $noPol = $req->noPol;
        $tahun = $req->tahun;
        $kondisi = $req->kondisi;
        if( 
            !isset($periode)||
            !isset($jenis)||
            !isset($noPol)||
            !isset($noPol)||
            !isset($kondisi)
        )   return Helper::composeReply2("ERROR", "Parameter tidak lengkap");

        DB::table("tu_umum_kendaraan")->insertGetId([
            "KNDRN_PERIODE" => $periode,
            "KNDRN_JENIS" => $jenis,
            "KNDRN_NO_POLISI" => $noPol,
            "KNDRN_TAHUN" => $tahun,
            "KNDRN_KONDISI" => $kondisi
        ]);

        return Helper::composeReply2("SUCCESS", "Berhasil menyimpan data");
    }


    public function kendaraanDetail(Request $req){
        $id = $req->id;
        if(!isset($id)){
            return Helper::composeReply2("ERROR", "Parameter tidak lengkap");
        }

        $data = DB::table("tu_umum_kendaraan")->where("KNDRN_ID", $id)->first();
        if(!isset($data)){
            return Helper::composeReply2("Teradi kesalahan, data tidak ditemukan");
        }

        return Helper::composeReply2("SUCCESS", "Data", $data);
    }


    public function kendaraanUpdate(Request $req){
        $id = $req->id;
        $jenis = $req->jenis;
        $noPol = $req->noPol;
        $tahun = $req->tahun;
        $kondisi = $req->kondisi;
        if( 
            !isset($id)||
            !isset($jenis)||
            !isset($noPol)||
            !isset($noPol)||
            !isset($kondisi)
        )   return Helper::composeReply2("ERROR", "Parameter tidak lengkap");

        DB::table("tu_umum_kendaraan")->where("KNDRN_ID", $id)->update([
            "KNDRN_JENIS" => $jenis,
            "KNDRN_NO_POLISI" => $noPol,
            "KNDRN_TAHUN" => $tahun,
            "KNDRN_KONDISI" => $kondisi
        ]);

        return Helper::composeReply2("SUCCESS", "Berhasil memperbarui data");
    }


    public function kendaraanUpdateCopy(Request $req){
        $periode = $req->periode;
        $lastPeriode = strtotime($periode.' -1 month');
        $lastPeriodeStr = date('Y-m', $lastPeriode);

        DB::beginTransaction();

        $data = DB::table("tu_umum_kendaraan")->where("KNDRN_PERIODE", $lastPeriodeStr)->get();
        if(count($data) > 0){
            DB::table("tu_umum_kendaraan")->where("KNDRN_PERIODE", $periode)->delete();
            foreach ($data as $aData) {
                try {
                    DB::table("tu_umum_kendaraan")->insertGetId([
                        "KNDRN_PERIODE" => $periode,
                        "KNDRN_JENIS" => $aData->KNDRN_JENIS,
                        "KNDRN_NO_POLISI" => $aData->KNDRN_NO_POLISI,
                        "KNDRN_TAHUN" => $aData->KNDRN_TAHUN,
                        "KNDRN_KONDISI" => $aData->KNDRN_KONDISI
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


    public function kendaraanDelete(Request $req){
        $id = $req->id;
        if(!isset($id)){
            return Helper::composeReply2("ERROR", "Parameter tidak lengkap");
        }

        DB::table("tu_umum_kendaraan")->where("KNDRN_ID", $id)->delete();

        return Helper::composeReply2("SUCCESS", "Data terhapus");
    }


    public function kendaraanMatch(Request $req){
        
    }


    //
    public function sarpras(Request $req){
        $periode = $req->periode;

        //
        $sarpras = DB::table("tu_umum_sarpras")->where("SARPRAS_PERIODE", $periode)->get();

        $data["ctl_periode"] = $periode;
        $data["ctl_data"] = $sarpras;

        return view("main.tu.umum.sarpras", $data);
    }


    public function sarprasSave(Request $req){
        $periode = $req->periode;
        $jenis = $req->jenis;
        $jumlah = $req->jumlah;
        $kondisi = $req->kondisi;
        $keterangan = ($req->keterangan != null) ? $req->keterangan : "-";
        if( 
            !isset($periode)||
            !isset($jenis)||
            !isset($jumlah)||
            !isset($kondisi)||
            !isset($keterangan)
        )   return Helper::composeReply2("ERROR", "Parameter tidak lengkap");

        DB::table("tu_umum_sarpras")->insertGetId([
            "SARPRAS_PERIODE" => $periode,
            "SARPRAS_JENIS" => $jenis,
            "SARPRAS_JUMLAH" => $jumlah,
            "SARPRAS_KONDISI" => $kondisi,
            "SARPRAS_KETERANGAN" => $keterangan
        ]);

        return Helper::composeReply2("SUCCESS", "Berhasil menyimpan data");
    }


    public function sarprasDetail(Request $req){
        $id = $req->id;
        if(!isset($id)){
            return Helper::composeReply2("ERROR", "Parameter tidak lengkap");
        }

        $data = DB::table("tu_umum_sarpras")->where("SARPRAS_ID", $id)->first();
        if(!isset($data)){
            return Helper::composeReply2("Teradi kesalahan, data tidak ditemukan");
        }

        return Helper::composeReply2("SUCCESS", "Data", $data);
    }


    public function sarprasUpdate(Request $req){
        $id = $req->id;
        $jenis = $req->jenis;
        $jumlah = $req->jumlah;
        $kondisi = $req->kondisi;
        $keterangan = ($req->keterangan != null) ? $req->keterangan : "-";
        if( 
            !isset($id)||
            !isset($jenis)||
            !isset($jumlah)||
            !isset($kondisi)||
            !isset($keterangan)
        )   return Helper::composeReply2("ERROR", "Parameter tidak lengkap");

        DB::table("tu_umum_sarpras")->where("SARPRAS_ID", $id)->update([
            "SARPRAS_JENIS" => $jenis,
            "SARPRAS_JUMLAH" => $jumlah,
            "SARPRAS_KONDISI" => $kondisi,
            "SARPRAS_KETERANGAN" => $keterangan
        ]);

        return Helper::composeReply2("SUCCESS", "Berhasil memperbarui data");
    }


    public function sarprasUpdateCopy(Request $req){
        $periode = $req->periode;
        $lastPeriode = strtotime($periode.' -1 month');
        $lastPeriodeStr = date('Y-m', $lastPeriode);

        DB::beginTransaction();

        $data = DB::table("tu_umum_sarpras")->where("SARPRAS_PERIODE", $lastPeriodeStr)->get();
        if(count($data) > 0){
            DB::table("tu_umum_sarpras")->where("SARPRAS_PERIODE", $periode)->delete();
            foreach ($data as $aData) {
                try {
                    DB::table("tu_umum_sarpras")->insertGetId([
                        "SARPRAS_PERIODE" => $periode,
                        "SARPRAS_JENIS" => $aData->SARPRAS_JENIS,
                        "SARPRAS_JUMLAH" => $aData->SARPRAS_JUMLAH,
                        "SARPRAS_KONDISI" => $aData->SARPRAS_KONDISI,
                        "SARPRAS_KETERANGAN" => $aData->SARPRAS_KETERANGAN
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


    public function sarprasDelete(Request $req){
        $id = $req->id;
        if(!isset($id)){
            return Helper::composeReply2("ERROR", "Parameter tidak lengkap");
        }

        DB::table("tu_umum_sarpras")->where("SARPRAS_ID", $id)->delete();

        return Helper::composeReply2("SUCCESS", "Data terhapus");
    }


    //
    public function bangunan(Request $req){
        $periode = $req->periode;

        //
        $bangunan = DB::table("tu_umum_bangunan")->where("BGNN_PERIODE", $periode)->get();

        $data["ctl_periode"] = $periode;
        $data["ctl_data"] = $bangunan;

        return view("main.tu.umum.bangunan", $data);
    }


    public function bangunanSave(Request $req){
        $periode = $req->periode;
        $objek = $req->objek;
        $kepemilikan = $req->kepemilikan;
        $keterangan = ($req->keterangan != null) ? $req->keterangan : "-";
        if( 
            !isset($periode)||
            !isset($objek)||
            !isset($kepemilikan)||
            !isset($keterangan)
        )   return Helper::composeReply2("ERROR", "Parameter tidak lengkap");

        DB::table("tu_umum_bangunan")->insertGetId([
            "BGNN_PERIODE" => $periode,
            "BGNN_OBJEK" => $objek,
            "BGNN_STATUS_KEPEMILIKAN" => $kepemilikan,
            "BGNN_KETERANGAN" => $keterangan
        ]);

        return Helper::composeReply2("SUCCESS", "Berhasil menyimpan data");
    }


    public function bangunanDetail(Request $req){
        $id = $req->id;
        if(!isset($id)){
            return Helper::composeReply2("ERROR", "Parameter tidak lengkap");
        }

        $data = DB::table("tu_umum_bangunan")->where("BGNN_ID", $id)->first();
        if(!isset($data)){
            return Helper::composeReply2("Teradi kesalahan, data tidak ditemukan");
        }

        return Helper::composeReply2("SUCCESS", "Data", $data);
    }


    public function bangunanUpdate(Request $req){
        $id = $req->id;
        $objek = $req->objek;
        $kepemilikan = $req->kepemilikan;
        $keterangan = ($req->keterangan != null) ? $req->keterangan : "-";
        if( 
            !isset($id)||
            !isset($objek)||
            !isset($kepemilikan)||
            !isset($keterangan)
        )   return Helper::composeReply2("ERROR", "Parameter tidak lengkap");

        DB::table("tu_umum_bangunan")->where("BGNN_ID", $id)->update([
            "BGNN_OBJEK" => $objek,
            "BGNN_STATUS_KEPEMILIKAN" => $kepemilikan,
            "BGNN_KETERANGAN" => $keterangan
        ]);

        return Helper::composeReply2("SUCCESS", "Berhasil memperbarui data");
    }


    public function bangunanUpdateCopy(Request $req){
        $periode = $req->periode;
        $lastPeriode = strtotime($periode.' -1 month');
        $lastPeriodeStr = date('Y-m', $lastPeriode);

        DB::beginTransaction();

        $data = DB::table("tu_umum_bangunan")->where("BGNN_PERIODE", $lastPeriodeStr)->get();
        if(count($data) > 0){
            DB::table("tu_umum_bangunan")->where("BGNN_PERIODE", $periode)->delete();
            foreach ($data as $aData) {
                try {
                    DB::table("tu_umum_bangunan")->insertGetId([
                        "BGNN_PERIODE" => $periode,
                        "BGNN_OBJEK" => $aData->BGNN_OBJEK,
                        "BGNN_STATUS_KEPEMILIKAN" => $aData->BGNN_STATUS_KEPEMILIKAN,
                        "BGNN_KETERANGAN" => $aData->BGNN_KETERANGAN
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


    public function bangunanDelete(Request $req){
        $id = $req->id;
        if(!isset($id)){
            return Helper::composeReply2("ERROR", "Parameter tidak lengkap");
        }

        DB::table("tu_umum_bangunan")->where("BGNN_ID", $id)->delete();

        return Helper::composeReply2("SUCCESS", "Data terhapus");
    }


}
