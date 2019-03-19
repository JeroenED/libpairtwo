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
