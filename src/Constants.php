<?php
/**
 * Class Constants
 *
 * Static class for constants
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
 * Class Constants
 *
 * Static class for constants
 *
 * @author      Jeroen De Meerleer <schaak@jeroened.be>
 * @category    Main
 * @package     Libpairtwo
 * @copyright   Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */
class Constants
{
    const Won = [ Result::won, Result::wonforfait, Result::wonbye, Result::wonadjourned ];
    const Draw = [ Result::draw, Result::drawadjourned ];
    const Lost = [ Result::absent, Result::bye, Result::lost, Result::adjourned ];
    const NotPlayed = [ Result::bye, Result::wonbye, Result::absent ];
    const Played = [ Result::won, Result::wonforfait, Result::wonbye, Result::wonadjourned, Result::draw, Result::drawadjourned, Result::absent, Result::bye, Result::lost, Result::adjourned ];
    const Black = [ Color::black ];
    const White = [ Color::white ];
}
