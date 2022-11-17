<?php

namespace App\Services\Generator;

use Illuminate\Support\Facades\Artisan;

class MigrationGeneratorService
{

    public static function transformInArtisanCommandJsonFormat($table_fields)
    {
        $make_migration_array = [];

        foreach ($table_fields as $field) {
            $make_migration_array[$field['name']] = [
                'type' => $field['type']
            ];

            if ($field['nullable'] == 'yes') {
                $make_migration_array[$field['name']]['nullable'] = true;
            }

            if (!is_null($field['default'])) {
                $make_migration_array[$field['name']]['default'] = $field['default'];
            }

            if ($field['is_fk'] == '1') {
                $make_migration_array[$field['name']]['fk_to'] = $field['fk_to'];
            }
        }

        return json_encode($make_migration_array);
    }

    public static function callMakeCustomMigrationArtisanCommand($table_name, $table_fields, $softdelete = false)
    {
        Artisan::call('make:custom-migration', [
            'table' => $table_name,
            'fields' => $table_fields,
            '--softdelete' => $softdelete
        ]);
    }
}
