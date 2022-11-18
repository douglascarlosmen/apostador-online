<?php

use App\Http\Controllers\AxiosController;
use App\Http\Controllers\ConferidorController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'application.front.index');

Route::post('/conferir-resultado', [ConferidorController::class, 'checkResult'])->name('check.results');
Route::get('/obter-numero-de-concursos-pela-loteria', [AxiosController::class, 'getContestsByLoto'])->name('lottery.contest');
Route::get('/obter-resultado-por-concurso-da-loteria', [AxiosController::class, 'getResultByConstestNumberAndLoto'])->name('lottery.results');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
