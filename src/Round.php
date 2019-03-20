<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 1/02/19
 * Time: 17:16
 */

namespace JeroenED\Libpairtwo;

use JeroenED\Libpairtwo\Models\Round as RoundModel;

class Round extends RoundModel
{
    /**
     * Adds a game to the round
     *
     * @param Game $game
     */
    public function addGame(Game $game)
    {
        $newarray = $this->getGames();
        $newarray[] = $game;
        $this->setGames($newarray);

    }
}
