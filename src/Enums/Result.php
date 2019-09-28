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
    const None = '*';
    const Lost = '0';
    const Draw = '0.5';
    const Won = '1';
    const Absent = '0 FF';
    const WonForfait = '1 FF';
    const Adjourned = '0 A';
    const DrawAdjourned = '0.5 A';
    const WonAdjourned = '1 A';
    const Bye = '0 Bye';
    const WonBye = '1 Bye';
}
