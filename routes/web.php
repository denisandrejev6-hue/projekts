<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JaunumiController;
use App\Http\Controllers\KategorijuController;
use App\Http\Controllers\LietotajuApstiprinasanasController;
use App\Http\Controllers\LietotajuController;
use App\Http\Controllers\PasakumuController;
use App\Http\Controllers\RezervesKopijuController;
use App\Http\Controllers\TelpasController;


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    $jaunumi = \App\Models\Jaunumi::orderBy('publicets_datums', 'desc')->take(3)->get();
    $pasakumi = \App\Models\Pasakumi::with('images')->orderBy('ID', 'desc')->take(3)->get();
    return view('Home', ['jaunumi' => $jaunumi, 'pasakumi' => $pasakumi]);
})->middleware('auth');

Route::resource('pasakumi', PasakumuController::class)->middleware(['auth', 'role:Admin,Darbinieks,Lietotajs']);
Route::delete('pasakumi/{pasakumi}/images/{image}', [PasakumuController::class, 'deleteImage'])
    ->middleware(['auth', 'role:Admin,Darbinieks'])
    ->name('pasakumi.deleteImage');

Route::post('pasakumi/{id}/pieteikties', [PasakumuController::class, 'pieteikties'])
    ->middleware(['auth', 'role:Admin,Darbinieks,Lietotajs'])
    ->name('pasakumi.pieteikties');  

Route::post('pasakumi/{id}/atsauksme', [PasakumuController::class, 'saglabatAtsauksmi'])
    ->middleware(['auth', 'role:Admin,Darbinieks,Lietotajs'])
    ->name('pasakumi.atsauksme');

Route::post('pasakumi/{pasakumsId}/apmeklets/{lietotajsId}', [PasakumuController::class, 'atzimetApmekletu'])
    ->middleware(['auth', 'role:Admin,Darbinieks'])
    ->name('pasakumi.apmeklets');

Route::post('lietotaji/{id}/apstiprinat', [LietotajuApstiprinasanasController::class, 'apstiprinat'])
    ->middleware(['auth', 'role:Admin,Darbinieks'])
    ->name('lietotaji.apstiprinat');

Route::post('lietotaji/{id}/noraidit', [LietotajuApstiprinasanasController::class, 'noraidit'])
    ->middleware(['auth', 'role:Admin,Darbinieks'])
    ->name('lietotaji.noraidit');

Route::resource('telpas', TelpasController::class)->middleware(['auth', 'role:Admin,Darbinieks,Lietotajs']);
Route::resource('lietotaji', LietotajuController::class)->middleware(['auth', 'role:Admin,Darbinieks']);
Route::resource('rezerveskopijas', RezervesKopijuController::class)->middleware(['auth', 'role:Admin,Darbinieks']);
Route::resource('kategorijas', KategorijuController::class)->middleware(['auth', 'role:Admin,Darbinieks']);
Route::resource('jaunumi', JaunumiController::class)->middleware(['auth', 'role:Admin,Darbinieks']);
Route::delete('jaunumi/{jaunumi}/images/{image}', [JaunumiController::class, 'deleteImage'])
    ->middleware(['auth', 'role:Admin,Darbinieks'])
    ->name('jaunumi.deleteImage');
