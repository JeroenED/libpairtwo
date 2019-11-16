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
    public $Player;

    /** @var Player | null */
    public $Opponent;

    /** @var Color */
    public $Color;

    /** @var Result */
    public $Result;

    /** @var int */
    public $Round;

    /** @var int */
    public $Board;
}
