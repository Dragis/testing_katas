<?php

namespace App\Tests;

use App\PrimeFactors;
use PHPUnit\Framework\TestCase;

class PrimeFactorsTest extends TestCase
{
    /**
     * @test
     * @dataProvider numbers
     */
    public function should_generate_prime_factor_when_number_is($number, $expected)
    {
        $this->assertEquals($expected, (new  PrimeFactors())->generate($number));
    }

    /**
     * @test
     * @dataProvider numbers
     */
    public function should_generate_prime_factor_when_number_is_($number, $expected)
    {
        $this->assertEquals($expected, (new  PrimeFactors())->generate($number));
    }

    public function numbers()
    {
        return [
            [1, []],
            [2, [2]],
            [3, [3]],
            [4, [2, 2]],
            [25, [5, 5]],
            [35, [5, 7]],
        ];
    }
}
