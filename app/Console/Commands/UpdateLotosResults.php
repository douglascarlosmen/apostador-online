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
        $lotos = Loto::all();

        foreach ($lotos as $loto) {

            $mostRecentResult = $loto->results()->orderBy('contest_number', 'DESC')->first();
            $nextContest = $mostRecentResult->contest_number+1;

            $resultsCounter = 0;
            $this->info("Buscando Resultados Recentes da $loto->name");
            $this->getLatestLotoResult($loto->name, $nextContest);

            if (!empty($this->results)) {
                foreach ($this->results as $result) {
                    if (!LotoResult::where('loto_id', $loto->id)->where('contest_number', $result['concurso'])->exists()) {
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

                        $resultsCounter++;
                    }
                }
            }
            $message = "$resultsCounter novos resultados da $loto->name";
            Log::info($message);
            $this->info($message);
        }
    }

    private function getLatestLotoResult($lotoName, $nextContest)
    {
        $result = (new LoteriasService)->getSpecificContestLotoResult($lotoName, $nextContest);
        
        if ($result['numero_concurso'] != $nextContest) {
            return;
        } else {
            $this->results[] = [
                'nome' => $lotoName,
                'concurso' => $result['numero_concurso'],
                'data' => $result['data_concurso'],
                'local' => $result['local_realizacao'],
                'dezenas' => isset($result['dezenas']) ? $result['dezenas'] : '',
                'premiacoes' => $result['premiacao'],
                'estadosPremiados' => [],
                'acumulou' => isset($result['acumulou']) ? $result['acumulou'] : '',
                'acumuladaProxConcurso' => isset($result['valor_acumulado']) ? $result['valor_acumulado'] : '',
                'dataProxConcurso' => $result['data_proximo_concurso'],
                'proxConcurso' => $result['concurso_proximo'],
                'timeCoracao' => '',
                'mesSorte' => ''
            ];

            $this->getLatestLotoResult($lotoName, $nextContest+1);
        }
    }
}
