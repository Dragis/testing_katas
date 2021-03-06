<?php

namespace App\Tests;

use App\Game2;
use PHPUnit\Framework\TestCase;

class Bowling2Test extends TestCase
{
    private Game2 $game;

    /** @test */
    public function should_get_score_with_1_roll(): void
    {
        $this->game->roll([5]);

        $this->assertSame(5, $this->game->getScore());
    }

    /** @test */
    public function should_get_score_with_2_rolls(): void
    {
        $this->game->roll([5, 5]);

        $this->assertSame(10, $this->game->getScore());
    }

    /** @test */
    public function should_get_score_with_1_strike(): void
    {
        $this->game->roll([10]);
        $this->game->roll([3, 6]);

        $this->assertSame(28, $this->game->getScore());
    }

    /** @test */
    public function should_get_perfect_score(): void
    {
        $this->game->roll([10]);
        $this->game->roll([10]);
        $this->game->roll([10]);
        $this->game->roll([10]);
        $this->game->roll([10]);
        $this->game->roll([10]);
        $this->game->roll([10]);
        $this->game->roll([10]);
        $this->game->roll([10]);
        $this->game->roll([10]);
        $this->game->roll([10]);
        $this->game->roll([10]);

        $this->assertSame(300, $this->game->getScore());
    }

    /** @test */
    public function should_get_correct_score_with_spare(): void
    {
        $this->game->roll([7, 3]);
        $this->game->roll([4, 2]);

        $this->assertSame(20, $this->game->getScore());
    }

    /**
     * @test
     * @dataProvider getGames
     */
    public function should_get_correct_score_with_spare_asd(array $rounds, int $result): void
    {
        foreach ($rounds as $round) {
            $this->game->roll($round);
        }

        $this->assertSame($result, $this->game->getScore());
    }

    /** @test */
    public function should_count_x_as_strike(): void
    {
        $this->game->roll(['X']);
        $this->game->roll([4, 2]);

        $this->assertSame(22, $this->game->getScore());
    }

    /** @test */
    public function should_get_perfect_score_when_rolling_x(): void
    {
        $this->game->roll(['X']);
        $this->game->roll(['X']);
        $this->game->roll(['X']);
        $this->game->roll(['X']);
        $this->game->roll(['X']);
        $this->game->roll(['X']);
        $this->game->roll(['X']);
        $this->game->roll(['X']);
        $this->game->roll(['X']);
        $this->game->roll(['X']);
        $this->game->roll(['X']);
        $this->game->roll(['X']);

        $this->assertSame(300, $this->game->getScore());
    }

    /** @test */
    public function should_count_slash_as_spare(): void
    {
        $this->game->roll([1, '/']);
        $this->game->roll([4, 2]);

        $this->assertSame(20, $this->game->getScore());
    }

    /** @test */
    public function should_count_minus_as_miss(): void
    {
        $this->game->roll([1, '-']);
        $this->game->roll([4, 2]);

        $this->assertSame(7, $this->game->getScore());
    }

    /**
     * @test
     * @dataProvider getGameString
     */
    public function should_take_whole_game_as_input(string $game, int $score): void
    {
        $this->game->setGame($game);

        $this->assertSame($score, $this->game->getScore());
    }

    public function getGameString(): array
    {
        return [
            ['X X X X X X X X X X X X', 300],
            ['9/ 9/ 9/ 9/ 9/ 9/ 9/ 9/ 9/ 9/9', 190],
            ['9- 9- 9- 9- 9- 9- 9- 9- 9- 9-', 90],
            ['5/ 5/ 5/ 5/ 5/ 5/ 5/ 5/ 5/ 5/5', 150],
            ['62 72 34 8/ 9- X X X 63 8/7', 153],
            ['5/ 45 8/ X -/ X 62 X 4/ XX-', 169],
        ];
    }

    public function getGames(): array
    {
        return [
            'perfect game' => [
                'rounds' => [[10], [10], [10], [10], [10], [10], [10], [10], [10], [10, 10, 10]],
                'result' => 300
            ],
            '133' => [
                'rounds' => [[1,4], [4,5], [6,4], [5,5], [10], [0,1], [7,3], [6,4], [10], [2,8], [6]],
                'result' => 133,
            ],
            '15' => [
                'rounds' => [[1,4], [10]],
                'result' => 15,
            ],
            '61' => [
                'rounds' => [[1,4], [10], [10], [6,4]],
                'result' => 5 + 26 + 20 + 10,
            ],
            '81' => [
                'rounds' => [[1,4], [10], [10], [6,4], [10]],
                'result' => 5 + 26 + 20 + 10 + 20,
            ],
        ];
    }


    protected function setUp(): void
    {
        $this->game = new Game2();
    }
}
