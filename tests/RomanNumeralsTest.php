<?php

namespace App\Tests;

use App\RomanNumbers;
use PHPUnit\Framework\TestCase;

class RomanNumeralsTest extends TestCase
{
    /**
     * @test
     * @dataProvider numbers
     */
    public function should_return_roman_number_when_given_integer(int $number, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new  RomanNumbers())->convert($number)
        );
    }

    public function numbers(): array
    {
        return [
            [0, ''],
            [1, 'I'],
            [2, 'II'],
            [4, 'IV'],
            [5, 'V'],
            [1005, 'MV'],
            [1005, 'MV'],
            [1015, 'MXV'],
            [2015, 'MMXV'],
            [2069, 'MMLXIX'],
            [1999, 'MCMXCIX'],
        ];
    }
}
