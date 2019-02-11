<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 11/02/19
 * Time: 16:03
 */

namespace JeroenED\Libpairtwo\Enums;

use MyCLabs\Enum\Enum;

class Result extends Enum
{
    const none = 0;
    const lost = 1;
    const draw = 6;
    const won = 11;
    const absent = 2;
    const wonforfait = 12;
    const adjourn = 3;
    const drawadjourned = 8;
    const wonadjourned = 13;
    const bye = 4;
    const wonbye = 14;
}
