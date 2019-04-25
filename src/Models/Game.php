<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 1/02/19
 * Time: 17:16
 */

namespace JeroenED\Libpairtwo\Models;

use JeroenED\Libpairtwo\Enums\Gameresult;
use JeroenED\Libpairtwo\Pairing;

class Game
{
    /** @var Pairing */
    private $white;

    /** @var Pairing */
    private $black;

    /** @var GameResult */
    private $result;

    /**
     * @return Pairing
     */
    public function getWhite()
    {
        return $this->white;
    }

    /**
     * @param Pairing $white
     */
    public function setWhite($white): void
    {
        $this->white = $white;
    }

    /**
     * @return Pairing
     */
    public function getBlack()
    {
        return $this->black;
    }

    /**
     * @param Pairing $black
     */
    public function setBlack($black): void
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
