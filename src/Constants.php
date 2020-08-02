<?php

/**
 * Class Constants
 *
 * Static class for constants
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
 * Class Constants
 *
 * Static class for constants
 *
 * @author    Jeroen De Meerleer <schaak@jeroened.be>
 * @category  Main
 * @package   Libpairtwo
 * @copyright Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */
class Constants
{
    public const WON = [Result::WON, Result::WON_FORFAIT, Result::WON_BYE, Result::WON_ADJOURNED];

    public const DRAW = [Result::DRAW, Result::DRAW_ADJOURNED];

    public const LOST = [Result::ABSENT, Result::BYE, Result::LOST, Result::ADJOURNED];

    public const NOTPLAYED = [Result::BYE, Result::WON_BYE, Result::ABSENT];

    public const PLAYED = [
        Result::WON,
        Result::WON_FORFAIT,
        Result::WON_BYE,
        Result::WON_ADJOURNED,
        Result::DRAW,
        Result::DRAW_ADJOURNED,
        Result::ABSENT,
        Result::BYE,
        Result::LOST,
        Result::ADJOURNED
    ];

    public const BLACK = [Color::BLACK];

    public const WHITE = [Color::WHITE];
}
