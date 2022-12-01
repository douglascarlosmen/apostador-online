<?php

namespace App\Http\Controllers;

use App\Models\LotoResult;
use App\Services\GeneratorService;
use Illuminate\Http\Request;
use stdClass;

class GeneratorController extends Controller
{
    public function lastResultNumbers(Request $request)
    {
        $lastResult = new stdClass();
        $response = LotoResult::whereHas('loto', function ($query) use ($request) {
            return $query->where('name', $request->lottery);
        })->orderBy('contest_number', 'desc')->first();
        $lastResult->dozens = json_decode($response->dozens, true);
        $lastResult->contestNumber = $response->contest_number;

        $lastResult->even = 0; //Par
        $lastResult->odd = 0; //Ímpar
        $lastResult->prime = 0;
        $lastResult->fibonacci = 0;
        $lastResult->sum = 0;
        $lastResult->threeMultiple = 0;
        foreach($lastResult->dozens as $dozen){
            if ($dozen % 2 == 0) $lastResult->even++;
            else if ($dozen % 2 != 0) $lastResult->odd++;

            if ((new GeneratorService)->isPrime($dozen)) $lastResult->prime++;

            if ((new GeneratorService)->isFibonacci($dozen)) $lastResult->fibonacci++;

            if ($dozen % 3 == 0) $lastResult->threeMultiple++;

            $lastResult->sum += $dozen;
        }

        return response(['lastResult' => $lastResult]);
    }
}
