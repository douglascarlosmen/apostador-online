<?php

namespace App\Helpers;

class FormatterHelper{
    public static function numtostring($value, $sigFigs = 3){
        //SI prefix symbols
        $units = array('', 'mil', 'milhão', 'bilhão', 'trilhão');
        //how many powers of 1000 in the value?
        $index = floor(log10($value)/3);
        $value = $index ? $value/pow(1000, $index) : $value;
        $sigFig =  self::sigFig($value, $sigFigs);
        $unit = $units[$index];

        if ($sigFig > 2){
            switch($unit){
                case "milhão":
                    $unit = "milhões";
                    break;
                case "bilhão":
                    $unit = "bilhões";
                    break;
                case "trilhão":
                    $unit = "trilhões";
                    break;
            }
        }

        return $sigFig. " ".$unit;
    }

    /** Calculate $value to $sigFigs significant figures */
    private static function sigFig($value, $sigFigs = 3) {
        //convert to scientific notation e.g. 12345 -> 1.2345x10^4
        //where $significand is 1.2345 and $exponent is 4
        $exponent = floor(log10(abs($value))+1);
        $significand = round(($value
            / pow(10, $exponent))
            * pow(10, $sigFigs))
            / pow(10, $sigFigs);
        return $significand * pow(10, $exponent);
    }
}
