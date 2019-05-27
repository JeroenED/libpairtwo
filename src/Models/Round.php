<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 1/02/19
 * Time: 17:13
 */

namespace JeroenED\Libpairtwo\Models;

use DateTime;
use JeroenED\Libpairtwo\Game;
use JeroenED\Libpairtwo\Pairing;

abstract class Round
{
    /** @var DateTime */
    private $date;

    /** @var Game[] */
    private $games = [];

    /** @var int */
    private $roundNo;

    /** @var Pairing[] */
    private $pairings = [];

    /**
     * @return DateTime
     *
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return Game[]
     */
    public function getGames()
    {
        return $this->games;
    }

    /**
     * @param Game[] $games
     */
    public function setGames($games): void
    {
        $this->games = $games;
    }

    /**
     * @return int
     */
    public function getRoundNo(): int
    {
        return $this->roundNo;
    }

    /**
     * @param int $roundNo
     */
    public function setRoundNo(int $roundNo): void
    {
        $this->roundNo = $roundNo;
    }

    /**
     * @return Pairing[]
     */
    public function getPairings(): array
    {
        return $this->pairings;
    }

    /**
     * @param Pairing[] $pairings
     */
    public function setPairings(array $pairings): void
    {
        $this->pairings = $pairings;
    }
}
