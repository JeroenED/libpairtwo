<?php
/**
 * Enum Title
 *
 * List of all compatible titles
 *
 * @author      Jeroen De Meerleer <schaak@jeroened.be>
 * @category    Main
 * @package     Libpairtwo
 * @copyright   Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */

namespace JeroenED\Libpairtwo\Enums;

use MyCLabs\Enum\Enum;

/**
 * Enum Title
 *
 * List of all compatible titles
 *
 * @author      Jeroen De Meerleer <schaak@jeroened.be>
 * @category    Main
 * @package     Libpairtwo
 * @copyright   Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */
class Title extends Enum
{
    const NONE = '*';
    const ELO  = 'Elo';
    const NM   = 'National Master';
    const WCM  = 'Woman Candidate Master';
    const WFM  = 'Woman Fide Master';
    const CM   = 'Candidate Master';
    const WIM  = 'Woman International Master';
    const FM   = 'Fide Master';
    const WGM  = 'Woman Grand Master';
    const HM   = 'Honorary International Master';
    const IM   = 'International Master';
    const HG   = 'Honorary Grand Master';
    const GM   = 'Grand Master';
}
