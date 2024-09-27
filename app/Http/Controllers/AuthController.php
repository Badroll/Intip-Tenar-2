<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller as mCtl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Model as M;
use Helper, DB, Session;

class AuthController
{

    protected $request;

    public function __construct(Request $request) {
    }

    public function login(){
    	$sessi = session('admin_session');
		if(!empty($sessi)) return redirect('main');
		$data['title'] = 'Login';
		$data['page']  = 'auth.login';
    	return view("auth.master", $data);
    }

    public function doLogin(Request $req){
    	$clientIp = $req->ip();
        Helper::addToLog($clientIp, "ACTLOG_LOGIN");

		$username = $req->username;
		$password = $req->password;
		$remember = $req->remember;

		if(!isset($username) || !isset($password)){
    		//Helper::addToLog($clientIp, "ACTLOG_LOGIN");
			return redirect()->back()->withInput()->with('error', "Harap periksa kembali data Anda");
		}

        $username = strtolower($username);
        
		$user = DB::table("_user as A")->where('U_USERNAME',$username)->first();
		if(empty($user)){
    		//Helper::addToLog($clientIp, "ACTLOG_LOGIN");
			return redirect()->back()->withInput()->with('error', "Account belum terdaftar");
		} 
		else {
			if($user->U_STATUS == 'USER_INACTIVE'){
				//Helper::addToLog($clientIp, "ACTLOG_LOGIN");
				return redirect()->back()->withInput()->with('error', "Account belum aktif");
			} 
			else {
				if (Hash::check($username . $password, $user->U_PASSWORD)) {

					Session::put('admin_session', $user);

                    //Helper::addToLog($clientIp, "ACTLOG_LOGIN");
				    return redirect('main/home?periode='.date("Y-m", strtotime("-1 months")))->with('info', 'Selamat Datang '.$user->U_FULLNAME);
				} 
				else {
					//Helper::addToLog($clientIp, "ACTLOG_LOGIN");
					return redirect()->back()->withInput()->with('error', "Harap periksa kembali data Anda");
				}
			}
		}
    }


    public function doRegister(Request $req){
    	$username = $req->username;
        $password = $req->password;
    	$fullname = $req->fullname;
    	$role = $req->role;
    	$status = $req->status;

        $minLength = strlen($password) >= 8;
        $hasUpperCase = preg_match('/[A-Z]/', $password);
        $hasLowerCase = preg_match('/[a-z]/', $password);
        $hasNumber = preg_match('/[0-9]/', $password);
        $hasSpecialChar = preg_match('/[!@#$%^&*(),.?":{}|<>_\-]/', $password);
        $errors = [];
        if (!$minLength) $errors[] = "minimal 8 karakter.";
        if (!$hasUpperCase) $errors[] = "harus mengandung huruf besar.";
        if (!$hasLowerCase) $errors[] = "harus mengandung huruf kecil.";
        if (!$hasNumber) $errors[] = "harus mengandung angka.";
        if (!$hasSpecialChar) $errors[] = "harus mengandung karakter khusus.";
        if (!empty($errors)) {
            return Helper::composeReply2("ERROR", "Registrasi gagal, ". implode(", ",$errors));
        }

    	if(!isset($username) || !isset($password) || !isset($fullname) || !isset($role) || !isset($status)){
    		return Helper::composeReply2("ERROR", "Parameter tidak lengkap");
    	}

        $username = strtolower($username);
    	$check = DB::table("_user")->where("U_USERNAME", $username)->first();
    	if(isset($check)){
    		return Helper::composeReply2("ERROR", "Maaf, username \"" . $username . "\" sudah digunakan");
    	}

    	//$password = Helper::getSetting("DEFAULT_PASSWORD");
    	$passwordHash = Hash::make($username . $password, [
		    'rounds' => 12
		]);
    	$img = "logo-user-1.png";

    	try {
    		DB::table("_user")->insertGetId([
    			"U_USERNAME" => $username,
    			"U_PASSWORD" => $passwordHash,
    			"U_FULLNAME" => $fullname,
    			"U_ROLE" => $role,
    			"U_STATUS" => $status,
    			"U_IMG_PATH" => $img
    		]);
    	} catch (Exception $e) {
    		return Helper::composeReply2("ERROR", "Maaf, terjadi kesalahan internal");
    	}
    	return Helper::composeReply2("SUCCESS", "Berhasil menambahkan user baru");
    }


