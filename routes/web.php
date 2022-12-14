<?php

use App\Http\Controllers\AxiosController;
use App\Http\Controllers\ConferidorController;
use App\Http\Controllers\Generator\ApiIntegrationController;
use App\Http\Controllers\Generator\ControllerRequestRouteController;
use App\Http\Controllers\Generator\MigrationModelController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'application.front.index');

Route::prefix('/generator')->group(function(){
    /**
     * Migration and Model
     */
    Route::get('/', [MigrationModelController::class, 'index']);
    Route::get('/add-table-field-row', [MigrationModelController::class, 'addTableFieldRow']);
    Route::get('/add-model-relation-row', [MigrationModelController::class, 'addModelRelationRow']);
    Route::post('/generate-migration-and-model', [MigrationModelController::class, 'generateMigrationAndModel']);

    /**
     * Routes, Controller and FormRequest *
     */
    Route::get('/routes-controller-request', [ControllerRequestRouteController::class, 'index']);
    Route::get('/get-model-fields', [ControllerRequestRouteController::class, 'getModelFieldsView']);
    Route::post('/generate-routes-controller-request', [ControllerRequestRouteController::class, 'generateControllerRequestAndRoute']);
    Route::get('/get-select-options-inputs', [ControllerRequestRouteController::class, 'getSelectOptionsView']);


    /**
     * APIs Integrations
     */
    Route::get('/apis-integrations', [ApiIntegrationController::class, 'index']);
    Route::post('/generate-api-integrations', [ApiIntegrationController::class, 'generateApiIntegration']);
});

Route::post('/conferir-resultado', [ConferidorController::class, 'checkResult'])->name('check.results');
Route::get('/obter-numero-de-concursos-pela-loteria', [AxiosController::class, 'getContestsByLoto'])->name('lottery.contest');
Route::get('/obter-resultado-por-concurso-da-loteria', [AxiosController::class, 'getResultByConstestNumberAndLoto'])->name('lottery.results');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
