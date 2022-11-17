<?php

namespace App\Services\Generator;

use Illuminate\Support\Facades\Artisan;

class RoutesGeneratorService
{
    public static function callMakeCrudRoutesArtisanCommand($model_name, $controller_name)
    {
        $command_arguments = [
            'model_name' => $model_name,
            'controller_name' => $controller_name,
        ];

        Artisan::call('make:crud-routes', $command_arguments);
    }
}
