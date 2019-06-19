<?php
/**
 * Enum Result
 *
 * List of all compatible results
 *
 * @author      Jeroen De Meerleer <schaak@jeroened.be>
 * @category    Main
 * @package     Libpairtwo
 * @copyright   Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */

namespace JeroenED\Libpairtwo\Enums;

use MyCLabs\Enum\Enum;

/**
 * Enum Result
 *
 * List of all compatible results
 *
 * @author      Jeroen De Meerleer <schaak@jeroened.be>
 * @category    Main
 * @package     Libpairtwo
 * @copyright   Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */
class Result extends Enum
{
    const none = '*';
    const lost = '0';
    const draw = '0.5';
    const won = '1';
    const absent = '0 FF';
    const wonforfait = '1 FF';
    const adjourned = '0 A';
    const drawadjourned = '0.5 A';
    const wonadjourned = '1 A';
    const bye = '0 Bye';
    const wonbye = '1 Bye';
}
