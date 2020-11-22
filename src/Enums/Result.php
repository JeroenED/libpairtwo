<?php

/**
 * Enum Result
 *
 * List of all compatible results
 *
 * @author    Jeroen De Meerleer <schaak@jeroened.be>
 * @category  Main
 * @package   Libpairtwo
 * @copyright Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */

namespace JeroenED\Libpairtwo\Enums;

use MyCLabs\Enum\Enum;

/**
 * Enum Result
 *
 * List of all compatible results
 *
 * @author    Jeroen De Meerleer <schaak@jeroened.be>
 * @category  Main
 * @package   Libpairtwo
 * @copyright Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */
class Result extends Enum
{
    public const ABSENT = '0 FF';

    public const ADJOURNED = '0 A';

    public const BYE = '0 Bye';

    public const DRAW = '0.5';

    public const DRAW_ADJOURNED = '0.5 A';

    public const LOST = '0';

    public const NONE = '*';

    public const WON = '1';

    public const WON_ADJOURNED = '1 A';

    public const WON_BYE = '1 Bye';

    public const WON_FORFAIT = '1 FF';
}
