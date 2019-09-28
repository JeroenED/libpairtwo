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
    private $Date;

    /**
     * Array of all games
     *
     * @var Game[]
     */
    private $Games = [];

    /**
     * Number of the round
     *
     * @var int
     */
    private $RoundNo;

    /**
     * Array of all pairings for this round
     *
     * @var Pairing[]
     */
    private $Pairings = [];

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
            if ($pairing->getResult() == Result::WonBye) {
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
            if ($pairing->getResult() == Result::Absent) {
                $absentPairings[] = $pairing;
            }
        }
        return $absentPairings;
    }

    /**
     * Retuns an array with the games of this round sorted by board
     *
     * @return Game[]
     */
    public function getGamesByBoard(): array
    {
        $allGames = $this->getGames();
        usort($allGames, array($this, 'sortByBoard'));
        return $allGames;
    }

    /**
     * Sort by board
     *
     * @param Game $a
     * @param Game $b
     * @return int
     */
    private function sortByBoard(Game $a, Game $b): int
    {
        if (($a->getBoard() == $b->getBoard()) || ($a->getBoard() === false) || ($b->getBoard() === false)) {
            return 0;
        }
        return ($a->getBoard() > $b->getBoard()) ? +1 : -1;
    }

    /**
     * Returns the date of the round
     *
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->Date;
    }
    /**
     * Sets the date of the round
     *
     * @param DateTime $Date
     * @return Round
     */
    public function setDate(DateTime $Date): Round
    {
        $this->Date = $Date;
        return $this;
    }

    /**
     * Returns an array of all games for the round
     *
     * @return Game[]
     */
    public function getGames(): array
    {
        return $this->Games;
    }

    /**
     * Sets an array of all games for the round
     *
     * @param Game[] $Games
     * @return Round
     */
    public function setGames(array $Games): Round
    {
        $this->Games = $Games;
        return $this;
    }

    /**
     * Returns the round number of the round
     *
     * @return int
     */
    public function getRoundNo(): int
    {
        return $this->RoundNo;
    }

    /**
     * Sets the round number of the round
     *
     * @param int $RoundNo
     * @return Round
     */
    public function setRoundNo(int $RoundNo): Round
    {
        $this->RoundNo = $RoundNo;
        return $this;
    }

    /**
     * Returns an array of all pairings for the round
     *
     * @return Pairing[]
     */
    public function getPairings(): array
    {
        return $this->Pairings;
    }

    /**
     * Sets an array of all pairings for the round
     *
     * @param Pairing[] $Pairings
     * @return Round
     */
    public function setPairings(array $Pairings): Round
    {
        $this->Pairings = $Pairings;
        return $this;
    }
}
