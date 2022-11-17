<?php

namespace App\Http\Controllers\Generator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Generator\MigrationGeneratorService;
use App\Services\MigrationsService;
use App\Services\Generator\ModelGeneratorService;
use App\Services\ModelsService;
use Illuminate\Support\Facades\Artisan;

class MigrationModelController extends Controller
{
    public function index()
    {
        return view('welcome', ['tables' => MigrationsService::getAllTables()]);
    }

    public function addTableFieldRow(Request $request)
    {
        return response([
            'html' => view('dinamic.table_field_inputs', [
                'index' => $request->index,
                'tables' => MigrationsService::getAllTables()
            ])->render()
        ]);
    }

    public function addModelRelationRow(Request $request)
    {
        return response([
            'html' => view('dinamic.model_relation_inputs', [
                'index' => $request->index,
                'models' => ModelsService::getAllModels()
            ])->render()
        ]);
    }

    public function generateMigrationAndModel(Request $request)
    {
        /**
         * Migration Genaration
         */
        MigrationGeneratorService::callMakeCustomMigrationArtisanCommand(
            $request->table_name,
            MigrationGeneratorService::transformInArtisanCommandJsonFormat($request->table_fields),
            isset($request->softdelete)
        );

        /**
         * Migrating
         */
        Artisan::call('migrate');

        /**
         * Model Generation
         */
        ModelGeneratorService::callMakeCustomModelArtisanCommand(
            $request->model_name,
            $request->table_name,
            $request->table_fields,
            isset($request->softdelete),
            $request->relations
        );

        return redirect()->back();
    }
}
