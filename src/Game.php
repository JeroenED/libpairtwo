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

use DateTime;
use JeroenED\Libpairtwo\Enums\Gameresult;
use JeroenED\Libpairtwo\Models\Round;
use JeroenED\Libpairtwo\Pairing;

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
    /** @var Pairing|null */
    private $white;

    /** @var Pairing|null */
    private $black;

    /** @var GameResult|null */
    private $result;

    /**
     * This function gets the result from the game
     *
     * @return Gameresult
     */
    public function getResult(): Gameresult
    {
        if (!is_null(parent::getResult())) {
            return parent::getResult();
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
     * Gets pairing for white player
     *
     * @return Pairing|null
     */
    public function getWhite(): ?Pairing
    {
        return $this->white;
    }

    /**
     * Sets pairing for white player
     *
     * @param Pairing|null $white
     * @return Game
     */
    public function setWhite(?Pairing $white): Game
    {
        $this->white = $white;
        return $this;
    }

    /**
     * Gets pairing for black player
     *
     * @return Pairing|null
     */
    public function getBlack(): ?Pairing
    {
        return $this->black;
    }

    /**
     * Sets pairing for black player
     *
     * @param Pairing|null $black
     * @return Game
     */
    public function setBlack(?Pairing $black): Game
    {
        $this->black = $black;
        return $this;
    }

    /**
     * Sets result for game
     *
     * @param Gameresult|null $result
     * @return Game
     */
    public function setResult(?Gameresult $result): Game
    {
        $this->result = $result;
        return $this;
    }

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
