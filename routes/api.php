<?php

use App\Http\Controllers\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\RequestRuanganController;
use App\Http\Controllers\RequestSuratController;
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
        ])->name('api_mahasiswa_login');
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
        Route::put('/put/{id}/approve', [RequestRuanganController::class, 'approve'])->name('api_request_ruangan_approve');
    });

    Route::prefix('surat')->group(function () {
        Route::get('/get', [RequestSuratController::class, 'index'])->name('surat.index');
        Route::post('/post', [RequestSuratController::class, 'store'])->name('surat.store');
        Route::put('/put/{id}', [RequestSuratController::class, 'update'])->name('surat.update');
        Route::delete('/delete/{id}', [RequestSuratController::class, 'destroy'])->name('surat.destroy');
        Route::put('/put/approve/{id}', [RequestSuratController::class, 'approve'])->name('surat.approve');
    });

    Route::prefix('surat-ik')->group(function () {
        Route::get('/get', [SuratIKController::class, 'index'])->name('surat-ik.index');
        Route::post('/post', [SuratIKController::class, 'store'])->name('surat-ik.store');
        Route::put('/put/{id}', [SuratIKController::class, 'update'])->name('surat-ik.update');
        Route::put('/put/approve/{id}', [SuratIKController::class, 'approve'])->name('surat-ik.approve');
        Route::delete('/delete/{id}', [SuratIKController::class, 'destroy'])->name('surat-ik.destroy');
    });

    Route::prefix('izin-bermalam')->group(function () {
        Route::get('/get', [IzinBermalamController::class, 'index'])->name('izin-bermalam.index'); // /
        Route::post('/add', [IzinBermalamController::class, 'store'])->name('izin-bermalam.store'); // /add
        Route::get('/get/{id}', [IzinBermalamController::class, 'show'])->name('izin-bermalam.show'); // /get/{id}
        Route::put('/put/update/{id}', [IzinBermalamController::class, 'update'])->name('izin-bermalam.update'); // /update/{id}
        Route::put('/put/approve/{id}', [IzinBermalamController::class, 'approve'])->name('izin-bermalam.approve'); // /approve/{id}
        Route::delete('/delete/{id}', [IzinBermalamController::class, 'destroy'])->name('izin-bermalam.destroy'); // /delete/{id}
    });
    

});
