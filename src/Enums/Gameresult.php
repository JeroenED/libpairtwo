<?php

/**
 * Enum Gameresult
 *
 * List of all compatible gameresults
 *
 * @author    Jeroen De Meerleer <schaak@jeroened.be>
 * @category  Main
 * @package   Libpairtwo
 * @copyright Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */

namespace JeroenED\Libpairtwo\Enums;

use MyCLabs\Enum\Enum;

/**
 * Enum Gameresult
 *
 * List of all compatible gameresults
 *
 * @author    Jeroen De Meerleer <schaak@jeroened.be>
 * @category  Main
 * @package   Libpairtwo
 * @copyright Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */
class Gameresult extends Enum
{
    public const BLACK_WINS = '0-1';

    public const BLACK_WINS_FORFAIT = '0-1 FF';

    public const BOTH_LOSE_FORFAIT = '0-0 FF';

    public const BOTH_WIN_ADJOURNED = '1-1 A';

    public const DRAW = '0.5-0.5';

    public const DRAW_ADJOURNED = '0.5-0.5 A';

    public const NONE = '-';

    public const WHITE_DRAWS_BLACK_LOSE_ADJOURNED = '0.5-0';

    public const WHITE_DRAWS_BLACK_WINS_ADJOURNED = '0.5-1 A';

    public const WHITE_LOST_BLACK_DRAWS_ADJOURNED = '0-0.5';

    public const WHITE_WINS = '1-0';

    public const WHITE_WINS_BLACK_DRAWS_ADJOURNED = '1-0.5 A';

    public const WHITE_WINS_FORFAIT = '1-0 FF';
}
