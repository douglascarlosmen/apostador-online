<?php

namespace Database\Seeders;

use App\Models\Loto;
use App\Models\LotoResult;
use App\Services\LoteriasService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LotosResultsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lotos = Loto::with(['results' => function ($query) {
            return $query->orderBy('contest_number', 'DESC');
        }])->get();

        foreach ($lotos as $loto) {
            $lastContestNumber = $loto->results->first()->contest_number;

            $lastContestResult = (new LoteriasService)->getLastLotoResult($loto->name);

            if (!empty($lastContestResult)) {

                $difference = $lastContestResult['numero_concurso'] - $lastContestNumber;

                if ($difference > 0) {
                    for ($i = 1; $i <= $difference; $i++) {
                        $contestNumber = $lastContestNumber + $i;
                        $result = (new LoteriasService)->getSpecificContestLotoResult($loto->name, $contestNumber);
                        LotoResult::create([
                            "loto_id" => $loto->id,
                            "name" => $result['nome'],
                            "contest_number" => $result['numero_concurso'],
                            "contest_date" => $result['data_concurso'],
                            "place" => $result['local_realizacao'],
                            "dozens" => json_encode($result['dezenas']),
                            "awards" => json_encode($result['premiacao']),
                            "awarded_states" => !empty($result['local_ganhadores']) ? json_encode($result['local_ganhadores']) : '',
                            "accumulated" => $result['acumulou'],
                            "accumulated_next_contest" => $result['valor_estimado_proximo_concurso'],
                            "date_next_contest" => $result['data_proximo_concurso'],
                            "next_context_number" => $result['concurso_proximo']
                        ]);
                    }
                }
            }
        }
    }
}
