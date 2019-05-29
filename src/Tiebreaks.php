<?php


namespace JeroenED\Libpairtwo;

use JeroenED\Libpairtwo\Enums\Color;
use JeroenED\Libpairtwo\Models\Tournament;
use JeroenED\Libpairtwo\Enums\Result;

abstract class Tiebreaks extends Tournament
{

    private const Won = [ Result::won, Result::wonforfait, Result::wonbye, Result::wonadjourned ];
    private const Draw = [ Result::draw, Result::drawadjourned];
    private const Lost = [ Result::absent, Result::bye, Result::lost, Result::adjourned ];
    private const Black = [ Color::black ];
    private const White = [ Color::white ];


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
        $points = 0;
        foreach ($player->getPairings() as $pairing) {
            if (array_search($pairing->getResult(), self::Won) !== false) {
                $points = $points + 1;
            } elseif (array_search($pairing->getResult(), self::Draw) !== false) {
                $points = $points + 0.5;
            }
        }
        return $points;
    }


    /**
     * @param Player $player
     * @return float|null
     */
    protected function calculateBaumbach(Player $player): ?float
    {
        $totalwins = 0;
        foreach ($player->getPairings() as $pairing) {
            if (array_search($pairing->getResult(), self::Won) !== false) {
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
            if (array_search($pairing->getColor(), self::Black) !== false) {
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
            if (array_search($pairing->getColor(), self::Black) !== false && array_search($pairing->getResult(), Self::Won) !== false) {
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
                if (array_search($pairing->getResult(), self::Won) !== false) {
                    $points = $points + 1;
                } elseif (array_search($pairing->getResult(), self::Draw) !== false) {
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

    protected function calculateAverageRating(Player $player) {
        $pairings = $player->getPairings();
        $totalrating = 0;
        $opponents;
        foreach ($pairings as $pairing) {
            if ($pairing->getOpponent()->getElos['national'])
        }
    }
}
