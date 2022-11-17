<?php

namespace App\Http\Controllers;

use App\Models\LotoResult;
use App\Services\ConferidorService;
use Illuminate\Http\Request;

class ConferidorController extends Controller
{
    public function checkResult(Request $request)
    {
        $lotoResult = LotoResult::where('contest_number', $request->contest_number)->whereHas('loto', function ($query) use ($request) {
            $query->where('name', $request->loto_name);
        })->firstOrFail();

        $resultDozensArray = json_decode($lotoResult->dozens, true);

        if ($request->dozens_text != '') {
            $dozensText = $request->dozens_text;
            foreach ($this->oneDigitNumbers() as $oneDigitNumber) {
                $dozensText = preg_replace("/\b$oneDigitNumber\b/", "0$oneDigitNumber", $dozensText);
            }

            $dozensBetArray = explode(',', $request->dozens_text);
        } else {
            $dozensBetArray = $request->dozens;

            foreach ($dozensBetArray as $index => $dozenBet) {
                if (strlen($dozenBet) < 2 && in_array($dozenBet, $this->oneDigitNumbers())) {
                    $dozensBetArray = preg_replace("/\b$dozenBet\b/", "0$dozenBet", $dozensBetArray);
                }
            }
        }
        
        return (new ConferidorService)->checkNumberOfHits($dozensBetArray, $resultDozensArray);
    }

    private function oneDigitNumbers()
    {
        return ['1', '2', '3', '4', '5', '6', '7', '8', '9'];
    }
}
