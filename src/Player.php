<?php
/**
 * Class Player
 *
 * Class for a player of the tournament
 *
 * @author      Jeroen De Meerleer <schaak@jeroened.be>
 * @category    Main
 * @package     Libpairtwo
 * @copyright   Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */

namespace JeroenED\Libpairtwo;

use JeroenED\Libpairtwo\Enums\Gender;
use JeroenED\Libpairtwo\Enums\Title;
use DateTime;

/**
 * Class Player
 *
 * Class for a player of the tournament
 *
 * @author      Jeroen De Meerleer <schaak@jeroened.be>
 * @category    Main
 * @package     Libpairtwo
 * @copyright   Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */
class Player
{
    /** @var string */
    public $Name;

    /** @var int[] */
    public $Ids;

    /** @var int[] */
    public $Elos;

    /** @var DateTime */
    public $DateOfBirth;

    /** @var float[] */
    public $Tiebreaks = [];

    /** @var string */
    public $Nation;

    // TODO: Implement categories
    /** @var string */
    public $Category;

    /** @var Title */
    public $Title;

    /** @var Gender */
    public $Gender;

    /** @var Pairing[] */
    public $Pairings = [];

    /** @var bool|DateTime|int|string[] */
    private $BinaryData;

    /**
     * Adds a pairing to the tournament
     *
     * @param Pairing $pairing
     */
    public function addPairing(Pairing $pairing): void
    {
        $newArray = $this->Pairings;
        $newArray[] = $pairing;
        $this->Pairings = $newArray;
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
        $players = $tournament->Players;

        /** @var Player[] */
        $return = [];

        foreach ($players as $player) {
            if (fnmatch($search, $player->Name)) {
                $return[] = $player;
            }
        }

        return $return;
    }

    /**
     * Returns the elo of elotype for the player
     * @param string $type
     * @return int
     */
    public function getElo(string $type): int
    {
        return $this->Elos[$type];
    }

    /**
     * Sets the elo of elotype for the player
     *
     * @param string $type
     * @param int $value
     */
    public function setElo(string $type, int $value): void
    {
        $currentElos = $this->Elos;
        $currentElos[$type] = $value;
        $this->Elos = $currentElos;
    }

    /**
     * Returns the identifier of type for the player
     *
     * Common possible values are Fide or National
     *
     * @param string $type
     * @return string
     */
    public function getId(string $type): string
    {
        return $this->Ids[$type];
    }

    /**
     * Sets the identifier of type for the player
     *
     * Common possible values are Fide or National
     *
     * @param string $type
     * @param string $value
     */
    public function setId(string $type, string $value): void
    {
        $currentIds = $this->Ids;
        $currentIds[$type] = $value;
        $this->Ids = $currentIds;
    }

    /**
     * Returns the number of won matches for the player
     *
     * @return int
     */
    public function getNoOfWins(): int
    {
        $wins = 0;
        foreach ($this->Pairings as $pairing) {
            if (array_search($pairing->Result, Constants::Won) !== false) {
                $wins++;
            }
        }
        return $wins;
    }

    /**
     * Returns the points of the player.
     *
     * 1 Point is awarded for winning
     * 0.5 points are awarded for draw
     *
     * @return float
     */
    public function calculatePoints(): float
    {
        $points = 0;
        foreach ($this->Pairings as $pairing) {
            if (array_search($pairing->Result, Constants::Won) !== false) {
                $points = $points + 1;
            } elseif (array_search($pairing->Result, Constants::Draw) !== false) {
                $points = $points + 0.5;
            }
        }
        return $points;
    }

    /**
     * Returns the points of the player that should be used for buchholz.
     *
     * 1 Point is awarded for winning
     * 0.5 points are awarded for draw
     * 0.5 points for not played
     *
     * @return float
     */
    public function getPointsForBuchholz(): float
    {
        $points = 0;
        foreach ($this->Pairings as $pairing) {
            if (array_search($pairing->Result, Constants::NotPlayed) !== false) {
                $points = $points + 0.5;
            } elseif (array_search($pairing->Result, Constants::Won) !== false) {
                $points = $points + 1;
            } elseif (array_search($pairing->Result, Constants::Draw) !== false) {
                $points = $points + 0.5;
            }
        }
        return $points;
    }
    /**
     * Returns the performance rating of the player
     *
     * WARNING: Calculation currently incorrect. Uses the rule of 400 as temporary solution
     *
     * @return int
     */
    public function getPerformance(string $type, int $unratedElo): float
    {
        $total = 0;
        $opponents = 0;
        foreach ($this->Pairings as $pairing) {
            if (array_search($pairing->Result, Constants::NotPlayed) === false) {
                $opponentElo = $pairing->Opponent->getElo($type);
                $opponentElo = $opponentElo != 0 ? $opponentElo : $unratedElo;
                if (array_search($pairing->Result, Constants::Won) !== false) {
                    $total += $opponentElo + 400;
                } elseif (array_search($pairing->Result, Constants::Lost) !== false) {
                    $total += $opponentElo - 400;
                } elseif (array_search($pairing->Result, Constants::Draw) !== false) {
                    $total += $opponentElo;
                }
                $opponents++;
            }
        }
        return round($total / $opponents);
    }


    /**
     * Returns the number of played games of the player
     *
     * @return int
     */
    public function getPlayedGames(): int
    {
        $total = 0;
        foreach ($this->Pairings as $pairing) {
            if (array_search($pairing->Result, Constants::Played) !== false) {
                $total++;
            }
        }
        return $total;
    }

    /**
     * Returns binary data that was read out the pairing file but was not needed immediately
     *
     * @param string $Key
     * @return bool|DateTime|int|string|null
     */
    public function __get(string $Key)
    {
        if (isset($this->BinaryData[$Key])) {
            return $this->BinaryData[$Key];
        }
        return null;
    }

    /**
     * Sets binary data that is read out the pairing file but is not needed immediately
     *
     * @param string $Key
     * @param bool|int|DateTime|string $Value
     */
    public function __set(string $Key, $Value): void
    {
        $this->BinaryData[$Key] = $Value;
    }
}
