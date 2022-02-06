<?php

declare(strict_types=1);

namespace App;

class Game2
{
    const STRIKE_MULTIPLIER = 2;
    const SPARE_MULTIPLIER = 1;
    const STRIKE = 'X';
    const MISS = '-';
    const SPARE = '/';
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

            foreach ($round as $rollNr => $score) {
                $roundScore += $score;
                [$totalScore, $multipliers] = $this->multiplyScore($multipliers, $score, $totalScore);
                $totalScore += $score;

                $multipliers = $this->setMultipliers($roundNr, $score, $multipliers, $roundScore, $rollNr);
            }
        }

        return $totalScore;
    }

    protected function parseScoreFromLetters(array $round): array
    {
        $roundScore = 0;
        foreach ($round as $key => $value) {
            $round[$key] = (int) $value;
            if (self::STRIKE === $value) {
                $round[$key] = 10;
            }

            if (self::MISS === $value) {
                $round[$key] = 0;
            }

            if (self::SPARE === $value) {
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

    protected function setMultipliers(int $roundNr, int $score, array $multipliers, int $roundScore, int $rollNr): array
    {
        if (9 > $roundNr) {
            if (10 === $score && 0 === $rollNr) {
                $multipliers[] = self::STRIKE_MULTIPLIER;
            } elseif (10 === $roundScore) {
                $multipliers[] = self::SPARE_MULTIPLIER;
            }
        }

        return $multipliers;
    }
}
