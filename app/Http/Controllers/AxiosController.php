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
        })->get()->keyBy('contest_number')->keys()->toArray();

        return response([
            'contestsNumbers' => $contestsNumbersArray
        ]);
    }
}
