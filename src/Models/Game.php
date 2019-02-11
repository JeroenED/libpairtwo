<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 1/02/19
 * Time: 17:16
 */

namespace JeroenED\Libpairtwo\Models;

use JeroenED\Libpairtwo\Enums\Gameresult;
use JeroenED\LibPairtwo\Player;

class Game
{
    /** @var Player */
    private $white;

    /** @var Player */
    private $black;

    /** @var GameResult */
    private $result;

    /**
     * @return Player
     */
    public function getWhite()
    {
        return $this->white;
    }

    /**
     * @param Player $white
     */
    public function setWhite(Player $white): void
    {
        $this->white = $white;
    }

    /**
     * @return Player
     */
    public function getBlack()
    {
        return $this->black;
    }

    /**
     * @param Player $black
     */
    public function setBlack(Player $black): void
    {
        $this->black = $black;
    }

    /**
     * @return GameResult
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param GameResult $result
     */
    public function setResult(GameResult $result): void
    {
        $this->result = $result;
    }




}
