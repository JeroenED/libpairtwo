<?php

/**
 * Class Player
 *
 * Class for a player of the tournament
 *
 * @author    Jeroen De Meerleer <schaak@jeroened.be>
 * @category  Main
 * @package   Libpairtwo
 * @copyright Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */

namespace JeroenED\Libpairtwo;

use DateTime;
use JeroenED\Libpairtwo\Enums\Gender;
use JeroenED\Libpairtwo\Enums\Title;

/**
 * Class Player
 *
 * Class for a player of the tournament
 *
 * @author    Jeroen De Meerleer <schaak@jeroened.be>
 * @category  Main
 * @package   Libpairtwo
 * @copyright Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */
class Player
{
    /**
     * Binary data that was read out of the pairing file
     *
     * @var bool|DateTime|int|string[]
     */

    private $BinaryData;

    /**
     * The category the player belongs to
     *
     * @var string
     */
    public $Category;

    /**
     * Birthday of the player
     *
     * @var DateTime
     */
    public $DateOfBirth;

    /**
     * The Elos for the player. Possible keys are, but not limited to nation and fide
     *
     * @var int[]
     */
    public $Elos;

    /**
     * The gender of the player. Possible values contain Male, Female and Neutral
     *
     * @var Gender
     */
    public $Gender;

    /**
     * The player ids for the player. Possible keys are, but not limited to nation and fide
     *
     * @var int[]
     */
    public $Ids;

    // TODO: Implement categories

    /**
     * Name of the player
     *
     * @var string
     */
    public $Name;

    /**
     * The nation the player belongs to. Be noted this does not actually mean this is his main nationality. A player
     * can be signed USCF but may be Italian
     *
     * @var string
     */
    public $Nation;

    /**
     * The pairings of the player
     *
     * @var Pairing[]
     */
    public $Pairings = [];

    /**
     * Tiebreak points of the player. These values are calculated when Tournament->Ranking is called
     *
     * @var float[]
     */
    public $Tiebreaks = [];

    /**
     * The title of the player. Possible values can be GM, IM, IA, etc.
     *
     * @var Title
     */
    public $Title;

    /**
     * Returns the performance rating of the player
     *
     * WARNING: Calculation currently incorrect. Uses the rule of 400 as temporary solution
     *
     * @param  $type
     * @param  $unratedElo
     *
     * @return float
     */
    public function Performance(string $type, int $unratedElo): float
    {
        $total = 0;
        $opponents = 0;
        foreach ($this->Pairings as $pairing) {
            if (array_search($pairing->Result, Constants::NOTPLAYED) === false) {
                $opponentElo = $pairing->Opponent->getElo($type);
                $opponentElo = $opponentElo != 0 ? $opponentElo : $unratedElo;
                if (array_search($pairing->Result, Constants::WON) !== false) {
                    $total += $opponentElo + 400;
                } elseif (array_search($pairing->Result, Constants::LOST) !== false) {
                    $total += $opponentElo - 400;
                } elseif (array_search($pairing->Result, Constants::DRAW) !== false) {
                    $total += $opponentElo;
                }
                $opponents++;
            }
        }

        return round($total / $opponents);
    }

    /**
     * Returns an array of Player objects where name matches $search
     *
     * @param string     $search
     * @param Tournament $tournament
     *
     * @return Player[]
     */
    public static function PlayersByName(string $search, Tournament $tournament): array
    {
        /**
         * @var Player[]
         */
        $players = $tournament->Players;

        /**
         * @var Player[]
         */
        $return = [];

        foreach ($players as $player) {
            if (fnmatch($search, $player->Name)) {
                $return[] = $player;
            }
        }

        return $return;
    }

    /**
     * Magic method to read out several fields. If field was not found it is being searched in the binary data fields
     *
     * @param string $key
     *
     * @return bool|DateTime|int|string|null
     */
    public function __get(string $key)
    {
        if ($key == 'PlayedGames') {
            return $this->playedGames();
        } elseif ($key == 'NoOfWins') {
            return $this->noOfWins();
        } elseif ($key == 'Opponents') {
            return $this->opponents();
        } elseif (isset($this->BinaryData[ $key ])) {
            return $this->BinaryData[ $key ];
        }

        return null;
    }

