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
        $lotos = Loto::all();

        foreach ($lotos as $loto) {
            $results = (new LoteriasService)->getAllLotoResults($loto->name);

            if (!empty($results)) {
                foreach ($results as $result) {
                    LotoResult::create([
                        "loto_id" => $loto->id,
                        "name" => $result['nome'],
                        "contest_number" => $result['concurso'],
                        "contest_date" => $result['data'],
                        "place" => $result['local'],
                        "dozens" => json_encode($result['dezenas']),
                        "awards" => json_encode($result['premiacoes']),
                        "awarded_states" => !empty($result['estadosPremiados']) ? json_encode($result['estadosPremiados']) : '',
                        "accumulated" => $result['acumulou'],
                        "accumulated_next_contest" => $result['acumuladaProxConcurso'],
                        "date_next_contest" => $result['dataProxConcurso'],
                        "next_context_number" => $result['proxConcurso'],
                        "heart_team" => $result['timeCoracao'],
                        "lucky_month" => $result['mesSorte']
                    ]);
                }
            }
        }
    }
}
