<?php

use App\Http\Controllers\AxiosController;
use App\Http\Controllers\ConferidorController;
use App\Http\Controllers\GeneratorController;
use Illuminate\Support\Facades\Route;

Route::view('/conferidor/{lottery}', 'application.front.index')->name('conferidor');
Route::view('/gerador/{lottery}', 'application.front.generator')->name('gerador');

Route::post('/conferir-resultado', [ConferidorController::class, 'checkResult'])->name('check.results');
Route::get('/obter-numero-de-concursos-pela-loteria', [AxiosController::class, 'getContestsByLoto'])->name('lottery.contest');
Route::get('/obter-resultado-por-concurso-da-loteria', [AxiosController::class, 'getResultByConstestNumberAndLoto'])->name('lottery.results');

Route::post('/generate', [GeneratorController::class, 'lastResultNumbers'])->name('generate.last');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', function () {
    return redirect('/conferidor/mega-sena');
});
