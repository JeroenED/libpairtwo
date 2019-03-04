<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 25/01/19
 * Time: 15:56
 */

namespace JeroenED\Libpairtwo\Enums;

use MyCLabs\Enum\Enum;

class Gender extends Enum
{
    const Neutral = 'X'; // Unforturnately, Incompatible with Pairtwo (Dinos)
    const Male = 'M';
    const Female = 'F';
}
