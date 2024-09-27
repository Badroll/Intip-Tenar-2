<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\GrafikController;
use App\Http\Controllers\TU\BelanjaController;
use App\Http\Controllers\TU\IKPAController;
use App\Http\Controllers\TU\KepegawaianController;
use App\Http\Controllers\TU\UmumController;

use App\Http\Middleware\Authlogin;
use App\Http\Middleware\ValidatePeriode;
use App\Http\Middleware\ValidateYear;
use App\Http\Middleware\VerifyAdministrator;
use App\Http\Middleware\ValidateRequestInput;


Route::get('/', function () {
    return redirect('auth');
});

Route::get('tes', function () {
    if (Helper::validateDate2('2021-12')) {
        return 'Yes';
    } else {
        return 'No';
    }
})->middleware('throttle:1,1');

Route::get('tes2', [MainController::class, 'tes'])->middleware(ValidateRequestInput::class);

Route::get('parsejson', [MainController::class, 'parseJSON']);

//
Route::middleware(ValidateRequestInput::class)->group(function(){

    Route::get('public-view', [MainController::class, 'publicView'])->middleware(ValidatePeriode::class);

    Route::prefix('auth')->group(function () {
        Route::get('/', function () {
            return redirect('auth/login');
        });
        Route::get('login', [AuthController::class, 'login']);
        Route::post('login', [AuthController::class, 'doLogin'])->middleware('throttle:1,1');
        Route::get('logout', [AuthController::class, 'doLogout']);
    });

    Route::prefix('main')->middleware(Authlogin::class)->group(function () {

        Route::get('/', function () {
            return redirect('main/home?periode=' . date('Y-m', strtotime('-1 months')));
        });
        Route::get('home', [MainController::class, 'home'])->middleware(ValidatePeriode::class);

        Route::prefix('pldp')->group(function () {
            Route::get('/', [MainController::class, 'pldp'])->middleware(ValidatePeriode::class);
            Route::post('update', [MainController::class, 'pldpUpdate']);
        });

        Route::prefix('pldp_')->group(function () {
            Route::get('/', [MainController::class, 'pldp_'])->middleware(ValidatePeriode::class);
            Route::post('update', [MainController::class, 'pldp_Update']);
        });

        Route::prefix('tupoksi')->group(function () {
            Route::get('/', [MainController::class, 'tupoksi'])->middleware(ValidatePeriode::class);
            Route::post('update', [MainController::class, 'tupoksiUpdate'])->middleware(VerifyAdministrator::class);
        });

        Route::prefix('tu')->group(function () {
            Route::prefix('belanja')->group(function () {
                Route::prefix('realisasi-belanja')->group(function () {
                    Route::get('/', [BelanjaController::class, 'realisasiBelanja'])->middleware(ValidatePeriode::class);
                    Route::post('update', [BelanjaController::class, 'realisasiBelanjaUpdate'])->middleware(VerifyAdministrator::class);
                });
                Route::prefix('realisasi-pendapatan')->group(function () {
                    Route::get('/', [BelanjaController::class, 'realisasiPendapatan'])->middleware(ValidatePeriode::class);
                    Route::post('update', [BelanjaController::class, 'realisasiPendapatanUpdate'])->middleware(VerifyAdministrator::class);
                });
                // Route::prefix('rm-pnbp')->group(function () {
                //     Route::get('/', [BelanjaController::class, 'rmpnbp'])->middleware(ValidatePeriode::class);
                //     Route::post('update', [BelanjaController::class, 'rmpnbpUpdate']);
                // });
            });
            Route::prefix('ikpa')->group(function () {
                Route::get('/', [IKPAController::class, 'ikpa'])->middleware(ValidatePeriode::class);
                Route::post('update', [IKPAController::class, 'ikpaUpdate'])->middleware(VerifyAdministrator::class);
            });
            Route::prefix('kepegawaian')->group(function () {
                Route::prefix('bezetting')->group(function () {
                    Route::get('/', [KepegawaianController::class, 'bezetting'])->middleware(ValidatePeriode::class);
                    Route::post('save', [KepegawaianController::class, 'bezettingSave'])->middleware(VerifyAdministrator::class);
                    Route::get('detail', [KepegawaianController::class, 'bezettingDetail']);
                    Route::post('update', [KepegawaianController::class, 'bezettingUpdate'])->middleware(VerifyAdministrator::class);
                    Route::post('update-copy', [KepegawaianController::class, 'bezettingUpdateCopy'])->middleware(VerifyAdministrator::class);
                    Route::post('delete', [KepegawaianController::class, 'bezettingDelete'])->middleware(VerifyAdministrator::class);
                });
                Route::prefix('rekap')->group(function () {
                    Route::get('/', [KepegawaianController::class, 'rekap'])->middleware(ValidatePeriode::class);
                    Route::post('update', [KepegawaianController::class, 'rekapUpdate'])->middleware(VerifyAdministrator::class);
                    Route::post('update-copy', [KepegawaianController::class, 'rekapUpdateCopy'])->middleware(VerifyAdministrator::class);
                });
                Route::prefix('cuti')->group(function () {
                    Route::get('/', [KepegawaianController::class, 'cuti'])->middleware(ValidatePeriode::class);
                    Route::post('update', [KepegawaianController::class, 'cutiUpdate'])->middleware(VerifyAdministrator::class);
                });
                Route::prefix('pembinaan')->group(function () {
                    Route::get('/', [KepegawaianController::class, 'pembinaan'])->middleware(ValidatePeriode::class);
                    Route::post('save', [KepegawaianController::class, 'pembinaanSave'])->middleware(VerifyAdministrator::class);
                    Route::get('detail', [KepegawaianController::class, 'pembinaanDetail']);
                    Route::post('update', [KepegawaianController::class, 'pembinaanUpdate'])->middleware(VerifyAdministrator::class);
                    Route::post('delete', [KepegawaianController::class, 'pembinaanDelete'])->middleware(VerifyAdministrator::class);
                });
            });
            Route::prefix('umum')->group(function () {
                Route::prefix('persuratan')->group(function () {
                    Route::get('/', [UmumController::class, 'persuratan'])->middleware(ValidatePeriode::class);
                    Route::post('update', [UmumController::class, 'persuratanUpdate']);
                });
                Route::prefix('kendaraan')->group(function () {
                    Route::get('/', [UmumController::class, 'kendaraan'])->middleware(ValidatePeriode::class);
                    Route::post('save', [UmumController::class, 'kendaraanSave'])->middleware(VerifyAdministrator::class);
                    Route::get('detail', [UmumController::class, 'kendaraanDetail']);
                    Route::post('update', [UmumController::class, 'kendaraanUpdate'])->middleware(VerifyAdministrator::class);
                    Route::post('update-copy', [UmumController::class, 'kendaraanUpdateCopy'])->middleware(VerifyAdministrator::class);
                    Route::post('delete', [UmumController::class, 'kendaraanDelete'])->middleware(VerifyAdministrator::class);
                });
                Route::prefix('sarpras')->group(function () {
                    Route::get('/', [UmumController::class, 'sarpras'])->middleware(ValidatePeriode::class);
                    Route::post('save', [UmumController::class, 'sarprasSave'])->middleware(VerifyAdministrator::class);
                    Route::get('detail', [UmumController::class, 'sarprasDetail']);
                    Route::post('update', [UmumController::class, 'sarprasUpdate'])->middleware(VerifyAdministrator::class);
                    Route::post('update-copy', [UmumController::class, 'sarprasUpdateCopy'])->middleware(VerifyAdministrator::class);
                    Route::post('delete', [UmumController::class, 'sarprasDelete'])->middleware(VerifyAdministrator::class);
                });
                Route::prefix('bangunan')->group(function () {
                    Route::get('/', [UmumController::class, 'bangunan'])->middleware(ValidatePeriode::class);
                    Route::post('save', [UmumController::class, 'bangunanSave'])->middleware(VerifyAdministrator::class);
                    Route::get('detail', [UmumController::class, 'bangunanDetail']);
                    Route::post('update', [UmumController::class, 'bangunanUpdate'])->middleware(VerifyAdministrator::class);
                    Route::post('update-copy', [UmumController::class, 'bangunanUpdateCopy'])->middleware(VerifyAdministrator::class);
                    Route::post('delete', [UmumController::class, 'bangunanDelete'])->middleware(VerifyAdministrator::class);
                });
            });
        });

        Route::prefix('user')->middleware(VerifyAdministrator::class)->group(function () {
            Route::get('/', [AdministratorController::class, 'user']);
            Route::post('save', [AdministratorController::class, 'userSave']);
            Route::get('detail', [AdministratorController::class, 'userDetail']);
            Route::post('update', [AdministratorController::class, 'userUpdate']);
            Route::post('delete', [AdministratorController::class, 'userDelete']);
        });

        Route::prefix('grafik')->group(function () {
            Route::get('pldp', [GrafikController::class, 'pldp'])->middleware(ValidatePeriode::class);
            Route::get('pldp_', [GrafikController::class, 'pldp_'])->middleware(ValidatePeriode::class);
            Route::get('tupoksi', [GrafikController::class, 'tupoksi'])->middleware(ValidatePeriode::class);
            Route::prefix('tu')->group(function () {
                Route::prefix('belanja')->group(function () {
                    Route::get('realisasi-belanja', [GrafikController::class, 'tuBelanjaRealisasiBelanja'])->middleware(ValidatePeriode::class);
                    Route::get('realisasi-pendapatan', [GrafikController::class, 'tuBelanjaRealisasiPendapatan'])->middleware(ValidatePeriode::class);
                    // Route::get('rm-pnbp', [GrafikController::class, 'tuBelanjaRMPNBP'])->middleware(ValidatePeriode::class);
                });
                Route::get('ikpa', [GrafikController::class, 'tuIKPA'])->middleware(ValidateYear::class);
                Route::prefix('kepegawaian')->group(function () {
                    Route::get('bezetting', [GrafikController::class, 'tuKepegawaianBezetting'])->middleware(ValidatePeriode::class);
                    Route::get('rekap', [GrafikController::class, 'tuKepegawaianRekap'])->middleware(ValidatePeriode::class);
                    Route::get('cuti', [GrafikController::class, 'tuKepegawaianCuti'])->middleware(ValidatePeriode::class);
                    Route::get('pembinaan', [GrafikController::class, 'tuKepegawaianPembinaan'])->middleware(ValidatePeriode::class);
                });
                Route::prefix('umum')->group(function () {
                    Route::get('persuratan', [GrafikController::class, 'tuUmumPersuratan'])->middleware(ValidatePeriode::class);
                    Route::get('kendaraan', [GrafikController::class, 'tuUmumKendaraan'])->middleware(ValidatePeriode::class);
                    Route::get('sarpras', [GrafikController::class, 'tuUmumSarpras'])->middleware(ValidatePeriode::class);
                    Route::get('bangunan', [GrafikController::class, 'tuUmumBangunan'])->middleware(ValidatePeriode::class);
                });
            });
        });

    });

});



