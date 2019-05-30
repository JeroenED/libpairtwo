<?php


namespace JeroenED\Libpairtwo;

use JeroenED\Libpairtwo\Enums\Color;
use JeroenED\Libpairtwo\Enums\Result;

class Constants
{
    const Won = [ Result::won, Result::wonforfait, Result::wonbye, Result::wonadjourned ];
    const Draw = [ Result::draw, Result::drawadjourned];
    const Lost = [ Result::absent, Result::bye, Result::lost, Result::adjourned ];
    const NotPlayed = [ Result::bye, Result::wonbye, Result::absent ];
    const Black = [ Color::black ];
    const White = [ Color::white ];
}
