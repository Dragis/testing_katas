<?php

namespace App;

class GameFactory
{
    public function createFromString(string $string): Game2
    {
        $game2 = new Game2();

        $rounds = explode(' ', $string);
        foreach ($rounds as $round) {
            $game2->roll(str_split($round));
        }

        return $game2;
    }
}
