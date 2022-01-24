<?php

namespace App;

class RomanNumbers
{
    private const VALUES  = [1000, 900,  500, 400,  100, 90,   50,  40,   10,   9,     5,   4,    1];
    private const SYMBOLS = ["M",  "CM", "D", "CD", "C", "XC", "L", "XL", "X", "IX", "V", "IV", "I"];

    public function convert(int $number): string
    {
        $romanNumber = '';

        while (0 < $number) {
            foreach (self::VALUES as $key => $value) {
                if (0 <= $number - $value) {
                    $romanNumber .= self::SYMBOLS[$key];
                    $number -= $value;

                    break;
                }
            }
        }

        return $romanNumber;
    }
}
