<?php


namespace JeroenED\Libpairtwo;

use JeroenED\Libpairtwo\Enums\Color;
use JeroenED\Libpairtwo\Models\Tournament;
use JeroenED\Libpairtwo\Enums\Result;

abstract class Tiebreaks extends Tournament
{

    /**
     * @param Player $player
     * @return float|null
     */
    protected function calculateKeizer(Player $player): ?float
    {
        return $player->getBinaryData('ScoreAmerican');
    }


    /**
     * @param Player $player
     * @return float|null
     */
    protected function calculateAmerican(Player $player): ?float
    {
        return $player->getBinaryData('ScoreAmerican');
    }


    /**
     * @param Player $player
     * @return float|null
     */
    protected function calculatePoints(Player $player): ?float
    {
        return $player->getPoints();
    }


    /**
     * @param Player $player
     * @return float|null
     */
    protected function calculateBaumbach(Player $player): ?float
    {
        $totalwins = 0;
        foreach ($player->getPairings() as $pairing) {
            if (array_search($pairing->getResult(), Constants::Won) !== false) {
                $totalwins++;
            }
        }
        return $totalwins;
    }


    /**
     * @param Player $player
     * @return float|null
     */
    protected function calculateBlackPlayed(Player $player): ?float
    {
        $totalwins = 0;
        foreach ($player->getPairings() as $pairing) {
            if (array_search($pairing->getColor(), Constants::Black) !== false) {
                $totalwins++;
            }
        }
        return $totalwins;
    }

    /**
     * @param Player $player
     * @return float|null
     */
    protected function calculateBlackWin(Player $player): ?float
    {
        $totalwins = 0;
        foreach ($player->getPairings() as $pairing) {
            if (array_search($pairing->getColor(), Constants::Black) !== false && array_search($pairing->getResult(), Constants::Won) !== false) {
                $totalwins++;
            }
        }
        return $totalwins;
    }


    /**
     * @param Player $player
     * @param array $opponents
     * @param int $key
     * @return float|null
     */
    protected function calculateMutualResult(Player $player, array $opponents, int $key): ?float
    {
        $interestingplayers = $opponents;
        if ($key != 0) {
            $interestingplayers = [];
            foreach ($opponents as $opponent) {
                if (($opponent->getTiebreaks()[$key - 1] == $player->getTiebreaks()[$key - 1]) && ($player != $opponent)) {
                    $interestingplayers[] = $opponent;
                }
            }
        }
        $points = 0;
        $totalmatches = 0;
        foreach ($player->getPairings() as $pairing) {
            if (array_search($pairing->getOpponent(), $interestingplayers) !== false) {
                if (array_search($pairing->getResult(), Constants::Won) !== false) {
                    $points = $points + 1;
                } elseif (array_search($pairing->getResult(), Constants::Draw) !== false) {
                    $points = $points + 0.5;
                }
                $totalmatches++;
            }
        }
        if ($totalmatches != count($interestingplayers)) {
            $points = null;
        }
        return $points;
    }


    /**
     * @param Player $player
     * @param int $cut
     * @return float
     */
    protected function calculateAverageRating(Player $player, string $type, int $cut = 0): ?float
    {
        $pairings = $player->getPairings();
        $allratings = [];
        foreach ($pairings as $pairing) {
            if (array_search($pairing->getResult(), Constants::NotPlayed) === false) {
                $toadd = $pairing->getOpponent()->getElo($type);
                if ($toadd != 0) {
                    $allratings[] = $toadd;
                }
            }
        }
        sort($allratings);
        $allratings = array_slice($allratings, $cut);
        return round(array_sum($allratings) / count($allratings));
    }


