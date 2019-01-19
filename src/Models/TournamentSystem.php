<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 19/01/19
 * Time: 12:23
 */

namespace JeroenED\Libpairtwo\Models;

use MyCLabs\Enum\Enum;

class TournamentSystem extends Enum
{
    const Swiss = 0;
    const Closed = 2;
    const American = 4;
    const Imperial = 6;
}
