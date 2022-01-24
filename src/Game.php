<?php

declare(strict_types=1);

namespace App;

use LogicException;

class Game
{
    private int $score = 0;
    private int $framePoints = 0;
    private int $rolls = 2;
    private int $round = 0;
    private bool $strike = false;
    private bool $spare = false;

    public function roll(int $points): void
    {
        $this->rolls--;
        $this->score += $points;
        $this->framePoints += $points;

        if (10 === $this->framePoints && 0 === $this->rolls && !$this->spare && !$this->strike) {
            $this->spare = true;
            $this->rolls++;
        }

        if (10 === $points && 1 === $this->rolls && !$this->spare && !$this->strike) {
            $this->strike = true;
            $this->rolls++;
        }

        if (10 < $this->framePoints && !$this->strike && !$this->spare) {
            throw new LogicException('More than 10 pins knocked in one frame');
        }

        if (20 < $this->framePoints && $this->spare) {
            throw new LogicException('More than 20 pins knocked in one frame (spare)');
        }

        if (30 < $this->framePoints && $this->strike) {
            throw new LogicException('More than 30 pins knocked in one frame (strike)');
        }

        if (0 === $this->rolls) {
            $this->nextRound();
        }
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function getRound(): int
    {
        return $this->round;
    }

    private function nextRound()
    {
        $this->rolls = 2;
        $this->round++;
        $this->framePoints = 0;
        $this->spare = false;
        $this->strike = false;
    }

    private function dumpAll()
    {
        var_dump("
            ROUND: $this->round;
            score: $this->score;
            framePoints: $this->framePoints;
            rolls: $this->rolls;
            strike: $this->strike;
            spare: $this->spare;
        ");
    }
}
