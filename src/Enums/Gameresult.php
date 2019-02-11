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
    const WhiteWins = "1-0";
    const WhiteWinsForfait = "1-0FF";
    const WhiteWinsAdjourned = "1-0A";
    const BlackWins = "0-1";
    const BlackWinsForfait = "0-1FF";
    const BlackWinsAdjourned = "0-1A";
    const Draw = "0.5-0.5";
    const DrawAdjourned = "0.5-0.5A";
    const None = "-";
}