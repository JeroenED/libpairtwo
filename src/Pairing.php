<?php

/**
 * Class Pairing
 *
 * Class for a pairing of the tournament
 *
 * @author    Jeroen De Meerleer <schaak@jeroened.be>
 * @category  Main
 * @package   Libpairtwo
 * @copyright Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */

namespace JeroenED\Libpairtwo;

use JeroenED\Libpairtwo\Enums\Color;
use JeroenED\Libpairtwo\Enums\Result;

/**
 * Class Pairing
 *
 * Class for a pairing of the tournament
 *
 * @author    Jeroen De Meerleer <schaak@jeroened.be>
 * @category  Main
 * @package   Libpairtwo
 * @copyright Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */
class Pairing
{
    /**
     * The player of the pairing. Please note this means the pairing was seen from the point of view of this player
     *
     * @var Player | null
     */
    public $Player;

    /**
     * The opponent of player
     *
     * @var Player | null
     */
    public $Opponent;

    /**
     * The color of the player.
     * Possible values are Black and White
     *
     * @var Color
     */
    public $Color;

    /**
     * The result of the Game. Possible values contain Won, Lost, Draw, Forfait, Bye, etc.
     *
     * @var Result
     */
    public $Result;

    /**
     * The round of the game
     *
     * @var int
     */
    public $Round;

    /**
     * The number of the board where the game was held
     *
     * @var int
     */
    public $Board;
}
