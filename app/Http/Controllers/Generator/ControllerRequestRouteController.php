<?php

namespace App\Http\Controllers\Generator;

use App\Http\Controllers\Controller;
use App\Services\Generator\ControllerGeneratorService;
use App\Services\Generator\CrudViewsGeneratorService;
use App\Services\Generator\FormRequestGeneratorService;
use App\Services\ModelsService;
use App\Services\Generator\RoutesGeneratorService;
use Illuminate\Http\Request;

class ControllerRequestRouteController extends Controller
{
    public function index()
    {
        return view('controller_request_route', ['models' => ModelsService::getAllModels()]);
    }

    public function getModelFieldsView(Request $request)
    {
        $model_name = "\App\Models\\" . $request->model_name;
        $model = new $model_name();
        $model_fields = $model->getFillable();

        return response([
            'validation_html' => view('dinamic.model_fields_inputs', ['model_fields' => $model_fields])->render(),
            'form_html' => view('dinamic.form_fields_inputs', ['model_fields' => $model_fields])->render(),
        ]);
    }

    public function generateControllerRequestAndRoute(Request $request)
    {
        $controller_name = $request->model_name . 'Controller';

        /**
         * Routes Generation
         */
        RoutesGeneratorService::callMakeCrudRoutesArtisanCommand($request->model_name, $controller_name);

        /**
         * FormRequest Generation
         */

        FormRequestGeneratorService::callMakeFormRequestArtisanCommand(
            $request->model_name,
            FormRequestGeneratorService::transformInArtisanCommandJsonFormat($request->model_fields)
        );

        /**
         * Controller Generation
         */

        ControllerGeneratorService::callMakeCustomControllerArtisanCommand(
            $controller_name,
            $request->model_name,
            isset($request->generate_api_controller)
        );

        /**
         * Views Generation
         */
        CrudViewsGeneratorService::callMakeCrudViewsArtisanCommand(
            $request->model_name,
            $request->theme_name,
            CrudViewsGeneratorService::transformInputsInArtisanCommandJsonFormat($request->form_fields),
            CrudViewsGeneratorService::transformTableDataInArtisanCommandJsonFormat($request->form_fields)
        );

        return redirect()->back();
    }

    public function getSelectOptionsView(Request $request)
    {
        return response([
            'html' => view('dinamic.select_options_inputs', ['index' => $request->index, 'field_index' => $request->field_index])->render()
        ]);
    }
}
