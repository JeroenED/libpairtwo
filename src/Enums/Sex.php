<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 25/01/19
 * Time: 15:56
 */

namespace JeroenED\Libpairtwo\Models;


use MyCLabs\Enum\Enum;

class Sex extends Enum
{
    const Neutral = 0; // Unforturnately, Incompatible with Pairtwo (Dinos)
    const Male = 1;
    const Female = 2;
}