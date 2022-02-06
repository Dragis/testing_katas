<?php

declare(strict_types=1);

namespace App;

class Game2
{
    private array $rounds = [];

    public function roll(array $round): void
    {
        foreach ($round as $key => $value) {
            if ('X' === $value) {
                $round[$key] = 10;
            }
        }

        $this->rounds[] = $round;
    }

    public function getScore(): int
    {
        $totalScore = 0;
        $multipliers = [];

        foreach ($this->rounds as $roundNr => $round) {
            $roundScore = 0;

            foreach ($round as $score) {
                $roundScore += $score;
                foreach ($multipliers as $key => $value) {
                    $multipliers[$key]--;
                    $totalScore += $score;

                    if (0 === $multipliers[$key]) {
                        unset($multipliers[$key]);
                    }
                }
                $totalScore += $score;

                if (9 > $roundNr) {
                    if (10 === $score) {
                        $multipliers[] = 2;
                    } elseif (10 === $roundScore) {
                        $multipliers[] = 1;
                    }
                }
            }
        }

        return $totalScore;
    }
}
