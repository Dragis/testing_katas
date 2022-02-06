<?php

declare(strict_types=1);

namespace App;

class Game2
{
    private array $rounds = [];

    public function roll(array $round): void
    {

        $round = $this->parseScoreFromLetters($round);

        $this->rounds[] = $round;
    }

    public function setGame(string $game): void
    {
        $rounds = explode(' ', $game);
        foreach ($rounds as $round) {
            $round = $this->parseScoreFromLetters(str_split($round));
            $this->rounds[] = $round;
        }
    }

    public function getScore(): int
    {
        $totalScore = 0;
        $multipliers = [];

        foreach ($this->rounds as $roundNr => $round) {
            $roundScore = 0;

            foreach ($round as $score) {
                $roundScore += $score;
                [$totalScore, $multipliers] = $this->multiplyScore($multipliers, $score, $totalScore);
                $totalScore += $score;

                $multipliers = $this->setMultipliers($roundNr, $score, $multipliers, $roundScore);
            }
        }

        return $totalScore;
    }

    protected function parseScoreFromLetters(array $round): array
    {
        $roundScore = 0;
        foreach ($round as $key => $value) {
            $round[$key] = (int) $value;
            if ('X' === $value) {
                $round[$key] = 10;
            }

            if ('-' === $value) {
                $round[$key] = 0;
            }

            if ('/' === $value) {
                $round[$key] = 10 - $roundScore;
            }

            $roundScore += $round[$key];
        }

        return $round;
    }

    protected function multiplyScore(array $multipliers, int $score, int $totalScore): array
    {
        foreach ($multipliers as $key => $value) {
            $multipliers[$key]--;
            $totalScore += $score;

            if (0 === $multipliers[$key]) {
                unset($multipliers[$key]);
            }
        }
        return [$totalScore, $multipliers];
    }

    protected function setMultipliers(int $roundNr, int $score, array $multipliers, int $roundScore): array
    {
        if (9 > $roundNr) {
            if (10 === $score) {
                $multipliers[] = 2;
            } elseif (10 === $roundScore) {
                $multipliers[] = 1;
            }
        }

        return $multipliers;
    }
}
