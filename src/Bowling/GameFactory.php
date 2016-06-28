<?php

namespace Bowling;

class GameFactory
{
    public function createNewGame(): Game
    {
        return new Game();
    }

    public function createGutterGame(): Game
    {
        $game = $this->createNewGame();

        for ($i = 0; $i < Game::MAX_NUMBER_OF_ROLLS_POSSIBLE; ++$i) {
            $game->roll(RollResult::GUTTER());
        }

        return $game;
    }

    public function createPerfectGame(): Game
    {
        $game = $this->createNewGame();

        for ($i = 0; $i < Game::MAX_NUMBER_OF_STRIKES_POSSIBLE; ++$i) {
            $game->roll(RollResult::STRIKE());
        }

        return $game;
    }

    /*
     * Note: Last roll on last frame will be a gutter.
     */
    public function createSpareGame(RollResult $rollWhenNotASpare): Game
    {
        $game = $this->createNewGame();

        for ($i = 0; $i < Game::MAX_NUMBER_OF_FRAMES_POSSIBLE; ++$i) {
            $game->roll($rollWhenNotASpare);
            $game->roll(RollResult::SPARE());
        }

        $game->roll($rollWhenNotASpare);

        return $game;
    }

    /**
     * Creates a game from an array with string representations of rolls.
     *
     * For example:
     *
     * ['X', '3/', 'X', '5', ...]
     */
    public function createGameFromArray(array $frames): Game
    {
        $game = new Game();
        foreach ($frames as $frame) {
            $game->roll(RollResult::create($frame{0}));

            if (strlen($frame) > 1) {
                $game->roll(RollResult::create($frame{1}));
            }
        }

        return $game;
    }

}
