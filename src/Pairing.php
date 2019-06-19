<?php
/**
 * Class Pairing
 *
 * Class for a pairing of the tournament
 *
 * @author      Jeroen De Meerleer <schaak@jeroened.be>
 * @category    Main
 * @package     Libpairtwo
 * @copyright   Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */

namespace JeroenED\Libpairtwo;

use JeroenED\Libpairtwo\Enums\Color;
use JeroenED\Libpairtwo\Enums\Result;

/**
 * Class Pairing
 *
 * Class for a pairing of the tournament
 *
 * @author      Jeroen De Meerleer <schaak@jeroened.be>
 * @category    Main
 * @package     Libpairtwo
 * @copyright   Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */
class Pairing
{
    /** @var Player|null */
    private $Player;

    /** @var Player|null */
    private $Opponent;

    /** @var Color */
    private $Color;

    /** @var Result */
    private $Result;

    /** @var int */
    private $Round;

    /**
     * @return Player|null
     */
    public function getPlayer(): ?Player
    {
        return $this->Player;
    }

    /**
     * @param Player|null $Player
     * @return Pairing
     */
    public function setPlayer(?Player $Player): Pairing
    {
        $this->Player = $Player;
        return $this;
    }

    /**
     * @return Player|null
     */
    public function getOpponent(): ?Player
    {
        return $this->Opponent;
    }

    /**
     * @param Player|null $Opponent
     * @return Pairing
     */
    public function setOpponent(?Player $Opponent): Pairing
    {
        $this->Opponent = $Opponent;
        return $this;
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
     * @return Pairing
     */
    public function setColor(Color $Color): Pairing
    {
        $this->Color = $Color;
        return $this;
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
     * @return Pairing
     */
    public function setResult(Result $Result): Pairing
    {
        $this->Result = $Result;
        return $this;
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
     * @return Pairing
     */
    public function setRound(int $Round): Pairing
    {
        $this->Round = $Round;
        return $this;
    }
}