    public function userInfo(Request $req){
        $id = $req->id;
        if(!isset($id)){
            return Helper::composeReply2("ERROR", "Parameter tidak lengkap");
        }
        $data = DB::table("_user")->where("U_USERNAME", $id)->first();
        if(!isset($data)){
            return Helper::composeReply2("ERROR", "User tidak ditemukan");
        }
        return Helper::composeReply2("SUCCESS", "User info", $data);
    }


    public function doReset(Request $req){
        $id = $req->id;
        $username = $req->username;
        $password = $req->password;
        $fullname = $req->fullname;
        // $role = $req->role;
        $status = $req->status;

        $minLength = strlen($password) >= 8;
        $hasUpperCase = preg_match('/[A-Z]/', $password);
        $hasLowerCase = preg_match('/[a-z]/', $password);
        $hasNumber = preg_match('/[0-9]/', $password);
        $hasSpecialChar = preg_match('/[!@#$%^&*(),.?":{}|<>_\-]/', $password);
        $errors = [];
        if (!$minLength) $errors[] = "minimal 8 karakter.";
        if (!$hasUpperCase) $errors[] = "harus mengandung huruf besar.";
        if (!$hasLowerCase) $errors[] = "harus mengandung huruf kecil.";
        if (!$hasNumber) $errors[] = "harus mengandung angka.";
        if (!$hasSpecialChar) $errors[] = "harus mengandung karakter khusus.";
        if (!empty($errors)) {
            return Helper::composeReply2("ERROR", "Update gagal, ". implode(", ",$errors));
        }

        if(!isset($id) || !isset($username) || !isset($password) || !isset($fullname) /*|| !isset($role)*/ || !isset($status)){
            return Helper::composeReply2("ERROR", "Parameter tidak lengkap");
        }

        $username = strtolower($username);
        $lastData = DB::table("_user")->where("U_USERNAME", $id)->first();
        if(!isset($lastData)){
            return Helper::composeReply2("ERROR", "User tidak ditemukan");
        }

        $check = DB::table("_user")->where("U_USERNAME", "!=", $id)->where("U_USERNAME", $username)->first();
        if(isset($check)){
            return Helper::composeReply2("ERROR", "Maaf, username \"" . $username . "\" sudah digunakan");
        }

        $passwordHash = Hash::make($username . $password, [
            'rounds' => 12
        ]);
        $img = "logo-user-1.png";

        try {
            DB::table("_user")->where("U_USERNAME", $id)->update([
                "U_USERNAME" => $username,
                "U_PASSWORD" => $passwordHash,
                "U_FULLNAME" => $fullname,
                /*"U_ROLE" => $role,*/
                "U_STATUS" => $status,
                "U_IMG_PATH" => $img
            ]);
        } catch (Exception $e) {
            return Helper::composeReply2("ERROR", "Maaf, terjadi kesalahan internal");
        }
        return Helper::composeReply2("SUCCESS", "Berhasil memperbarui user");
    }


    public function doDelete(Request $req){
        $id = $req->id;
        if(!isset($id)){
            return Helper::composeReply2("ERROR", "Parameter tidak lengkap");
        }
        $data = DB::table("_user")->where("U_USERNAME", $id)->delete();
        return Helper::composeReply2("SUCCESS", "User terhapus", $data);
    }


    public function doLogout(){
		Session::forget('admin_session');
		return redirect('auth')->with('message','Anda telah keluar dari sistem.');
    }
}
