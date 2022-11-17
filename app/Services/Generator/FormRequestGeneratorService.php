<?php

namespace App\Services\Generator;

use Illuminate\Support\Facades\Artisan;

class FormRequestGeneratorService
{
    public static function transformInArtisanCommandJsonFormat($model_fields)
    {
        $array = [];

        foreach($model_fields as $field) {
            if ($field['is_required']) {
                $array[$field['field']]['is_required'] = true;
            }

            if ($field['is_email']) {
                $array[$field['field']]['is_email'] = true;
            }
        }

        return json_encode($array);
    }

    public static function callMakeFormRequestArtisanCommand($model_name, $fields)
    {
        $command_arguments = [
            'model_name' => $model_name,
            'fields' => $fields,
        ];

        Artisan::call('make:custom-request', $command_arguments);
    }
}
