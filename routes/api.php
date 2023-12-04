<?php

use App\Http\Controllers\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

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
    Route::post('/', function(){
        return Response::json([
            "status" => "you are successfull"
        ]);
    })->name('');

    Route::prefix('mahasiswa')->group(function () {
        Route::post('signup', [
            Mahasiswa::class, 'signup'
        ])->name('api_mahasiswa_login');
    });
});