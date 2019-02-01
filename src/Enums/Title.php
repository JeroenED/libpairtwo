<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 25/01/19
 * Time: 17:10
 */

namespace JeroenED\Libpairtwo\Enums;

use MyCLabs\Enum\Enum;

class Title extends Enum
{
    const NONE = 0;
    const ELO  = 1;
    const NM   = 2;  // National Master
    const WCM  = 3;  // Woman Candidate Master
    const WFM  = 4;  // Women Fide Master
    const CM   = 5;  // Candidate Master
    const WIM  = 6;  // Woman International Master
    const FM   = 7;  // Fide Master
    const WGM  = 8;  // Woman Grand Master
    const HM   = 9;  // Honorary International master
    const IM   = 10; // International Master
    const HG   = 11; // Honorary Grand Master
    const GM   = 12; // Grand Master

}