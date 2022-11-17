<?php

namespace App\Http\Controllers;

use App\Models\LotoResult;
use App\Services\ConferidorService;
use Illuminate\Http\Request;

class ConferidorController extends Controller
{
    public function checkResult(Request $request)
    {
        $lotoResult = LotoResult::where('contest_number', $request->contest_number)->whereHas('loto', function($query) use ($request) {
            $query->where('name', $request->loto_name);
        })->firstOrFail();

        $dozensArray = json_decode($lotoResult->dozens, true);

        return (new ConferidorService)->checkNumberOfHits($request->dozens, $dozensArray);
    }
}
