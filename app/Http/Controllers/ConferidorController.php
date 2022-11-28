<?php

namespace App\Http\Controllers;

use App\Models\LotoResult;
use App\Services\ConferidorService;
use Illuminate\Http\Request;

class ConferidorController extends Controller
{
    public function checkResult(Request $request)
    {
        $resultDozensArray = $request->dozens;

        if ($request->dozens_text != '') {

            $response = [];

            $dozens_text = preg_replace('/[ ]{2,}|[\t]|[ ]/', ',', trim($request->dozens_text));

            $rowsArray = preg_split('/\n|\r\n?/', $dozens_text);

            foreach ($rowsArray as $index => $row) {
                foreach ($this->oneDigitNumbers() as $oneDigitNumber) {
                    $rowsArray[$index] = preg_replace("/\b$oneDigitNumber\b/", "0$oneDigitNumber", $row);
                }
            }

            $response['bets'] = $rowsArray;

            $pointsArray = [];
            $matchesArray = [];

            foreach ($response['bets'] as $index => $row) {
                $dozensBetArray = explode(',', $row);
                $pointsArray[] = (new ConferidorService)->checkNumberOfHits($dozensBetArray, $resultDozensArray);
                $matchesArray[] = array_intersect($dozensBetArray, $resultDozensArray);
            }

            foreach ($matchesArray as $matchArray) {

                $tmpString = '';

                foreach($matchArray as $index => $match) {
                    $tmpString .= "$match,";
                }

                $response['matches'][] = substr($tmpString, 0, -1);
            }

            $response['points'] = $pointsArray;

            return response($response);
        }
    }

    private function oneDigitNumbers()
    {
        return ['1', '2', '3', '4', '5', '6', '7', '8', '9'];
    }
}
