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
    public $White;

    /** @var Pairing | null */
    public $Black;

    /** @var GameResult | null */
    private $CalculatedResult;

    /** @var int */
    public $Board;

    public function __get(string $key)
    {
        if ($key == 'Result') {
            return $this->calculateResult();
        }
    }

    /**
     * Returns the result for the game
     *
     * @return Gameresult
     */
    private function calculateResult(): Gameresult
    {
        if (!is_null($this->CalculatedResult)) {
            return $this->CalculatedResult;
        }

        $whiteResult = $this->White->Result;
        $blackResult = $this->Black->Result;

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
        $this->CalculatedResult = $result;

        return $result;
    }

    /**
     * Checks if 2 games are equal
     *
     * @param Game $game1
     * @param Game $game2
     * @return bool
     */
    public function equals(Game $game): bool
    {
        return (
            $this->White->Player === $game->White->Player &&
            $this->Black->Player === $game->Black->Player &&
            $this->Result == $game->Result);
    }
}
