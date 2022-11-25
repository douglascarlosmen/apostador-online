<?php

use App\Http\Controllers\AxiosController;
use App\Http\Controllers\ConferidorController;
use App\Http\Controllers\GeneratorController;
use Illuminate\Support\Facades\Route;

<<<<<<< HEAD
Route::get('/', function(){
    return redirect()->route('conferidor', ['lottery' => 'mega-sena']);
});

Route::view('/conferidor/{lottery}', 'application.front.index')->name('conferidor');
Route::view('/gerador/{lottery}', 'application.front.generator')->name('gerador');
=======
Route::view('/', 'application.front.index');
Route::view('/gerador', 'application.front.generator')->middleware('auth');
>>>>>>> d916dcfc22886f763d9e6805121b3e37a500a081

Route::post('/conferir-resultado', [ConferidorController::class, 'checkResult'])->name('check.results');
Route::get('/obter-numero-de-concursos-pela-loteria', [AxiosController::class, 'getContestsByLoto'])->name('lottery.contest');
Route::get('/obter-resultado-por-concurso-da-loteria', [AxiosController::class, 'getResultByConstestNumberAndLoto'])->name('lottery.results');

Route::post('/generate', [GeneratorController::class, 'generateNumbers'])->name('generate');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
