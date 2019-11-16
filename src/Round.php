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
    public $Date;

    /**
     * Array of all games
     *
     * @var Game[]
     */
    public $Games = [];

    /**
     * Number of the round
     *
     * @var int
     */
    public $RoundNo;

    /**
     * Array of all pairings for this round
     *
     * @var Pairing[]
     */
    public $Pairings = [];

    /*
     * Adds a game to the round
     *
     * @param Game $game
     */
    public function addGame(Game $game): void
    {
        $newarray = $this->Games;
        $newarray[] = $game;
        $this->Games = $newarray;
    }

    /**
     * Adds a pairing to the round
     *
     * @param Pairing $pairing
     */
    public function addPairing(Pairing $pairing): void
    {
        $newarray = $this->Pairings;
        $newarray[] = $pairing;
        $this->Pairings = $newarray;
    }

    /**
     * Returns an array of pairings where the player is bye
     *
     * @return Pairing[]
     */
    public function getBye(): array
    {
        $allPairings = $this->Pairings;
        $byePairings = [];
        foreach ($allPairings as $pairing) {
            if ($pairing->Result == Result::WonBye) {
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
        $allPairings = $this->Pairings;
        $absentPairings = [];
        foreach ($allPairings as $pairing) {
            if ($pairing->Result == Result::Absent) {
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
        $allGames = $this->Games;
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
        if (($a->Board == $b->Board) || ($a->Board === false) || ($b->Board === false)) {
            return 0;
        }
        return ($a->Board > $b->Board) ? +1 : -1;
    }
}
