<?php

namespace App\Http\Controllers;

use App\Models\LotoResult;
use App\Transformers\TabelaMovimentacaoTransformer;
use App\Constants\Dozens;
use Illuminate\Http\Request;

class TabelaMovimentacaoController extends Controller
{
    public function index(Request $request, string $lottery)
    {
        $limit = is_numeric($request->limit) ? $request->limit : 30;
        $endContest = $request->end_contest ?? LotoResult::whereHas('loto', function ($query) use ($lottery) {
                                                    return $query->where('name', $lottery);
                                                })->orderBy('contest_number','DESC')->first()->contest_number;
        $startContest = $request->start_contest ?? (int)$endContest - $limit;

        $results = LotoResult::whereBetween('contest_number', [$startContest, $endContest])
            ->whereHas('loto', function ($query) use ($lottery) {
                return $query->where('name', $lottery);
            })
            ->with('loto')
            ->orderBy('contest_number', 'ASC')
            ->limit($limit)
            ->get();

        $allLotteryDozens = $this->getLotoDozens($lottery);

        $transformer = new TabelaMovimentacaoTransformer($results, $allLotteryDozens);
        /**
         * É só retornar esse objeto abaixo para a view
         */
        return response()->json($transformer->transform());
    }

    private function getLotoDozens(string $loto)
    {
        $dozens = [];

        switch ($loto) {
            case 'mega-sena':
                $dozens = Dozens::MEGA_SENA;
                break;
            case 'lotofacil':
                $dozens = Dozens::LOTOFACIL;
                break;
            case 'quina':
                $dozens = Dozens::QUINA;
                break;
            case 'lotomania':
                $dozens = Dozens::LOTOMANIA;
                break;
            case 'timemania':
                $dozens = Dozens::TIMEMANIA;
                break;
            case 'dupla-sena':
                $dozens = Dozens::DUPLA_SENA;
                break;
            case 'dia-de-sorte':
                $dozens = Dozens::DIA_DE_SORTE;
                break;
        }

        return $dozens;
    }
}