    /**
     * Sets binary data that is read out the pairing file but is not needed immediately
     *
     * @param string                   $key
     * @param bool|int|DateTime|string $value
     */
    public function __set(string $key, $value): void
    {
        $this->BinaryData[ $key ] = $value;
    }

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
     * Returns the points of the player after round $round
     *
     * 1 Point is awarded for winning
     * 0.5 points are awarded for draw
     * 0 points are awarded for loss
     *
     * @param int $round
     *
     * @return float
     */
    public function calculatePoints(int $round = -1): float
    {
        $points = 0;
        foreach ($this->Pairings as $key => $pairing) {
            if ($key < $round || $round == -1) {
                if (array_search($pairing->Result, Constants::WON) !== false) {
                    $points = $points + 1;
                } elseif (array_search($pairing->Result, Constants::DRAW) !== false) {
                    $points = $points + 0.5;
                }
            }
        }

        return $points;
    }

    /**
     * Returns the points of the player that should be used for tiebreaking systems.
     *
     * 1 Point is awarded for winning
     * 0.5 points are awarded for draw
     * 0.5 points for not played
     *
     * @return float
     */
    public function calculatePointsForTiebreaks(): float
    {
        $points = 0;
        foreach ($this->Pairings as $pairing) {
            if (array_search($pairing->Result, Constants::NOTPLAYED) !== false) {
                $points = $points + 0.5;
            } elseif (array_search($pairing->Result, Constants::WON) !== false) {
                $points = $points + 1;
            } elseif (array_search($pairing->Result, Constants::DRAW) !== false) {
                $points = $points + 0.5;
            }
        }

        return $points;
    }

    /**
     * Returns the points of a virtual player as described in the Fide Handbook C.02 chapter 13.15.2.
     *
     * Return the same score for all rounds until $byeround and added with a half point for each subsequent round
     *
     * @param int $byeround
     *
     * @return float
     */
    public function calculatePointsForVirtualPlayer(int $byeround): float
    {
        $points = $this->calculatePoints($byeround);
        foreach (array_slice($this->Pairings, $byeround + 1) as $key => $pairing) {
            $points += 0.5;
        }

        return $points;
    }

    /**
     * Returns the elo of elotype for the player
     *
     * @param string $type
     *
     * @return int
     */
    public function getElo(string $type): int
    {
        return $this->Elos[ $type ];
    }

    /**
     * Returns the identifier of type for the player
     *
     * Common possible values are Fide or National
     *
     * @param string $type
     *
     * @return string
     */
    public function getId(string $type): string
    {
        return $this->Ids[ $type ];
    }

    /**
     * Returns if player has played against all players of the array
     *
     * @param Player[] $players
     *
     * @return bool
     */
    public function hasPlayedAllPlayersOfArray(array $players): bool
    {
        $ownkey = array_search($this, $players);
        if ($ownkey !== false) {
            unset($players[ $ownkey ]);
        }
        $total = 0;
        foreach ($players as $player) {
            if (array_search($player, $this->Opponents) !== false) {
                $total++;
            }
        }

        return $total == count($players);
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
            if (array_search($pairing->Result, Constants::WON) !== false) {
                $wins++;
            }
        }

        return $wins;
    }

    /**
     * Returns all opponents of $this
     *
     * @return Player[]
     */
    private function opponents()
    {
        $return = [];
        foreach ($this->Pairings as $pairing) {
            if (!empty($pairing->Opponent)) {
                $return[] = $pairing->Opponent;
            }
        }

        return $return;
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
            if (array_search($pairing->Result, Constants::PLAYED) !== false) {
                $total++;
            }
        }

        return $total;
    }

    /**
     * Sets the elo of elotype for the player
     *
     * @param string $type
     * @param int    $value
     */
    public function setElo(string $type, int $value): void
    {
        $currentElos = $this->Elos;
        $currentElos[ $type ] = $value;
        $this->Elos = $currentElos;
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
        $currentIds[ $type ] = $value;
        $this->Ids = $currentIds;
    }
}