    /**
     * @param Player $player
     * @param int $cut
     * @return float|null
     */
    protected function calculateAveragePerformance(Player $player, string $type, int $cut = 0): ?float
    {
        $pairings = $player->getPairings();
        $allratings = [];
        foreach ($pairings as $pairing) {
            if (array_search($pairing->getResult(), Constants::NotPlayed) === false) {
                $toadd = $pairing->getOpponent()->getPerformance($type, $this->getNonRatedElo());
                if ($toadd != 0) {
                    $allratings[] = $toadd;
                }
            }
        }
        sort($allratings);
        $allratings = array_slice($allratings, $cut);
        return round(array_sum($allratings) / count($allratings));
    }


    /**
     * @param Player $player
     * @param int $cut
     * @return float|null
     */
    protected function calculateKoya(Player $player, int $cut = 50): ?float
    {
        $tiebreak = 0;
        foreach ($player->getPairings() as $plkey => $plpairing) {
            if (($plpairing->getOpponent()->getNoOfWins() / count($plpairing->getOpponent()->getPairings()) * 100) >= $cut) {
                $tiebreak += $plpairing->getOpponent()->getNoOfWins();
            }
        }
        return $tiebreak;
    }


    /**
     * @param Player $player
     * @param int $cutlowest
     * @param int $cuthighest
     * @return float|null
     */
    protected function calculateBuchholz(Player $player, int $cutlowest = 0, int $cuthighest = 0): ?float
    {
        $tiebreak = 0;
        $intpairings = $player->getPairings();

        usort($intpairings, function ($a, $b) {
            if (is_null($a->getOpponent())) {
                return -1;
            }
            if (is_null($b->getOpponent())) {
                return 1;
            }
        
            if ($b->getOpponent()->getElo('Nation') == $a->getOpponent()->getElo('Nation')) {
                return 0;
            }
            return ($b->getOpponent()->getElo('Nation') > $a->getOpponent()->getElo('Nation')) ? 1 : -1;
        });

        array_slice($intpairings, $cutlowest);
        array_slice($intpairings, 0 - $cuthighest);

        foreach ($intpairings as $intkey => $intpairing) {
            if (!is_null($intpairing->getOpponent())) {
                $tiebreak += $intpairing->getOpponent()->getPoints();
            }
        }
        return $tiebreak;
    }


    /**
     * @param Player $player
     * @return float|null
     */
    protected function calculateSonneborn(Player $player): ?float
    {
        $tiebreak = 0;
        foreach ($player->getPairings() as $key => $pairing) {
            if ($pairing->getOpponent()) {
                if (array_search($pairing->getResult(), Constants::Won) !== false) {
                    $tiebreak += $pairing->getOpponent()->getPoints();
                } elseif (array_search($pairing->getResult(), Constants::Draw) !== false) {
                    $tiebreak += $pairing->getOpponent()->getPoints() / 2;
                }
            }
        }
        return $tiebreak;
    }


    /**
     * @param Player $player
     * @return float|null
     */
    protected function calculateKashdan(Player $player): ?float
    {
        $tiebreak = 0;
        foreach ($player->getPairings() as $pairing) {
            $toadd = 0;
            if (array_search($pairing->getResult(), Constants::Won) !== false) {
                $toadd = 3;
            } elseif (array_search($pairing->getResult(), Constants::Draw) !== false) {
                $toadd = 2;
            } elseif (array_search($pairing->getResult(), Constants::Lost) !== false) {
                $toadd = 1;
            }

            if (array_search(Constants::NotPlayed, $pairing->getResult()) !== false) {
                $toadd = 0;
            }
            $tiebreak += $toadd;
        }
        return $tiebreak;
    }

    /**
     * @param Player $player
     * @return float|null
     */
    protected function calculateCumulative(Player $player): ?float
    {
        $tiebreak = 0;
        foreach ($player->getPairings() as $pairing) {
            $toadd = 0;
            if (array_search($pairing->getResult(), Constants::Won) !== false) {
                $toadd = 1;
            } elseif (array_search($pairing->getResult(), Constants::Draw) !== false) {
                $toadd = 0.5;
            }
            $tiebreak += $tiebreak + $toadd;
        }
        return $tiebreak;
    }
}
