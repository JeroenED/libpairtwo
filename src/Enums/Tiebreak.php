<?php


namespace JeroenED\Libpairtwo\Enums;

use MyCLabs\Enum\Enum;

class Tiebreak extends Enum
{
    const None = "";
    const Keizer = "Keizer";
    const Points = "Points";
    const American = "American";
    const Buchholz = "Buchholz";
    const BuchholzMed = "Buchholz Median";
    const BuchholzCut = "Buchholz Cut";
    const Sonneborn = "Sonneborn-Berger";
    const Kashdan = "Kashdan";
    const SoccerKashdan = "Soccer Kashdan";
    const Cumulative = "Cumulative";
    const Between = "Mutual Result";
    const Koya = "Koya";
    const Baumbach = "Most wins"; // Ref: https://en.wikipedia.org/wiki/Tie-breaking_in_Swiss-system_tournaments#Most_wins_(Baumbach) Please tell me why?
    const AveragePerformance = "Average performance";
    const Performance = "Performance";
    const Aro = "Average Rating";
    const AroCut = "Average Rating Cut";
    const BlackPlayed = "Black played";
    const BlackWin = "Black Winned";
    const Testmatch = "Testmatch";
    const Drawing = "Drawing of lot";
}
