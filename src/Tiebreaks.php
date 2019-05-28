<?php


namespace JeroenED\Libpairtwo;

use JeroenED\Libpairtwo\Enums\Color;
use JeroenED\Libpairtwo\Models\Tournament;
use JeroenED\Libpairtwo\Enums\Result;

abstract class Tiebreaks extends Tournament
{

    /**
     * @param int $key
     * @param Player $player
     * @return float
     */
    protected function calculateKeizer(int $key, Player $player): float
    {
        $currentTiebreaks = $player->getTiebreaks();
        $currentTiebreaks[$key] = $player->getBinaryData('ScoreAmerican');
        $player->setTiebreaks($currentTiebreaks);
        return $currentTiebreaks[$key];
    }

    /**
     * @param int $key
     * @param Player $player
     * @return float
     */
    protected function calculateAmerican(int $key, Player $player): float
    {
        $currentTiebreaks = $player->getTiebreaks();
        $currentTiebreaks[$key] = $player->getBinaryData('ScoreAmerican');
        $player->setTiebreaks($currentTiebreaks);
        return $currentTiebreaks[$key];
    }


    /**
     * @param int $key
     * @param Player $player
     * @return float
     */
    protected function calculatePoints(int $key, Player $player): float
    {
        $currentTiebreaks = $player->getTiebreaks();
        $currentTiebreaks[$key] = $player->getBinaryData('Points');
        $player->setTiebreaks($currentTiebreaks);
        return $currentTiebreaks[$key];
    }


    /**
     * @param int $key
     * @param Player $player
     * @return float
     */
    protected function calculateBaumbach(int $key, Player $player): float
    {
        $wonArray = [Result::won, Result::wonadjourned, Result::wonbye, Result::wonforfait];
        $totalwins = 0;
        foreach ($player->getPairings() as $pairing) {
            if (array_search($pairing->getResult(), $wonArray) !== false) {
                $totalwins++;
            }
        }
        $currentTiebreaks = $player->getTiebreaks();
        $currentTiebreaks[$key] = $totalwins;
        $player->setTiebreaks($currentTiebreaks);
        return $currentTiebreaks[$key];
    }

    /**
     * @param int $key
     * @param Player $player
     * @return float
     */
    protected function calculateBlackPlayed(int $key, Player $player): float
    {
        $blackArray = [Color::black];
        $totalwins = 0;
        foreach ($player->getPairings() as $pairing) {
            if (array_search($pairing->getColor(), $blackArray) !== false) {
                $totalwins++;
            }
        }
        $currentTiebreaks = $player->getTiebreaks();
        $currentTiebreaks[$key] = $totalwins;
        $player->setTiebreaks($currentTiebreaks);
        return $currentTiebreaks[$key];
    }
    /**
     * @param int $key
     * @param Player $player
     * @return float
     */
    protected function calculateBlackWin(int $key, Player $player): float
    {
        $wonArray = [Result::won, Result::wonadjourned, Result::wonbye, Result::wonforfait];
        $blackArray = [Color::black];
        $totalwins = 0;
        foreach ($player->getPairings() as $pairing) {
            if (array_search($pairing->getColor(), $blackArray) !== false && array_search($pairing->getResult(), $wonArray) !== false) {
                $totalwins++;
            }
        }
        $currentTiebreaks = $player->getTiebreaks();
        $currentTiebreaks[$key] = $totalwins;
        $player->setTiebreaks($currentTiebreaks);
        return $currentTiebreaks[$key];
    }
}
