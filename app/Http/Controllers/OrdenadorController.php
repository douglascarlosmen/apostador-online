<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;

class OrdenadorController extends Controller
{
    public function order(Request $request)
    {
        if ($request->dozens_text != '') {

            $data = [];

            $dozens_text = preg_replace('/[ ]{2,}|[\t]|[ ]/', ',', trim($request->dozens_text));

            $rowsArray = preg_split('/\n|\r\n?/', $dozens_text);

            foreach ($rowsArray as $index => $row) {
                foreach (Helper::oneDigitNumbers() as $oneDigitNumber) {
                    $row = preg_replace("/\b$oneDigitNumber\b/", "0$oneDigitNumber", $row);
                    $rowsArray[$index] = $row;
                }
            }

            $data['bets'] = $rowsArray;

            $response = [];

            foreach ($data['bets'] as $index => $row) {
                $dozensBetArray = explode(',', $row);
                sort($dozensBetArray);
                $response[] = $dozensBetArray;
            }

            return response($response);
        }
    }
}
