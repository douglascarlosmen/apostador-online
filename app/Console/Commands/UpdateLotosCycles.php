<?php

namespace App\Console\Commands;

use App\Models\Loto;
use Illuminate\Console\Command;
use App\Helpers\Helper;

class UpdateLotosCycles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-loto-cycles';

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
        $lotos = Loto::with(['results' => function($query){
            return $query->orderBy('contest_number', 'ASC');
        }])->get();

        foreach ($lotos as $loto) {
            $cycleCounter = 1;
            $cycleArray = [];
            foreach ($loto->results as $result) {
                $result->update(['cycle' => null]);
            }

            if (!empty($loto->results)) {
                $allLotteryDozens = Helper::getLotoDozens($loto->name);
                $allLotteryDozensCount = count($allLotteryDozens);

                foreach ($loto->results as $result) {
                    $resultDozensArray = json_decode($result->dozens, true);

                    foreach($resultDozensArray as $dozen) {
                        if (!in_array($dozen, $cycleArray)) {
                            $cycleArray[] = $dozen;
                        }
                    }

                    if (count($cycleArray) == $allLotteryDozensCount) {
                        $result->update(['cycle' => $cycleCounter]);
                        $this->info("Concurso $result->contest_number é o final do ciclo $cycleCounter da $loto->name.");
                        $cycleCounter++;
                        $cycleArray= [];
                    }
                }
            }
        }
    }
}
