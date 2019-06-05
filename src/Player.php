<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 1/02/19
 * Time: 11:26
 */

namespace JeroenED\Libpairtwo;

use JeroenED\Libpairtwo\Models\Player as PlayerModel;

/**
 * Class Player
 * @package JeroenED\Libpairtwo
 */
class Player extends PlayerModel
{
    
    /**
     * Adds a pairing to the tournament
     *
     * @param Pairing $pairing
     */
    public function addPairing(Pairing $pairing)
    {
        $newArray = $this->GetPairings();
        $newArray[] = $pairing;
        $this->setPairings($newArray);
    }

    /**
     * Returns an array of Player objects where name matches $search
     *
     * @param string $search
     * @param Tournament $tournament
     * @return Player[]
     */
    public static function getPlayersByName(string $search, Tournament $tournament): array
    {
        /** @var Player[] */
        $players = $tournament->getPlayers();

        /** @var Player[] */
        $return = [];

        foreach ($players as $player) {
            if (fnmatch($search, $player->getName())) {
                $return[] = $player;
            }
        }

        return $return;
    }

    /**
     * @param string $type
     * @return int
     */
    public function getElo(string $type): int
    {
        return $this->getElos()[$type];
    }

    /**
     * @param string $type
     * @param int $value
     * @return Player
     */
    public function setElo(string $type, int $value): Player
    {
        $currentElos = $this->getElos();
        $currentElos[$type] = $value;
        $this->setElos($currentElos);
        return $this;
    }

    /**
     * @param string $type
     * @return string
     */
    public function getId(string $type): string
    {
        return $this->getElos()[$type];
    }

    /**
     * @param string $type
     * @param string $value
     * @return Player
     */
    public function setId(string $type, string $value): Player
    {
        $currentIds = $this->getIds();
        $currentIds[$type] = $value;
        $this->setIds($currentIds);
        return $this;
    }

    /**
     * @return int
     */
    public function getNoOfWins()
    {
        $wins = 0;
        foreach ($this->getPairings() as $pairing) {
            if (array_search($pairing->getResult(), Constants::Won) !== false) {
                $wins++;
            }
        }
        return $wins;
    }

    /**
     * @return float
     */
    public function getPoints(): float
    {
        $points = 0;
        foreach ($this->getPairings() as $pairing) {
            if (array_search($pairing->getResult(), Constants::Won) !== false) {
                $points = $points + 1;
            } elseif (array_search($pairing->getResult(), Constants::Draw) !== false) {
                $points = $points + 0.5;
            }
        }
        return $points;
    }


    /**
     * @return int
     */
    public function getPerformance(string $type, int $unratedElo) : float
    {
        $total = 0;
        $opponents = 0;
        foreach ($this->getPairings() as $pairing) {
            if (array_search($pairing->getResult(), Constants::NotPlayed) === false) {
                $opponentElo = $pairing->getOpponent()->getElo($type);
                $opponentElo = $opponentElo != 0 ? $opponentElo : $unratedElo;
                if (array_search($pairing->getResult(), Constants::Won) !== false) {
                    $total += $opponentElo + 400;
                } elseif (array_search($pairing->getResult(), Constants::Lost) !== false) {
                    $total += $opponentElo - 400;
                } elseif (array_search($pairing->getResult(), Constants::Draw) !== false) {
                    $total += $opponentElo;
                }
                $opponents++;
            }
        }
        return round($total / $opponents);
    }


    /**
     * @return int
     */
    public function getPlayedGames(): int
    {
        $total = 0;
        foreach ($this->getPairings() as $pairing) {
            if (array_search($pairing->getResult(), Constants::Played) !== false) {
                $total++;
            }
        }
        return $total;
    }
}
