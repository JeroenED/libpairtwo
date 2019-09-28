<?php
/**
 * Class Games
 *
 * Class for a game of the tournament
 *
 * @author      Jeroen De Meerleer <schaak@jeroened.be>
 * @category    Main
 * @package     Libpairtwo
 * @copyright   Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */

namespace JeroenED\Libpairtwo;

use JeroenED\Libpairtwo\Enums\Gameresult;
use JeroenED\Libpairtwo\Pairing;
use DateTime;

/**
 * Class Games
 *
 * Class for a game of the tournament
 *
 * @author      Jeroen De Meerleer <schaak@jeroened.be>
 * @category    Main
 * @package     Libpairtwo
 * @copyright   Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */
class Game
{
    /** @var Pairing | null */
    private $White;

    /** @var Pairing | null */
    private $Black;

    /** @var GameResult | null */
    private $Result;

    /** @var int */
    private $Board;

    /**
     * Returns the result for the game
     *
     * @return Gameresult
     */
    public function getResult(): Gameresult
    {
        if (!is_null($this->Result)) {
            return $this->Result;
        }

        $whiteResult = $this->getWhite()->getResult();
        $blackResult = $this->getBlack()->getResult();

        $whitesplit = explode(" ", $whiteResult);
        $blacksplit = explode(" ", $blackResult);

        $special='';
        if (isset($whitesplit[1]) && $whitesplit[1] != 'Bye') {
            $special = ' ' . $whitesplit[1];
        }
        if (isset($blacksplit[1]) && $blacksplit[1] != 'Bye') {
            $special = ' ' . $blacksplit[1];
        }
        if ($whitesplit[0] == '*') {
            $whitesplit[0] = '';
        }
        if ($blacksplit[0] == '*') {
            $blacksplit[0] = '';
        }
        $result = new Gameresult($whitesplit[0] . '-' . $blacksplit[0] . $special);
        $this->setResult($result);

        return $result;
    }

    /**
     * Returns the pairing for white player
     *
     * @return Pairing | null
     */
    public function getWhite(): ?Pairing
    {
        return $this->White;
    }

    /**
     * Sets pairing for white player
     *
     * @param Pairing | null $White
     * @return Game
     */
    public function setWhite(?Pairing $White): Game
    {
        $this->White = $White;
        return $this;
    }

    /**
     * Returns the pairing for black player
     *
     * @return Pairing | null
     */
    public function getBlack(): ?Pairing
    {
        return $this->Black;
    }

    /**
     * Sets pairing for black player
     *
     * @param Pairing | null $Black
     * @return Game
     */
    public function setBlack(?Pairing $Black): Game
    {
        $this->Black = $Black;
        return $this;
    }

    /**
     * Sets result for game
     *
     * @param Gameresult | null $Result
     * @return Game
     */
    public function setResult(?Gameresult $Result): Game
    {
        $this->Result = $Result;
        return $this;
    }

    /**
     * Sets the board no of the game
     *
     * @return int
     */
    public function getBoard(): int
    {
        return $this->Board;
    }

    /**
     * Returns the board no of the game
     *
     * @param int $Board
     */
    public function setBoard(int $Board): void
    {
        $this->Board = $Board;
    }
}
