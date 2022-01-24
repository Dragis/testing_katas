<?php

declare(strict_types=1);

namespace App;

class Game2
{
    private array $rounds = [];

    public function roll(array $round): void
    {
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
                    if (0 !== $value) {
                        $multipliers[$key]--;
                        $totalScore += $score;
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
