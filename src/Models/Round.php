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
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     * @return Round
     */
    public function setDate(DateTime $date): Round
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return Game[]
     */
    public function getGames(): array
    {
        return $this->games;
    }

    /**
     * @param Game[] $games
     * @return Round
     */
    public function setGames(array $games): Round
    {
        $this->games = $games;
        return $this;
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
     * @return Round
     */
    public function setRoundNo(int $roundNo): Round
    {
        $this->roundNo = $roundNo;
        return $this;
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
     * @return Round
     */
    public function setPairings(array $pairings): Round
    {
        $this->pairings = $pairings;
        return $this;
    }
}
