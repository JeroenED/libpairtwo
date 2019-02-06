<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 1/02/19
 * Time: 17:13
 */

namespace JeroenED\Libpairtwo\Models;

class Round
{
    private $date;
    private $games;

    /**
     * @return \DateTime
     *
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
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
}
