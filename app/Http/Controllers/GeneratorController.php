<?php

namespace App\Http\Controllers;

use App\Models\LotoResult;
use App\Services\GeneratorService;
use Illuminate\Http\Request;
use stdClass;

class GeneratorController extends Controller
{
    public function generateNumbers(Request $request)
    {
        $dozens = [];
        while (count($dozens) < $request->maxPrize){
            $randomNumber = rand(1, $request->maxNumber);
            if (!array_search($randomNumber, $dozens)){
                if ($randomNumber == 100) $randomNumber = 00;

                $dozens[] = str_pad($randomNumber, 2, "0", STR_PAD_LEFT);

            }
        }

        $info = new stdClass();
        $info->even = 0; //Par
        $info->odd = 0; //Ímpar
        $info->prime = 0;
        $info->fibonacci = 0;
        $info->sum = 0;
        $info->threeMultiple = 0;
        $info->dozens = count($dozens);


        $lastResult = new stdClass();
        $response = LotoResult::whereHas('loto', function ($query) use ($request) {
            $query->where('name', $request->lottery);
        })->orderBy('contest_number', 'desc')->first();
        $lastResult->dozens = json_decode($response->dozens, true);
        $lastResult->contestNumber = $response->contest_number;

        foreach($dozens as $dozen){
            if ($dozen % 2 == 0) $info->even++;
            else if ($dozen % 2 != 0) $info->odd++;

            if ((new GeneratorService)->isPrime($dozen)) $info->prime++;

            if ((new GeneratorService)->isFibonacci($dozen)) $info->fibonacci++;

            if ($dozen % 3 == 0) $info->threeMultiple++;

            $info->sum += $dozen;
        }

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

        $info->lastLotteryDozensMatch = count(array_intersect($lastResult->dozens, $dozens));

        return response(['dozens' => $dozens, 'info' => $info, 'lastResult' => $lastResult]);
    }
}
