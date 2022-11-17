<?php

namespace App\Services\Generator;

use Illuminate\Support\Facades\Artisan;

class ViaCepGeneratorService {

    public static function callMakeViaCepIntegrationArtisanCommand()
    {
        Artisan::call('make:via-cep-integration');
    }
}
