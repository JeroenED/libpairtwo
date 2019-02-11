<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 1/02/19
 * Time: 11:18
 */

namespace JeroenED\Libpairtwo;

use JeroenED\Libpairtwo\Models\Tournament as TournamentModel;
use JeroenED\LibPairtwo\Player;

class Tournament extends TournamentModel
{
    /**
     * @param integer $id
     * @return Player
     */
    public function getPlayerById(int $id)
    {
        return $this->GetPlayers()[$id];
    }

    /**
     * @param Player $Player
     */
    public function addPlayer(Player $Player)
    {
        $newArray = $this->GetPlayers();
        $newArray[] = $Player;
        $this->setPlayers($newArray);
    }

    /**
     * @param int $id
     * @param Player $player
     */
    public function updatePlayer(int $id, Player $player)
    {
        $newArray = $this->GetPlayers();
        $newArray[$id] = $player;
        $this->setPlayers($newArray);
    }

    /**
     * @param Round $round
     */
    public function addRound(Round $round)
    {
        $newArray = $this->GetRounds();
        $newArray[] = $round;
        $this->setRounds($newArray);
    }

    /**
     * @param Pairing $pairing
     */
    public function addPairing(Pairing $pairing)
    {
        $newArray = $this->GetPairings();
        $newArray[] = $pairing;
        $this->setPairings($newArray);
    }

    /**
     * @param bool $americansort
     * @return Player[]
     */
    public function getRanking(bool $americansort = false)
    {
        $players = $this->getPlayers();

        $americansort ? usort($players, array($this, "SortAmerican")) : usort($players, array($this, "SortNormal"));

        return $players;
    }

    /**
     * @param Player $a
     * @param Player $b
     * @return int
     */
    private function sortNormal(Player $a, Player $b)
    {
        return $b->getPoints() - $a->getPoints();
    }

    /**
     * @param Player $a
     * @param Player $b
     * @return int
     */
    private function sortAmerican(Player $a, Player $b)
    {
        return $b->getScoreAmerican() - $a->getScoreAmerican();
    }
}
