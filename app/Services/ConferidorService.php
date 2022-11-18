<?php

namespace App\Services;

class ConferidorService
{
    public function checkNumberOfHits(array $dozensBet, array $resultDozens)
    {
        return count(array_intersect($dozensBet, $resultDozens));
    }
}
