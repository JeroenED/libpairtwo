<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 1/02/19
 * Time: 11:18
 */

namespace JeroenED\Libpairtwo;

use JeroenED\Libpairtwo\Models\Tournament as TournamentModel;
use phpDocumentor\Reflection\Types\Boolean;

class Tournament extends TournamentModel
{
    /**
     * @param Integer $id
     * @return Player
     */
    public function getPlayerById($id)
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
     * @param $id
     * @param Player $player
     */
    public function updatePlayer($id, Player $player)
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
     * @return array
     */
    public function getRanking(bool $sort)
    {
        $players = $this->getPlayers();

        $sort ? usort($players, array($this, "SortNormal")) : usort($players, array($this, "SortAmerican"));

        return $players;
    }

    /**
     * @param $a
     * @param $b
     * @return mixed
     */
    private function sortNormal($a, $b)
    {
        return $b->getPoints() - $a->getPoints();
    }

    /**
     * @param $a
     * @param $b
     * @return mixed
     */
    private function sortAmerican($a, $b)
    {
        return $b->getScoreAmerican() - $a->getScoreAmerican();
    }
}
