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
    const none = '*';
    const lost = '0';
    const draw = '0.5';
    const won = '1';
    const absent = '0 FF';
    const wonforfait = '1 FF';
    const adjourn = '0 A';
    const drawadjourned = '0.5 A';
    const wonadjourned = '1 A';
    const bye = '0 Bye';
    const wonbye = '1 Bye';
}
