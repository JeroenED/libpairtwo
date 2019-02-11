<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 11/02/19
 * Time: 14:48
 */

namespace JeroenED\Libpairtwo\Models;

use JeroenED\LibPairtwo\Enums\Color;
use JeroenED\Libpairtwo\Enums\Result;
use JeroenED\LibPairtwo\Player;

class Pairing
{
    private $Player;
    private $Opponent;
    private $Color;
    private $Result;
    private $Round;

    /**
     * @return Player
     */
    public function getPlayer()
    {
        return $this->Player;
    }

    /**
     * @param Player $Player
     */
    public function setPlayer(Player $Player): void
    {
        $this->Player = $Player;
    }

    /**
     * @return Player
     */
    public function getOpponent()
    {
        return $this->Opponent;
    }

    /**
     * @param Player $Opponent
     */
    public function setOpponent(Player $Opponent): void
    {
        $this->Opponent = $Opponent;
    }

    /**
     * @return Color
     */
    public function getColor(): Color
    {
        return $this->Color;
    }

    /**
     * @param Color $Color
     */
    public function setColor(Color $Color): void
    {
        $this->Color = $Color;
    }

    /**
     * @return Result
     */
    public function getResult(): Result
    {
        return $this->Result;
    }

    /**
     * @param Result $Result
     */
    public function setResult(Result $Result): void
    {
        $this->Result = $Result;
    }

    /**
     * @return int
     */
    public function getRound(): int
    {
        return $this->Round;
    }

    /**
     * @param int $Round
     */
    public function setRound(int $Round): void
    {
        $this->Round = $Round;
    }
}
