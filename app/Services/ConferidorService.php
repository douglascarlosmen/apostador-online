<?php

namespace App\Services;

use App\Models\Loto;

class ConferidorService
{
    public function checkNumberOfHits(array $dozensBet, array $resultDozens)
    {
        return count(array_intersect($dozensBet, $resultDozens));
    }

    public function getOtherPrimesWithDozens(string $loto, array $dozens, int|string $minElegible)
    {
        $loto = Loto::whereName($loto)->with('results')->first();
        $othersResults = [];

        foreach ($loto->results as $result) {
            $resultDozensArray = json_decode($result->dozens, true);
            $assertsCount = count(array_intersect($dozens, $resultDozensArray));

            if($assertsCount >= $minElegible) {
                if (!isset($othersResults["$assertsCount"])) {
                    $othersResults["$assertsCount"]['count'] = 1;
                } else {
                    $othersResults["$assertsCount"] += 1;
                }
                $othersResults["$assertsCount"]['contests'][] = $result->contest_number;
            }
        }

        return $othersResults;

    }
}
