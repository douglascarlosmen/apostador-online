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

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $lotos = Loto::all();

        foreach ($lotos as $loto) {
            $resultsCounter = 0;
            $this->info("Buscando Resultados Recentes da $loto->name");
            $results = (new LoteriasService)->getAllLotoResults($loto->name);

            if (!empty($results)) {
                foreach ($results as $result) {
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
}
