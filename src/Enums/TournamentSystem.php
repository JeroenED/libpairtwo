<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 19/01/19
 * Time: 12:23
 */

namespace JeroenED\Libpairtwo\Enums;

use MyCLabs\Enum\Enum;

class TournamentSystem extends Enum
{
    const Swiss = 'Swiss';
    const Closed = 'Closed';
    const American = 'American';
    const Imperial = 'Imperial';
}
