<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Request;

use App\Model as M;
use Carbon\Carbon;
use DB;


class Helper {

	public static function base_url() 
	{
	    $appPath = (env("APP_ENV") == "local" ? "/intip-tenar" : "");
	    $cleanUrl = env('PROTOCOL') == 'https' ? secure_url('/') : url('/');
	    $cleanUrl = str_replace($appPath, "", $cleanUrl);

	    return $cleanUrl.$appPath;
	}

	public static function getString(){
		return "STRING FROM HELPER";
	}

	public static function uri1(){
		return Request::segment(1);
	}

	public static function uri2(){
		return Request::segment(2);
	}

	public static function uri3(){
		return Request::segment(3);
	}

	public static function uri4(){
		return Request::segment(4);
	}

	public static function allUri($n, $start = 2){
		$uri = "";
		for ($i = $start; $i <= $n; $i++){
			$uri .= Request::segment($i);
			if($i != $n){
				$uri .= "/";
			}
		}
		return $uri;
	}

	public static function composeReply($status,$msg,$payload = null) {
		header("Content-Type: application/json");
		$reply = json_encode(array(
			"SENDER" => "Intip Tenar",
			"STATUS" => $status,
			"MESSAGE" => $msg,
			"PAYLOAD" => $payload));

		return $reply;
	}

	public static function composeReply2($status,$msg,$payload = null) { //LARAVEL WAY
		$reply = json_encode(array(
			"SENDER" => "Intip Tenar",
			"STATUS" => $status,
			"MESSAGE" => $msg,
			"PAYLOAD" => $payload));

		return Response::make($reply, '200')->header('Content-Type', 'application/json');
	}

	public static function composeReplyByStatusCode($status,$msg,$payload = null) { //LARAVEL WAY
	    $statusText = $status;    
	    if($status == "401")    $statusText = "UNAUTHORIZED";

	    $reply = json_encode(array(
	        "SENDER" => "Imigrasi Semarang",
	        "STATUS" => $statusText,
	        "MESSAGE" => $msg,
	        "PAYLOAD" => $payload
	    ));

	    return Response::make($reply, $status)->header('Content-Type', 'application/json');
	}

	public static function base64_e( $q ) {
		$key = "!QAZ2wsx#EDC";
	    $qEncoded = md5(base64_encode($key . $q));
	    return $qEncoded;
	}

	public static function base64_d( $q ) {
		$key = "!QAZ2wsx#EDC";
	    $qDecoded  = base64_decode($q) ;
	    return str_replace($key, "", $qDecoded);
	}

	public static function sha256_e( $q ) {
	    $qEncoded  = base64_encode($q) ;
	    return $qEncoded;
	}

	public static function sha256_d( $q ) {
	    $qDecoded  = base64_decode($q) ;
	    return $qDecoded;
	}


	public static function isJSON($string){
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	}

	public static function tanggal($tgl,$mode = "LONG") {
		if($tgl != "" && $mode != "" && $tgl!= "0000-00-00" && $tgl != "0000-00-00 00:00:00") {
			$t = explode("-",$tgl);
			$bln = array();
			$bln["01"]["LONG"] = "Januari";
			$bln["01"]["SHORT"] = "Jan";
			$bln["1"]["LONG"] = "Januari";
			$bln["1"]["SHORT"] = "Jan";
			$bln["02"]["LONG"] = "Februari";
			$bln["02"]["SHORT"] = "Feb";
			$bln["2"]["LONG"] = "Februari";
			$bln["2"]["SHORT"] = "Feb";
			$bln["03"]["LONG"] = "Maret";
			$bln["03"]["SHORT"] = "Mar";
			$bln["3"]["LONG"] = "Maret";
			$bln["3"]["SHORT"] = "Mar";
			$bln["04"]["LONG"] = "April";
			$bln["04"]["SHORT"] = "Apr";
			$bln["4"]["LONG"] = "April";
			$bln["4"]["SHORT"] = "Apr";
			$bln["05"]["LONG"] = "Mei";
			$bln["05"]["SHORT"] = "Mei";
			$bln["5"]["LONG"] = "Mei";
			$bln["5"]["SHORT"] = "Mei";
			$bln["06"]["LONG"] = "Juni";
			$bln["06"]["SHORT"] = "Jun";
			$bln["6"]["LONG"] = "Juni";
			$bln["6"]["SHORT"] = "Jun";
			$bln["07"]["LONG"] = "Juli";
			$bln["07"]["SHORT"] = "Jul";
			$bln["7"]["LONG"] = "Juli";
			$bln["7"]["SHORT"] = "Jul";
			$bln["08"]["LONG"] = "Agustus";
			$bln["08"]["SHORT"] = "Ags";
			$bln["8"]["LONG"] = "Agustus";
			$bln["8"]["SHORT"] = "Ags";
			$bln["09"]["LONG"] = "September";
			$bln["09"]["SHORT"] = "Sep";
			$bln["9"]["LONG"] = "September";
			$bln["9"]["SHORT"] = "Sep";
			$bln["10"]["LONG"] = "Oktober";
			$bln["10"]["SHORT"] = "Okt";
			$bln["11"]["LONG"] = "November";
			$bln["11"]["SHORT"] = "Nov";
			$bln["12"]["LONG"] = "Desember";
			$bln["12"]["SHORT"] = "Des";

		  	$b = $t[1];

		  	if (strpos($t[2], ":") === false) { //tdk ada format waktu
				$jam = "";
			}
		  	else {
				$j = explode(" ",$t[2]);
				$t[2] = $j[0];
				$jam = $j[1];
		  	}

		  	return $t[2]." ".$bln[$b][$mode]." ".$t[0]." ".$jam;
		}
		else {
		  	return "-";
		}
	}

