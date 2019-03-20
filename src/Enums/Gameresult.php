<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 11/02/19
 * Time: 21:28
 */

namespace JeroenED\Libpairtwo\Enums;

use MyCLabs\Enum\Enum;

class Gameresult extends Enum
{
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
