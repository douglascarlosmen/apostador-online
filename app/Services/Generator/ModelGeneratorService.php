<?php

namespace App\Services\Generator;

use Illuminate\Support\Facades\Artisan;

class ModelGeneratorService
{
    public static function callMakeCustomModelArtisanCommand($model_name, $table_name, $model_fields, $softdelete = false, $relations = null)
    {
        $command_arguments = [
            'model_name' => $model_name,
            'table' => $table_name,
            'fields' => self::mountModelFieldsJson($model_fields),
            '--softdelete' => $softdelete
        ];

        if (!is_null($relations)) {
            $command_arguments['relationships'] = self::transformRequestInRelationsJson($relations);
        }

        Artisan::call('make:custom-model', $command_arguments);
    }

    public static function mountModelFieldsJson($table_fields)
    {
        $fields = [];

        foreach ($table_fields as $field) {
            $fields[] = $field['name'];
        }

        return json_encode(['fields' => $fields]);
    }

    public static function transformRequestInRelationsJson($relations)
    {
        $relations_array = [];

        foreach ($relations as $relation) {
            $relations_array[$relation['relation_name']] = [
                'type' => $relation['relation_type'],
                'related_to' => $relation['relates_to'] . '::class',
                'foreign_key' => $relation['fk']
            ];
        }

        return json_encode($relations_array);
    }
}
