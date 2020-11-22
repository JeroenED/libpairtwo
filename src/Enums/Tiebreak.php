<?php

/**
 * Enum Tiebreak
 *
 * List of all compatible tiebreaks
 *
 * @author    Jeroen De Meerleer <schaak@jeroened.be>
 * @category  Main
 * @package   Libpairtwo
 * @copyright Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */

namespace JeroenED\Libpairtwo\Enums;

use MyCLabs\Enum\Enum;

/**
 * Enum Tiebreak
 *
 * List of all compatible tiebreaks
 *
 * @author    Jeroen De Meerleer <schaak@jeroened.be>
 * @category  Main
 * @package   Libpairtwo
 * @copyright Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */
class Tiebreak extends Enum
{
    public const ARO = "Average Rating";

    public const AROCUT = "Average Rating Cut";

    public const AVERAGE_PERFORMANCE = "Average performance";

    public const BAUMBACH = "Most wins"; // Ref: https://en.wikipedia.org/wiki/Tie-breaking_in_Swiss-system_tournaments#Most_wins_(Baumbach) Please tell me why?

    public const BETWEEN = "Mutual Result";

    public const BLACK_PLAYED = "Black played";

    public const BLACK_WIN = "Black Winned";

    public const BUCHHOLZ = "Buchholz";

    public const BUCHHOLZ_CUT = "Buchholz Cut";

    public const BUCHHOLZ_CUT_2 = "Buchholz Cut 2";

    public const BUCHHOLZ_MED = "Buchholz Median";

    public const BUCHHOLZ_MED_2 = "Buchholz Median 2";

    public const CUMULATIVE = "Cumulative";

    public const DRAWING_OF_LOT = "Drawing of lot";

    public const KASHDAN = "Kashdan";

    public const KEIZER = "Keizer";

    public const KOYA = "Koya";

    public const NONE = "";

    public const PERFORMANCE = "Performance";

    public const POINTS = "Points";

    public const SOCCER_KASHDAN = "Soccer Kashdan";

    public const SONNEBORN = "Sonneborn-Berger";

    public const TESTMATCH = "Testmatch";
}
