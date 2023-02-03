<?php

use App\Http\Controllers\AxiosController;
use App\Http\Controllers\ConferidorController;
use App\Http\Controllers\GeneratorController;
use App\Http\Controllers\OrdenadorController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\TabelaMovimentacaoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/conferidor/{lottery}', 'application.front.index')->name('conferidor');
Route::view('/gerador/{lottery}', 'application.front.generator')->name('gerador');
Route::view('/tabela-de-movimentacao-das-dezenas/{lottery}', 'application.front.movement')->name('movimentacao');
Route::view('/ordenador', 'application.front.sorter')->name("ordenador");
Route::get('/tabela-de-movimentacao/{lottery}', [TabelaMovimentacaoController::class, 'index'])->name('tabela_movimentacao');
Route::post('/ordenar', [OrdenadorController::class, 'order'])->name('order');
Route::view('/print', 'application.front.printer')->name('print');
Route::post('/print', [PrintController::class, 'print'])->name('print.make');

Route::post('/conferir-resultado', [ConferidorController::class, 'checkResult'])->name('check.results');
Route::get('/obter-numero-de-concursos-pela-loteria', [AxiosController::class, 'getContestsByLoto'])->name('lottery.contest');
Route::get('/obter-resultado-por-concurso-da-loteria', [AxiosController::class, 'getResultByConstestNumberAndLoto'])->name('lottery.results');

Route::post('/conferir-premiacoes', [ConferidorController::class, 'checkPrimes'])->name('check.primes');

Route::post('/generate', [GeneratorController::class, 'lastResultNumbers'])->name('generate.last');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [SiteController::class, 'index']);

