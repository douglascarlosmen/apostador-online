<?php

namespace App\Services\Generator;

use Illuminate\Support\Facades\Artisan;

class ControllerGeneratorService
{
    public static function callMakeCustomControllerArtisanCommand($controller_name, $model_name, $api = false)
    {
        $command_arguments = [
            'controller_name' => $controller_name,
            'model' => $model_name
        ];

        if ($api) {
            $command_arguments['--api'] = true;
        }

        Artisan::call('make:custom-controller', $command_arguments);
    }
}
