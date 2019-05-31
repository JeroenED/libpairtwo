<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 1/02/19
 * Time: 11:18
 */

namespace JeroenED\Libpairtwo;

use JeroenED\Libpairtwo\Enums\Tiebreak;
use JeroenED\Libpairtwo\Enums\Color;

class Tournament extends Tiebreaks
{
    /**
     * Gets a player by its ID
     *
     * @param integer $id
     * @return Player
     */
    public function getPlayerById(int $id)
    {
        return $this->GetPlayers()[$id];
    }

    /**
     * Adds a player
     *
     * @param Player $Player
     */
    public function addPlayer(Player $Player)
    {
        $newArray = $this->GetPlayers();
        $newArray[] = $Player;
        $this->setPlayers($newArray);
    }

    /**
     * Updates player on id to the given Player object
     *
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
     * Adds a Tiebreak
     *
     * @param Tiebreak $tiebreak
     */
    public function addTiebreak(Tiebreak $tiebreak)
    {
        $newArray = $this->getTiebreaks();
        $newArray[] = $tiebreak;
        $this->setTiebreaks($newArray);
    }

    /**
     * Adds a round with given Round object
     *
     * @param Round $round
     */
    public function addRound(Round $round)
    {
        $newArray = $this->getRounds();
        $newArray[$round->getRoundNo()] = $round;
        $this->setRounds($newArray);
    }

    /**
     * Gets a round by its number.
     *
     * @param int $roundNo
     * @return Round
     */
    public function getRoundByNo(int $roundNo): Round
    {
        return $this->getRounds()[$roundNo];
    }

    /**
     * Adds a pairing to the tournament
     *
     * @param Pairing $pairing
     */
    public function addPairing(Pairing $pairing)
    {
        $newArray = $this->GetPairings();
        $newArray[] = $pairing;
        $this->setPairings($newArray);
    }

    /**
     * Converts pairings into games with a black and white player
     */
    public function pairingsToRounds(): void
    {
        /** @var Pairing[] $pairings */
        $pairings = $this->getPairings();

        /** @var Pairing[] */
        $cache = array();

        foreach ($pairings as $pairing) {
            // Add pairing to player
            $pairing->getPlayer()->addPairing($pairing);
            $round = $pairing->getRound();
            $color = $pairing->getColor();

            $this->getRoundByNo($round)->addPairing($pairing);
            $opponent = null;
            foreach ($cache as $key=>$cached) {
                if (!is_null($cached)) {
                    if (($cached->getOpponent() == $pairing->getPlayer()) && ($cached->getRound() == $pairing->getRound())) {
                        $opponent = $cached;
                        $cache[$key] = null;
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
     * Adds a game to the tournament
     *
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
     * Gets the ranking of the tournament
     *
     * @return Player[]
     */
    public function getRanking()
    {
        $players = $this->getPlayers();
        foreach ($this->getTiebreaks() as $tbkey=>$tiebreak) {
            foreach ($players as $pkey => $player) {
                $break = $this->calculateTiebreak($tiebreak, $player, $tbkey);
                $tiebreaks = $player->getTiebreaks();
                $tiebreaks[$tbkey] = $break;
                $player->setTiebreaks($tiebreaks);
                $this->updatePlayer($pkey, $player);
            }
        }
        $sortedplayers[0] = $players;
        foreach ($this->getTiebreaks() as $tbkey=>$tiebreak) {
            $newgroupkey = 0;
            $tosortplayers = $sortedplayers;
            $sortedplayers = [];
            foreach ($tosortplayers as $groupkey=>$sortedplayerselem) {
                usort($tosortplayers[$groupkey], $this->SortTiebreak($tbkey));
                foreach ($tosortplayers[$groupkey] as $playerkey => $player) {
                    if (!is_null($player->getTiebreaks()[$tbkey])) {
                        if ($playerkey != 0) {
                            $newgroupkey++;
                            if ($player->getTiebreaks()[$tbkey] == $tosortplayers[$groupkey][$playerkey - 1]->getTiebreaks()[$tbkey]) {
                                $newgroupkey--;
                            }
                        }
                    }
                    $sortedplayers[$newgroupkey][] = $player;
                }
                $newgroupkey++;
            }
        }
        $finalarray = [];
        foreach ($sortedplayers as $sort1) {
            foreach ($sort1 as $player) {
                $finalarray[] = $player;
            }
        }
        return $finalarray;
    }

    /**
     * @param Player $a
     * @param Player $b
     * @return \Closure
     */

    private function sortTiebreak(int $key)
    {
        return function (Player $a, Player $b) use ($key) {
            if (($b->getTiebreaks()[$key] == $a->getTiebreaks()[$key]) || ($a->getTiebreaks()[$key] === false) || ($b->getTiebreaks()[$key] === false)) {
                return 0;
            }
            return ($b->getTiebreaks()[$key] > $a->getTiebreaks()[$key]) ? +1 : -1;
        };
    }


    /**
     * @return float|null
     */
    private function calculateTiebreak(Tiebreak $tiebreak, Player $player, int $tbkey = 0): ?float
    {
        switch ($tiebreak) {
            case Tiebreak::Keizer:
                return $this->calculateKeizer($player);
                break;
            case Tiebreak::American:
                return $this->calculateAmerican($player);
                break;
            case Tiebreak::Points:
                return $this->calculatePoints($player);
                break;
            case Tiebreak::Baumbach:
                return $this->calculateBaumbach($player);
                break;
            case Tiebreak::BlackPlayed:
                return $this->calculateBlackPlayed($player);
                break;
            case Tiebreak::BlackWin:
                return $this->calculateBlackWin($player);
                break;
            case Tiebreak::Between:
                return $this->calculateMutualResult($player, $this->getPlayers(), $tbkey);
                break;
            case Tiebreak::Aro:
                return $this->calculateAverageRating($player);
                break;
            case Tiebreak::AroCut:
                return $this->calculateAverageRating($player, 1);
                break;
            case Tiebreak::Koya:
                return $this->calculateKoya($player);
                break;
            case Tiebreak::Buchholz:
                return $this->calculateBuchholz($player);
                break;
            case Tiebreak::BuchholzCut:
                return $this->calculateBuchholz($player, 1);
                break;
            case Tiebreak::BuchholzMed:
                return $this->calculateBuchholz($player, 1, 1);
                break;
            case Tiebreak::Sonneborn:
                return $this->calculateSonneborn($player);
                break;
            case Tiebreak::Kashdan:
                return $this->calculateKashdan($player);
                break;
            case Tiebreak::Cumulative:
                return $this->calculateCumulative($player);
                break;
            case Tiebreak::AveragePerformance:
                return $this->calculateAveragePerformance($player);
                break;
            case Tiebreak::Performance:
                return $player->getPerformance($this->getPriorityElo());
                break;
            default:
                return null;
        }
    }

    /**
     * Return the average rating for tournament
     *
     * @return int
     */
    public function getAverageElo(): int
    {
        $totalrating = 0;
        $players = 0;
        foreach ($this->getPlayers() as $player) {
            $toadd = $player->getElo($this->getPriorityElo());
            if ($toadd == 0) {
                $toadd = $this->getNonRatedElo();
            }

            $totalrating += $toadd;
            $players++;
        }
        return intdiv($totalrating, $players);
    }
}
