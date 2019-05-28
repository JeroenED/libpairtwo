<?php


namespace JeroenED\Libpairtwo;

use JeroenED\Libpairtwo\Models\Tournament;

abstract class Tiebreaks extends Tournament
{
    /**
     * @param int $key
     */
    protected function calculateKeizer(int $key)
    {
        foreach ($this->getPlayers() as $player) {
            $currentTiebreaks = $player->getTiebreaks();
            $currentTiebreaks[$key] = $player->getBinaryData('ScoreAmerican');
            $player->setTiebreaks($currentTiebreaks);
        }
    }

    /**
     * @param int $key
     */
    protected function calculateAmerican(int $key)
    {
        foreach ($this->getPlayers() as $player) {
            $currentTiebreaks = $player->getTiebreaks();
            $currentTiebreaks[$key] = $player->getBinaryData('ScoreAmerican');
            $player->setTiebreaks($currentTiebreaks);
        }
    }

    /**
     * @param int $key
     */
    protected function calculatePoints(int $key)
    {
        foreach ($this->getPlayers() as $player) {
            $currentTiebreaks = $player->getTiebreaks();
            $currentTiebreaks[$key] = $player->getBinaryData('Points');
            $player->setTiebreaks($currentTiebreaks);
        }
    }
}
