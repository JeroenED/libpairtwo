<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 1/02/19
 * Time: 11:18
 */

namespace JeroenED\Libpairtwo;

use JeroenED\Libpairtwo\Enums\Result;
use JeroenED\Libpairtwo\Models\Tournament as TournamentModel;
use JeroenED\Libpairtwo\Player;
use JeroenED\Libpairtwo\Enums\Color;
use JeroenED\Libpairtwo\Enums\Gameresult;

class Tournament extends TournamentModel
{
    /**
     * @param integer $id
     * @return Player
     */
    public function getPlayerById(int $id)
    {
        return $this->GetPlayers()[$id];
    }

    /**
     * @param Player $Player
     */
    public function addPlayer(Player $Player)
    {
        $newArray = $this->GetPlayers();
        $newArray[] = $Player;
        $this->setPlayers($newArray);
    }

    /**
     * @param int $id
     * @param Player $player
     */
    public function updatePlayer(int $id, Player $player)
    {
        $newArray = $this->GetPlayers();
        $newArray[$id] = $player;
        $this->setPlayers($newArray);
    }

    /**
     * @param Round $round
     */
    public function addRound(Round $round)
    {
        $newArray = $this->getRounds();
        $newArray[$round->getRoundNo()] = $round;
        $this->setRounds($newArray);
    }

    /**
     * @param int $roundNo
     * @return Round
     */
    public function getRoundByNo(int $roundNo): Round
    {
        return $this->getRounds()[$roundNo];
    }

    /**
     * @param Pairing $pairing
     */
    public function addPairing(Pairing $pairing)
    {
        $newArray = $this->GetPairings();
        $newArray[] = $pairing;
        $this->setPairings($newArray);
    }

    /**
     * This function converts the array of pairings into rounds
     */
    public function pairingsToRounds(): void
    {
        $pairings = $this->getPairings();

        /** @var Pairing[] */
        $cache = array();

        foreach ($pairings as $pairing) {
            $round = $pairing->getRound();
            $color = $pairing->getColor();
            $opponent = null;
            foreach($cache as $key=>$cached) {
                if (!is_null($cached)) {
                    if ($cached->getOpponent() == $pairing->getPlayer() && ($cached->getRound() == $pairing->getRound())) {
                        $opponent = $cached;
                        $cache[$key] == null;
                        break;
                    }
                }
            }
            $game = new Game();
            if ($color->getValue() == Color::white) {
                $game->setWhite($pairing);
                $game->setBlack($opponent);
            } elseif ($color->getValue() == Color::black) {
                $game->setWhite($opponent);
                $game->setBlack($pairing);
            }

            if (is_null($game->getWhite()) || is_null($game->getBlack())) {
                $cache[] = $pairing;
            } else {
                // Check if game already exists
                if (!$this->GameExists($game, $round)) {
                    $this->AddGame($game, $round);
                }
            }
        }
    }

    /**
     * Checks if a game already is already registered
     *
     * @param Game $game
     * @param int $round
     * @return bool
     */
    public function GameExists(Game $game, int $round = -1): bool
    {
        $search = [ $round ];
        if ($round == -1) {
            $search = [];
            for ($i = 0; $i < $this->getNoOfRounds(); $i++) {
                $search[] = $i;
            }
        }

        foreach ($search as $round) {
            if (!isset($this->getRounds()[$round])) {
                return false;
            }
            $games = $this->getRounds()[$round]->getGames();
            if (is_null($games)) {
                return false;
            }
            foreach ($games as $roundgame) {
                if ($roundgame->getWhite() == $game->getWhite() &&
                    $roundgame->getBlack() == $game->getBlack() &&
                    $roundgame->getResult() == $game->getResult()
                ) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param Game $game
     * @param int $round
     */
    public function addGame(Game $game, int $round)
    {
        if (!isset($this->getRounds()[$round])) {
            $roundObj = new Round();
            $roundObj->setRoundNo($round);
            $this->addRound($roundObj);
        }

        $this->getRoundByNo($round)->addGame($game);
    }

    /**
     * @param bool $americansort
     * @return Player[]
     */
    public function getRanking(bool $americansort = false)
    {
        $players = $this->getPlayers();

        $americansort ? usort($players, array($this, "SortAmerican")) : usort($players, array($this, "SortNormal"));

        return $players;
    }

    /**
     * @param Player $a
     * @param Player $b
     * @return int
     */
    private function sortNormal(Player $a, Player $b)
    {
        return $b->getPoints() - $a->getPoints();
    }

    /**
     * @param Player $a
     * @param Player $b
     * @return int
     */
    private function sortAmerican(Player $a, Player $b)
    {
        return $b->getScoreAmerican() - $a->getScoreAmerican();
    }
}
