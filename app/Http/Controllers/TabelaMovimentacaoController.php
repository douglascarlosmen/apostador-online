<?php

namespace App\Http\Controllers;

use App\Models\LotoResult;
use App\Transformers\TabelaMovimentacaoTransformer;
use App\Helpers\Helper;
use Illuminate\Http\Request;

class TabelaMovimentacaoController extends Controller
{
    public function index(Request $request, string $lottery)
    {
        $limit = $request->limit ?? 30;
        $endContest = $request->end_contest ?? LotoResult::whereHas('loto', function ($query) use ($lottery) {
                                                    return $query->where('name', $lottery);
                                                })->orderBy('contest_number','DESC')->first()->contest_number;

        if ($limit == 'all'){
            $startContest = LotoResult::whereHas('loto', function ($query) use ($lottery) {
                return $query->where('name', $lottery);
            })->orderBy('contest_number','ASC')->first()->contest_number;
        }else{
            $startContest = $request->start_contest ?? (int)$endContest - $limit;
        }

        $results = LotoResult::whereBetween('contest_number', [$startContest, $endContest])
            ->whereHas('loto', function ($query) use ($lottery) {
                return $query->where('name', $lottery);
            })
            ->with('loto')
            ->orderBy('contest_number', 'ASC')
            ->get();

        $allLotteryDozens = Helper::getLotoDozens($lottery);

        $transformer = new TabelaMovimentacaoTransformer($results, $allLotteryDozens);

        return response()->json($transformer->transform());
    }

}
