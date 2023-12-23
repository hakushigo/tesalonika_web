<?php

use App\Http\Controllers\BAAKCtrl;
use App\Http\Controllers\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\RequestRuanganController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SuratIKController;
use App\Http\Controllers\IzinBermalamController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(App\Http\Middleware\CheckAPIKey::class)->group(function () {
    Route::post('/', function () {
        return Response::json([
            "status" => "you are successfull"
        ]);
    })->name('');

    Route::prefix('mahasiswa')->group(function () {
        Route::post('signup', [
            Mahasiswa::class, 'signup'
        ]);
        Route::post('login', [
            Mahasiswa::class, 'login'
        ]);
        Route::get('get_info', [
            Mahasiswa::class,'getInfo'
        ]);
    });

    Route::prefix('baak')->group(function () {
        Route::post('login', [
            BAAKCtrl::class, 'login'
        ]);
        Route::get('get_info', [
            BAAKCtrl::class,'getInfo'
        ]);
    });


    Route::prefix('ruangan')->group(function () {
        Route::get('/get', [RuanganController::class, 'index'])->name('api_ruangan_index');
        Route::post('/post', [RuanganController::class, 'store'])->name('api_ruangan_store');
        Route::delete('/delete/{id}', [RuanganController::class, 'delete'])->name('api_ruangan_delete');
        Route::put('/put/{id}', [RuanganController::class, 'update'])->name('api_ruangan_update');
    });

    Route::prefix('request-ruangan')->group(function () {
        Route::post('/post', [RequestRuanganController::class, 'store'])->name('api_request_ruangan_store');
        Route::get('/get', [RequestRuanganController::class, 'index'])->name('api_request_ruangan_index');
        Route::put('/put/{id}', [RequestRuanganController::class, 'update'])->name('api_request_ruangan_update');
        Route::put('/approve', [RequestRuanganController::class, 'approve'])->name('api_request_ruangan_approve');
        Route::delete('/delete/', [RequestRuanganController::class, 'destroy'])->name('api_request_ruangan_destroy');
    });

    // Route::prefix('surat')->group(function () {
    //     Route::get('/get', [RequestSurat::class, 'index'])->name('surat.index');
    //     Route::post('/post', [RequestSurat::class, 'store'])->name('surat.store');
    //     Route::put('/put/{id}', [RequestSurat::class, 'update'])->name('surat.update');
    //     Route::delete('/delete/{id}', [RequestSurat::class, 'destroy'])->name('surat.destroy');
    //     Route::put('/put/approve/{id}', [RequestSurat::class, 'approve'])->name('surat.approve');
    // });

    Route::prefix('ik')->group(function () {
        Route::get('/get', [SuratIKController::class, 'index'])->name('surat-ik.index');
        Route::post('/post', [SuratIKController::class, 'store'])->name('surat-ik.store');
        Route::put('/put/{id}', [SuratIKController::class, 'update'])->name('surat-ik.update');
        Route::put('/approve/', [SuratIKController::class, 'approve'])->name('surat-ik.approve');
        Route::delete('/delete/', [SuratIKController::class, 'destroy'])->name('surat-ik.destroy');
    });

    Route::prefix('ib')->group(function () {
        Route::get('/get', [IzinBermalamController::class, 'index'])->name('izin-bermalam.index'); // /
        Route::post('/post', [IzinBermalamController::class, 'store'])->name('izin-bermalam.store'); // /add
        Route::get('/get/{id}', [IzinBermalamController::class, 'show'])->name('izin-bermalam.show'); // /get/{id}
        Route::put('/put/update/{id}', [IzinBermalamController::class, 'update'])->name('izin-bermalam.update'); // /update/{id}
        Route::put('/approve/', [IzinBermalamController::class, 'approve'])->name('izin-bermalam.approve'); // /approve/{id}
        Route::delete('/delete/', [IzinBermalamController::class, 'destroy'])->name('izin-bermalam.destroy'); // /delete/{id}
    });
    

});
