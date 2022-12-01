<?php

namespace App\Helpers;

use App\Constants\Dozens;

class Helper {

    public static function oneDigitNumbers()
    {
        return ['1', '2', '3', '4', '5', '6', '7', '8', '9'];
    }

    public static function getLotoDozens(string $loto)
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
