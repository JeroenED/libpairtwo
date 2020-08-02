<?php

/**
 * Enum Title
 *
 * List of all compatible titles
 *
 * @author    Jeroen De Meerleer <schaak@jeroened.be>
 * @category  Main
 * @package   Libpairtwo
 * @copyright Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */

namespace JeroenED\Libpairtwo\Enums;

use MyCLabs\Enum\Enum;

/**
 * Enum Title
 *
 * List of all compatible titles
 *
 * @author    Jeroen De Meerleer <schaak@jeroened.be>
 * @category  Main
 * @package   Libpairtwo
 * @copyright Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */
class Title extends Enum
{
    public const CM = 'Candidate Master';

    public const ELO = 'Elo';

    public const FM = 'Fide Master';

    public const GM = 'Grand Master';

    public const HG = 'Honorary Grand Master';

    public const HM = 'Honorary International Master';

    public const IM = 'International Master';

    public const NM = 'National Master';

    public const NONE = '*';

    public const WCM = 'Woman Candidate Master';

    public const WFM = 'Woman Fide Master';

    public const WGM = 'Woman Grand Master';

    public const WIM = 'Woman International Master';
}