	public static function bulan($tgl,$mode = "LONG") {
		if($tgl == "" || $mode == "" || $tgl == "0000-00"){
			return "-";
		}
		$t = explode("-", $tgl);
		$bln["01"]["LONG"] = "Januari";
		$bln["01"]["SHORT"] = "Jan";
		$bln["1"]["LONG"] = "Januari";
		$bln["1"]["SHORT"] = "Jan";
		$bln["02"]["LONG"] = "Februari";
		$bln["02"]["SHORT"] = "Feb";
		$bln["2"]["LONG"] = "Februari";
		$bln["2"]["SHORT"] = "Feb";
		$bln["03"]["LONG"] = "Maret";
		$bln["03"]["SHORT"] = "Mar";
		$bln["3"]["LONG"] = "Maret";
		$bln["3"]["SHORT"] = "Mar";
		$bln["04"]["LONG"] = "April";
		$bln["04"]["SHORT"] = "Apr";
		$bln["4"]["LONG"] = "April";
		$bln["4"]["SHORT"] = "Apr";
		$bln["05"]["LONG"] = "Mei";
		$bln["05"]["SHORT"] = "Mei";
		$bln["5"]["LONG"] = "Mei";
		$bln["5"]["SHORT"] = "Mei";
		$bln["06"]["LONG"] = "Juni";
		$bln["06"]["SHORT"] = "Jun";
		$bln["6"]["LONG"] = "Juni";
		$bln["6"]["SHORT"] = "Jun";
		$bln["07"]["LONG"] = "Juli";
		$bln["07"]["SHORT"] = "Jul";
		$bln["7"]["LONG"] = "Juli";
		$bln["7"]["SHORT"] = "Jul";
		$bln["08"]["LONG"] = "Agustus";
		$bln["08"]["SHORT"] = "Ags";
		$bln["8"]["LONG"] = "Agustus";
		$bln["8"]["SHORT"] = "Ags";
		$bln["09"]["LONG"] = "September";
		$bln["09"]["SHORT"] = "Sep";
		$bln["9"]["LONG"] = "September";
		$bln["9"]["SHORT"] = "Sep";
		$bln["10"]["LONG"] = "Oktober";
		$bln["10"]["SHORT"] = "Okt";
		$bln["11"]["LONG"] = "November";
		$bln["11"]["SHORT"] = "Nov";
		$bln["12"]["LONG"] = "Desember";
		$bln["12"]["SHORT"] = "Des";

		return $bln[$t[1]][$mode] . " " . $t[0];
	}

	public static function randomDigits($length){
		$digits = "";
		$numbers = range(0,9);
		shuffle($numbers);
		for($i = 0;$i < $length;$i++) {
		  $digits .= $numbers[$i];
		}
		return $digits;
	}

	public static function createCode($codeLength) {
		$kode = strtoupper(substr(md5(Helper::randomDigits($codeLength)), 0,($codeLength-1) ));

		return $kode;
	}

	public static function getSetting($setId)  {
		$setValue = "";
		$setting = DB::select("SELECT SET_VALUE FROM _setting WHERE SET_ID = ? LIMIT 0,1",array($setId));
		if(count($setting) > 0) {
		  $rs_setting = $setting[0];
		  $setValue = $rs_setting->{"SET_VALUE"};
		}

		return $setValue;
	}

	public static function getReferenceInfo($refKtgId, $refValueId) {
		$ref = DB::table("_reference")
			->where("R_CATEGORY",$refKtgId)
			->where("R_ID",$refValueId)
			->first();

		if(isset($ref) > 0) {
			return $ref->{"R_INFO"};
		}
	  	else {
	  		return "";
	  	}
	}

	public static function getReference($refKtgId) {
		$ref = DB::table("_reference")
			->where("R_CATEGORY",$refKtgId)
			->orderBy("R_ORDER", "ASC")
			->get();

		if(isset($ref) || $ref > 0) {
			return $ref;
		}
	  	else {
	  		return [];
	  	}
	}


	public static function addToLog($ip, $action, $note = "-"){
		DB::table("_activity_log")->insert([
			"ACT_DATE" => date("Y-m-d H:i:s"),
			"ACT_CLIENT_IP" => $ip,
			"ACT_ACTION" => $action,
			"ACT_NOTE" => $note
		]);
	}

	public static function getLog($ip, $action){
		$log = DB::table("_activity_log")
			->where("ACT_CLIENT_IP", $ip)->where("ACT_ACTION", $action)
			->orderBy("ACT_DATE", "DESC")
			->first();
		return $log;
	}


	public static function validateDate($date, $format = 'Y-m-d H:i:s'){
	    $d = DateTime::createFromFormat($format, $date);
	    return strval($d && $d->format($format) == $date);
	}


	public static function validateDate2($date, $param2 = ''){
		try{
			$arr = explode("-", trim($date));
		    if(strlen($arr[0]) > 4 || !is_numeric($arr[0])){
		    	return false;
		    }
		    $mnth = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
		    if(!in_array($arr[1], $mnth)){
		    	return false;
		    }
		    return true;
		}catch(Exception $e){
			return false;
		}
	}
	

	public static function validateNegara($country){
	    $data = DB::table("negara")->where("NGR_KODE", $country)->first();
	    if(!isset($data))	return false;
	    return true;
	}

}
