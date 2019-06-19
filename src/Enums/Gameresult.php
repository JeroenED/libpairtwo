<?php
/**
 * Enum Gameresult
 *
 * List of all compatible gameresults
 *
 * @author      Jeroen De Meerleer <schaak@jeroened.be>
 * @category    Main
 * @package     Libpairtwo
 * @copyright   Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */

namespace JeroenED\Libpairtwo\Enums;

use MyCLabs\Enum\Enum;

/**
 * Enum Gameresult
 *
 * List of all compatible gameresults
 *
 * @author      Jeroen De Meerleer <schaak@jeroened.be>
 * @category    Main
 * @package     Libpairtwo
 * @copyright   Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */
class Gameresult extends Enum
{
    const None = '-';
    const WhiteWins = '1-0';
    const Draw = '0.5-0.5';
    const BlackWins = '0-1';
    const WhiteWinsForfait = '1-0 FF';
    const BlackWinsForfait = '0-1 FF';
    const BothLoseForfait = '0-0 FF';
    const BothWinAdjourned = '1-1 A';
    const WhiteWinsBlackDrawsAdjourned = '1-0.5 A';
    const WhiteDrawsBlackWinsAdjourned = '0.5-1 A';
    const DrawAdjourned = '0.5-0.5 A';
    const WhiteLoseBlackDrawsAdjourned = '0-0.5';
    const WhiteDrawsBlackLoseAdjourned = '0.5-0';
}
