<?php

namespace App\Services\Generator;

use Illuminate\Support\Facades\Artisan;

class CrudViewsGeneratorService
{
    public static function transformInputsInArtisanCommandJsonFormat($inputs)
    {
        $array = [];

        foreach ($inputs as $input) {
            $array[ucfirst($input['field'])] = [
                'input_name' => $input['field'],
                'input_type' => $input['input_type']
            ];

            if ($input['is_required']) {
                $array[ucfirst($input['field'])]['required'] = true;
            }

            if ($input['input_type'] == 'select') {
                $option_array = [];

                foreach ($input['select_option'] as $option) {
                    $option_array[] = $option;
                }

                $array[ucfirst($input['field'])]['input_options'] = $option_array;
            }
        }

        return json_encode($array);
    }

    public static function transformTableDataInArtisanCommandJsonFormat($inputs)
    {
        $table_heads = [];
        $table_rows = [];

        foreach ($inputs as $input) {
            if ($input['show_in_index']) {
                $table_heads[] = ucfirst($input['field']);
                $table_rows[] = $input['field'];
            }
        }

        $array['table_heads'] = $table_heads;
        $array['table_rows']['data'] = $table_rows;

        
        return json_encode($array);
    }

    public static function callMakeCrudViewsArtisanCommand($model_name, $theme_name, $inputs, $table_data)
    {
        $command_arguments = [
            'model_name' => $model_name,
            'theme_name'=> $theme_name,
            'inputs' => $inputs,
            'table_data' => $table_data
        ];

        Artisan::call('make:crud-views', $command_arguments);
    }
}
