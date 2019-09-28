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
    const Won = [ Result::Won, Result::WonForfait, Result::WonBye, Result::WonAdjourned ];
    const Draw = [ Result::Draw, Result::DrawAdjourned ];
    const Lost = [ Result::Absent, Result::Bye, Result::Lost, Result::Adjourned ];
    const NotPlayed = [ Result::Bye, Result::WonBye, Result::Absent ];
    const Played = [ Result::Won, Result::WonForfait, Result::WonBye, Result::WonAdjourned, Result::Draw, Result::DrawAdjourned, Result::Absent, Result::Bye, Result::Lost, Result::Adjourned ];
    const Black = [ Color::Black ];
    const White = [ Color::White ];
}
