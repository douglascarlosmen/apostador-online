<?php

namespace App\Services;

class GeneratorService
{
    public function isPrime($number){
        if ($number == 1)
            return false;

        for ($i = 2; $i <= $number/2; $i++){
            if ($number % $i == 0)
                return false;
        }
        return true;
    }

    private function isPerfectSquare($x){
        $s = (int)(sqrt($x));
        return ($s * $s == $x);
    }

    // Returns true if n is a
    // Fibonacci Number, else false
    public function isFibonacci($n){
        // n is Fibonacci if one of
        // 5*n*n + 4 or 5*n*n - 4 or
        // both is a perfect square
        return $this->isPerfectSquare(5 * $n * $n + 4) ||
            $this->isPerfectSquare(5 * $n * $n - 4);
    }
}
