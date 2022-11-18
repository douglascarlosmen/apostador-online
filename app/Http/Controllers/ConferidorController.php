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

            $rowsArray = preg_split('/\n|\r\n?/', $request->dozens_text);

            foreach ($rowsArray as $index => $row) {
                foreach ($this->oneDigitNumbers() as $oneDigitNumber) {
                    $rowsArray[$index] = preg_replace("/\b$oneDigitNumber\b/", "0$oneDigitNumber", $row);
                }
            }

            $resultsArray = [];

            foreach ($rowsArray as $row) {
                $dozensBetArray = explode(',', $row);
                $resultsArray[] = (new ConferidorService)->checkNumberOfHits($dozensBetArray, $resultDozensArray);
            }

            return response(['results' => $resultsArray]);
        }
    }

    private function oneDigitNumbers()
    {
        return ['1', '2', '3', '4', '5', '6', '7', '8', '9'];
    }
}
