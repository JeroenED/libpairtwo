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
    /**
     * Name of the player
     *
     * @var string
     */
    public $Name;

    /**
     * The player ids for the player. Possible keys are, but not limited to nation and fide
     *
     * @var int[]
     */
    public $Ids;

    /**
     * The Elos for the player. Possible keys are, but not limited to nation and fide
     *
     * @var int[]
     */
    public $Elos;

    /**
     * Birthday of the player
     *
     * @var DateTime
     */
    public $DateOfBirth;

    /**
     * Tiebreak points of the player. These values are calculated when Tournament->Ranking is called
     *
     * @var float[]
     */
    public $Tiebreaks = [];

    /**
     * The nation the player belongs to. Be noted this does not actually mean this is his main nationality. A player can be signed USCF but may be Italian
     *
     * @var string
     */
    public $Nation;

    // TODO: Implement categories
    /**
     * The category the player belongs to
     *
     * @var string
     */
    public $Category;

    /**
     * The title of the player. Possible values can be GM, IM, IA, etc.
     *
     * @var Title
     */
    public $Title;

    /**
     * The gender of the player. Possible values contain Male, Female and Neutral
     *
     * @var Gender
     */
    public $Gender;

    /**
     * The pairings of the player
     *
     * @var Pairing[]
     */
    public $Pairings = [];

    /**
     * Binary data that was read out of the pairing file
     *
     * @var bool|DateTime|int|string[]
     */

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
    public static function PlayersByName(string $search, Tournament $tournament): array
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
    private function noOfWins(): int
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
    private function pointsForBuchholz(): float
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
     * @param $type
     * @param $unratedElo
     * @return int
     */
    public function Performance(string $type, int $unratedElo): float
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
    private function playedGames(): int
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
     * Magic method to read out several fields. If field was not found it is being searched in the binary data fields
     *
     * @param string $key
     * @return bool|DateTime|int|string|null
     */
    public function __get(string $key)
    {
        if($key == 'PlayedGames') {
            return $this->playedGames();
        } elseif ($key == 'NoOfWins') {
            return $this->noOfWins();
        } elseif ($key == 'PointsForBuchholz') {
            return $this->pointsForBuchholz();
        } elseif (isset($this->BinaryData[$key])) {
            return $this->BinaryData[$key];
        }
        return null;
    }

    /**
     * Sets binary data that is read out the pairing file but is not needed immediately
     *
     * @param string $key
     * @param bool|int|DateTime|string $value
     */
    public function __set(string $key, $value): void
    {
        $this->BinaryData[$key] = $value;
    }
}
