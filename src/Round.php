<?php
/**
 * Class Round
 *
 * Class for a round of the tournament
 *
 * @author      Jeroen De Meerleer <schaak@jeroened.be>
 * @category    Main
 * @package     Libpairtwo
 * @copyright   Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */

namespace JeroenED\Libpairtwo;

use DateTime;
use JeroenED\Libpairtwo\Enums\Result;

/**
 * Class Round
 *
 * Class for a round of the tournament
 *
 * @author      Jeroen De Meerleer <schaak@jeroened.be>
 * @category    Main
 * @package     Libpairtwo
 * @copyright   Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */
class Round
{
    /**
     * Date of the round
     *
     * @var DateTime
     */
    private $date;

    /**
     * Array of all games
     *
     * @var Game[]
     */
    private $games = [];

    /**
     * Number of the round
     *
     * @var int
     */
    private $roundNo;

    /**
     * Array of all pairings for this round
     *
     * @var Pairing[]
     */
    private $pairings = [];

    /**
     * Adds a game to the round
     *
     * @param Game $game
     * @return Round
     */
    public function addGame(Game $game): Round
    {
        $newarray = $this->getGames();
        $newarray[] = $game;
        $this->setGames($newarray);
        return $this;
    }

    /**
     * Adds a pairing to the round
     *
     * @param Pairing $pairing
     * @return Round
     */
    public function addPairing(Pairing $pairing): Round
    {
        $newarray = $this->getPairings();
        $newarray[] = $pairing;
        $this->setPairings($newarray);
        return $this;
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

    /**
     * Returns the date of the round
     *
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }
    /**
     * Sets the date of the round
     *
     * @param DateTime $date
     * @return Round
     */
    public function setDate(DateTime $date): Round
    {
        $this->date = $date;
        return $this;
    }
    /**
     * Returns an array of all games for the round
     *
     * @return Game[]
     */
    public function getGames(): array
    {
        return $this->games;
    }
    /**
     * Sets an array of all games for the round
     *
     * @param Game[] $games
     * @return Round
     */
    public function setGames(array $games): Round
    {
        $this->games = $games;
        return $this;
    }
    /**
     * Returns the round number of the round
     *
     * @return int
     */
    public function getRoundNo(): int
    {
        return $this->roundNo;
    }
    /**
     * Sets the round number of the round
     *
     * @param int $roundNo
     * @return Round
     */
    public function setRoundNo(int $roundNo): Round
    {
        $this->roundNo = $roundNo;
        return $this;
    }
    /**
     * Returns an array of all pairings for the round
     *
     * @return Pairing[]
     */
    public function getPairings(): array
    {
        return $this->pairings;
    }
    /**
     * Sets an array of all pairings for the round
     *
     * @param Pairing[] $pairings
     * @return Round
     */
    public function setPairings(array $pairings): Round
    {
        $this->pairings = $pairings;
        return $this;
    }
}
