<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 1/02/19
 * Time: 17:17
 */

namespace JeroenED\Libpairtwo;

use JeroenED\Libpairtwo\Enums\Gameresult;
use JeroenED\Libpairtwo\Models\Game as GameModel;

class Game extends GameModel
{
    /**
     * This function gets the result from the game
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
        $result = new Gameresult($whitesplit[0] . '-' . $blacksplit[0] . $special);
        $this->setResult($result);

        return $result;
    }
}
