<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 1/02/19
 * Time: 17:16
 */

namespace JeroenED\Libpairtwo;

use JeroenED\Libpairtwo\Enums\Result;
use JeroenED\Libpairtwo\Models\Round as RoundModel;
use JeroenED\Libpairtwo\Game;
use JeroenED\Libpairtwo\Pairing;

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

    /**
     * Adds a pairing to the round
     *
     * @param Pairing $pairing
     */
    public function addPairing(Pairing $pairing)
    {
        $newarray = $this->getPairings();
        $newarray[] = $pairing;
        $this->setPairings($newarray);
    }


    /**
     * Returns an array of pairings where the player is bye
     *
     * @return Pairing[]
     */
    public function getBye(): array
    {
        $allPairings = $this->getPairings();
        $byePairings = [];
        foreach ($allPairings as $pairing) {
            if ($pairing->getResult() == Result::wonbye) {
                $byePairings[] = $pairing;
            }
        }
        return $byePairings;
    }


    /**
     * Returns an array of pairings where the player is absent
     *
     * @return Pairing[]
     */
    public function getAbsent(): array
    {
        $allPairings = $this->getPairings();
        $absentPairings = [];
        foreach ($allPairings as $pairing) {
            if ($pairing->getResult() == Result::absent) {
                $absentPairings[] = $pairing;
            }
        }
        return $absentPairings;
    }
}
