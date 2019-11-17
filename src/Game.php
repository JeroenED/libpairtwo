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
    /**
     * The pairing for this games as seen from white's side
     *
     * @var Pairing | null
     */
    public $White;

    /**
     * The pairing for this games as seen from blacks's side
     *
     * @var Pairing | null
     */
    public $Black;

    /**
     * The calculated game result
     *
     * @var GameResult | null
     */
    private $CalculatedResult;

    /**
     * The board where this game is held
     *
     * @var int
     */
    public $Board;

    /**
     * Returns fields that were not directly assigned.
     * Class Game contains the special field Result containing the result of the game
     * @param string $key
     * @return Gameresult
     */
    public function __get(string $key)
    {
        if ($key == 'Result') {
            return $this->calculateResult();
        }
        return null;
    }

    /**
     * Returns the result for the game.
     * This method needs to be called from $Game->Result
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
     * @param Game $game
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
