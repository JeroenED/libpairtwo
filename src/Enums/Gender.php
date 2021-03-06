<?php

/**
 * Enum Gender
 *
 * List of all compatible genders
 *
 * @author    Jeroen De Meerleer <schaak@jeroened.be>
 * @category  Main
 * @package   Libpairtwo
 * @copyright Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */

namespace JeroenED\Libpairtwo\Enums;

use MyCLabs\Enum\Enum;

/**
 * Enum Gender
 *
 * List of all compatible genders
 *
 * @author    Jeroen De Meerleer <schaak@jeroened.be>
 * @category  Main
 * @package   Libpairtwo
 * @copyright Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */
class Gender extends Enum
{
    public const FEMALE = 'F';

    public const MALE = 'M';

    public const NEUTRAL = 'X'; // Unfortunately, Incompatible with Pairtwo (Dinos)
}
