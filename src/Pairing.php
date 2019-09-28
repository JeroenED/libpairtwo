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
    /** @var Player | null */
    private $Player;

    /** @var Player | null */
    private $Opponent;

    /** @var Color */
    private $Color;

    /** @var Result */
    private $Result;

    /** @var int */
    private $Round;

    /** @var int */
    private $Board;

    /**
     * Returns the player of the pairing
     *
     * @return Player | null
     */
    public function getPlayer(): ?Player
    {
        return $this->Player;
    }

    /**
     * Sets the player of the pairing
     *
     * @param Player | null $Player
     * @return Pairing
     */
    public function setPlayer(?Player $Player): Pairing
    {
        $this->Player = $Player;
        return $this;
    }

    /**
     * Returns the opponent of the pairing
     *
     * @return Player | null
     */
    public function getOpponent(): ?Player
    {
        return $this->Opponent;
    }

    /**
     * Sets the opponent of the pairing
     *
     * @param Player | null $Opponent
     * @return Pairing
     */
    public function setOpponent(?Player $Opponent): Pairing
    {
        $this->Opponent = $Opponent;
        return $this;
    }

    /**
     * Returns the color of the pairing
     *
     * @return Color
     */
    public function getColor(): Color
    {
        return $this->Color;
    }

    /**
     * Sets the color of the pairing
     *
     * @param Color $Color
     * @return Pairing
     */
    public function setColor(Color $Color): Pairing
    {
        $this->Color = $Color;
        return $this;
    }

    /**
     * Returns the individual result of the pairing
     *
     * @return Result
     */
    public function getResult(): Result
    {
        return $this->Result;
    }

    /**
     * Sets the individual result of the pairing
     *
     * @param Result $Result
     * @return Pairing
     */
    public function setResult(Result $Result): Pairing
    {
        $this->Result = $Result;
        return $this;
    }

    /**
     * Returns the round number of the pairing
     *
     * @return int
     */
    public function getRound(): int
    {
        return $this->Round;
    }

    /**
     * Sets the round number of the pairing
     *
     * @param int $Round
     * @return Pairing
     */
    public function setRound(int $Round): Pairing
    {
        $this->Round = $Round;
        return $this;
    }

    /**
     * Sets the board no of the pairing
     *
     * @return int
     */
    public function getBoard(): int
    {
        return $this->Board;
    }

    /**
     * Returns the board no of the pairing
     *
     * @param int $Board
     */
    public function setBoard(int $Board): void
    {
        $this->Board = $Board;
    }
}
