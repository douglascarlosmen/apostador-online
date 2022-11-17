<?php

namespace App\Http\Controllers\Generator;

use App\Http\Controllers\Controller;
use App\Services\Generator\ViaCepGeneratorService;
use Illuminate\Http\Request;

class ApiIntegrationController extends Controller
{
    public function index()
    {
        return view('api_integrations');
    }

    public function generateApiIntegration(Request $request)
    {
        if ($request->via_cep) {
            ViaCepGeneratorService::callMakeViaCepIntegrationArtisanCommand();
        }

        return redirect()->back();
    }
}
