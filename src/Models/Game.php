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

abstract class Game
{
    /** @var Pairing|null */
    private $white;

    /** @var Pairing|null */
    private $black;

    /** @var GameResult */
    private $result;

    /**
     * @return Pairing|null
     */
    public function getWhite(): ?Pairing
    {
        return $this->white;
    }

    /**
     * @param Pairing|null $white
     * @return Game
     */
    public function setWhite(?Pairing $white): Game
    {
        $this->white = $white;
        return $this;
    }

    /**
     * @return Pairing|null
     */
    public function getBlack(): ?Pairing
    {
        return $this->black;
    }

    /**
     * @param Pairing|null $black
     * @return Game
     */
    public function setBlack(?Pairing $black): Game
    {
        $this->black = $black;
        return $this;
    }

    /**
     * @return Gameresult
     */
    public function getResult(): Gameresult
    {
        return $this->result;
    }

    /**
     * @param Gameresult $result
     * @return Game
     */
    public function setResult(Gameresult $result): Game
    {
        $this->result = $result;
        return $this;
    }


}
