<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class ModelsService
{
    public static function getAllModels()
    {
        $models = [];
        $modelsPath = app_path('Models');
        $modelFiles = File::allFiles($modelsPath);
        foreach ($modelFiles as $modelFile) {
            $models[] = $modelFile->getFilenameWithoutExtension();
        }

        return $models;
    }
}
