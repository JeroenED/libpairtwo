<?php

/**
 * Enum TournamentSystem
 *
 * List of all compatible tournament systems
 *
 * @author    Jeroen De Meerleer <schaak@jeroened.be>
 * @category  Main
 * @package   Libpairtwo
 * @copyright Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */

namespace JeroenED\Libpairtwo\Enums;

use MyCLabs\Enum\Enum;

/**
 * Enum TournamentSystem
 *
 * List of all compatible tournament systems
 *
 * @author    Jeroen De Meerleer <schaak@jeroened.be>
 * @category  Main
 * @package   Libpairtwo
 * @copyright Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */
class TournamentSystem extends Enum
{
    public const AMERICAN = 'American';

    public const CLOSED = 'Closed';

    public const KEIZER = 'Keizer';

    public const SWISS = 'Swiss';
}
