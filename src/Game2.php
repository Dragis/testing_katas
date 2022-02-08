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
    private array $multipliers = [];

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

        foreach ($this->rounds as $roundNr => $round) {
            $roundScore = 0;

            foreach ($round as $rollNr => $score) {
                $roundScore += $score;
                $totalScore = $this->multiplyScore($score, $totalScore);
                $totalScore += $score;

                $this->setMultipliers($roundNr, $score, $roundScore, $rollNr);
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

    protected function multiplyScore(int $score, int $totalScore): int
    {
        foreach ($this->multipliers as $key => $value) {
            $this->multipliers[$key]--;
            $totalScore += $score;

            if (0 === $this->multipliers[$key]) {
                unset($this->multipliers[$key]);
            }
        }

        return $totalScore;
    }

    protected function setMultipliers(int $roundNr, int $score, int $roundScore, int $rollNr): void
    {
        if (9 > $roundNr) {
            if (10 === $score && 0 === $rollNr) {
                $this->multipliers[] = self::STRIKE_MULTIPLIER;
            } elseif (10 === $roundScore) {
                $this->multipliers[] = self::SPARE_MULTIPLIER;
            }
        }
    }
}
