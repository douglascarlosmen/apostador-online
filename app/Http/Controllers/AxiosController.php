<?php

namespace App\Http\Controllers;

use App\Models\LotoResult;
use Illuminate\Http\Request;

class AxiosController extends Controller
{
    public function getContestsByLoto(Request $request)
    {
        $contestsNumbersArray = LotoResult::whereHas('loto', function ($query) use ($request) {
            $query->where('name', $request->loto_name);
        })->limit(10)->get()->keyBy('contest_number')->keys()->toArray();

        return response([
            'contestsNumbers' => $contestsNumbersArray
        ]);
    }

    public function getResultByConstestNumberAndLoto(Request $request)
    {
        $result = LotoResult::whereHas('loto', function ($query) use ($request) {
            $query->where('name', $request->loto_name);
        })->where('contest_number', $request->contest_number)->first();

        return response(['dozens' => json_decode($result->dozens, true)]);
    }
}
