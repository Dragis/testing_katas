<?php

namespace App\Tests;

use App\Game;
use PHPUnit\Framework\TestCase;

class BowlingTest extends TestCase
{
    private Game $game;

    /** @test */
    public function should_get_score(): void
    {
        $this->game->roll(5);

        $this->assertSame(5, $this->game->getScore());
    }

    /** @test */
    public function should_throw_exception_when_player_gets_more_than_10_points_in_2_rolls(): void
    {
        $this->expectExceptionMessage('More than 10 pins knocked in one frame');

        $this->game->roll(5);
        $this->game->roll(10);
    }
    
    /** @test */
    public function should_allow_to_roll_2_extra_times_when_getting_a_strike(): void
    {
        $this->game->roll(10);
        $this->game->roll(10);
        $this->game->roll(7);

        $this->assertSame(27, $this->game->getScore());
    }

    /** @test */
    public function should_allow_to_roll_1_extra_time_when_getting_a_spare(): void
    {
        $this->game->roll(5);
        $this->game->roll(5);
        $this->game->roll(7);

        $this->assertSame(17, $this->game->getScore());
    }

    /** @test */
    public function should_reset_round_after_2_rolls(): void
    {
        $this->game->roll(5);
        $this->game->roll(4);

        $this->game->roll(7);

        $this->assertSame(16, $this->game->getScore());
    }

    /** @test */
    public function should_reset_round_after_3_rolls_when_getting_a_strike(): void
    {
        $this->game->roll(10);
        $this->game->roll(8);
        $this->game->roll(2);

        $this->game->roll(7);

        $this->assertSame(27, $this->game->getScore());
    }

    /** @test */
    public function should_reset_round_after_3_rolls_when_getting_a_spare(): void
    {
        $this->game->roll(5);
        $this->game->roll(5);
        $this->game->roll(3);

        $this->game->roll(7);

        $this->assertSame(20, $this->game->getScore());
    }

    /** @test */
    public function should_throw_exception_when_player_gets_more_than_20_points_in_spare(): void
    {
        $this->expectExceptionMessage('More than 20 pins knocked in one frame (spare)');

        $this->game->roll(5);
        $this->game->roll(5);
        $this->game->roll(12);
    }

    /** @test */
    public function should_throw_exception_when_player_gets_more_than_30_points_in_strike(): void
    {
        $this->expectExceptionMessage('More than 30 pins knocked in one frame (strike)');

        $this->game->roll(10);
        $this->game->roll(10);
        $this->game->roll(12);
    }

//    /**
//     * @test
//     * @dataProvider getGames
//     */
//    public function should_get_to_round_10_when_rolling_different_amount_of_times(array $rolls, int $score): void
//    {
//        foreach ($rolls as $roll) {
//            $this->game->roll($roll);
//        }
//
//        $this->assertSame($score, $this->game->getScore());
//        $this->assertSame(10, $this->game->getRound());
//    }

    public function getGames()
    {
        return [
            [
                [10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10],
                300
            ],
            [
                [4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4],
                80
            ],
            [
                [4, 6, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 5],
                87
            ],
            [
                [1, 1, 10, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
                30
            ],
            [
                [
                    10, 7, 10,
                    2, 2,
                    10, 3, 3,
                    4, 0,
                    5, 5, 5,
                    6, 2,
                    2, 8, 3,
                    10, 0, 1,
                    9, 1, 1,
                    9, 1, 1,
                ],
                113
            ],
            [
                [
                    0, 10, 10,
                    2, 2,
                    10, 3, 3,
                    4, 0,
                    5, 5, 5,
                    0, 2,
                    2, 8, 3,
                    10, 0, 1,
                    9, 1, 1,
                    9, 1, 1,
                ],
                107
            ],
        ];
    }

    protected function setUp(): void
    {
        $this->game = new Game();
    }
}
