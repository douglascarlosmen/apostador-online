<?php

namespace App\Console\Commands;

use App\Models\Loto;
use App\Models\LotoResult;
use App\Services\LoteriasService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateLotosResults extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-loto-results';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Busca novos resultados e atualiza o banco de dados';

    protected $results = [];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ini_set('max_execution_time', 0);

        $lotos = Loto::with(['results' => function ($query) {
            return $query->orderBy('contest_number', 'DESC');
        }])->get();

        $progressbar = $this->output->createProgressBar(count($lotos));
        $progressbar->start();
        foreach ($lotos as $loto) {
            $lastContestResult = (new LoteriasService)->getLastLotoResult($loto->name);

            if (!empty($lastContestResult)) {
                for ($i = 1; $i <= $lastContestResult['numero_concurso']; $i++) {
                    $contestNumber = $i;
                    if (!LotoResult::where('name', $loto->name)->where('contest_number', $contestNumber)->exists()) {

                        $result = (new LoteriasService)->getSpecificContestLotoResult($loto->name, $contestNumber);

                        if (isset($result['numero_concurso'])){
                            LotoResult::create([
                                "loto_id" => $loto->id,
                                "name" => $loto->name,
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

            $progressbar->advance();
        }
        $progressbar->finish();
    }
}
