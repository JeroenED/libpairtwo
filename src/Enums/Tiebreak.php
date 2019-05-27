<?php


namespace JeroenED\Libpairtwo\Enums;

use MyCLabs\Enum\Enum;

class Tiebreak extends Enum
{
    const None = "";
    const Buchholz = "Buchholz";
    const BuchholzMed = "Buchholz Median";
    const BuchholzCut = "Buchholz Cut";
    const Sonneborn = "Sonneborn-Berger";
    const Kashdan = "Kashdan";
    const Cumulative = "Cumulative";
    const Between = "Mutual Result";
    const Koya = "Koya";
    const Baumbach = "Baumbach";
    const Performance = "Performance";
    const Aro = "Average Rating";
    const AroCut = "Average Rating Cut";
    const BlackPlayed = "Black played";
    const BlackWin = "Black Winned";
    const Testmatch = "Testmatch";
    const Drawing = "Drawing of lot";
}
