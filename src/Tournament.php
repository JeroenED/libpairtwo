<?php
/**
 * Class Tournament
 *
 * Class for the tournament from the pairing file
 *
 * @author      Jeroen De Meerleer <schaak@jeroened.be>
 * @category    Main
 * @package     Libpairtwo
 * @copyright   Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */

namespace JeroenED\Libpairtwo;

use JeroenED\Libpairtwo\Enums\Color;
use JeroenED\Libpairtwo\Enums\Tiebreak;
use JeroenED\Libpairtwo\Enums\TournamentSystem;
use Closure;
use DateTime;

/**
 * Class Tournament
 *
 * Class for the tournament from the pairing file
 *
 * @author      Jeroen De Meerleer <schaak@jeroened.be>
 * @category    Main
 * @package     Libpairtwo
 * @copyright   Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */
class Tournament
{
    /** @var string */
    public $Name;

    /** @var string */
    public $Organiser;

    /** @var int */
    public $OrganiserClubNo;

    /** @var string */
    public $OrganiserClub;

    /** @var string */
    public $OrganiserPlace;

    /** @var string */
    public $OrganiserCountry;

    /** @var int */
    public $FideHomol;

    /** @var DateTime */
    public $StartDate;

    /** @var DateTime */
    public $EndDate;

    /** @var string[] */
    public $Arbiters;

    /** @var int */
    public $NoOfRounds;

    /** @var Round[] */
    public $Rounds = [];

    /** @var string */
    public $Tempo;

    /** @var int */
    public $NonRatedElo;

    /** @var TournamentSystem */
    public $System;

    /** @var string */
    public $FirstPeriod;

    /** @var string */
    public $SecondPeriod;

    /** @var string */
    public $Federation;

    /** @var Player[] */
    public $Players = [];

    /** @var int */
    public $Year;

    /** @var Pairing[] */
    public $Pairings = [];

    /** @var Tiebreak[] */
    public $Tiebreaks = [];

    /** @var string */
    public $PriorityElo = 'Fide';

    /** @var string */
    public $PriorityId = 'Nation';

    /** @var bool|DateTime|int|string[] */
    private $BinaryData = [];

    /**
     * Gets a player by its ID
     *
     * @param integer $id
     * @return Player
     */
    public function getPlayerById(int $id): Player
    {
        return $this->Players[$id];
    }

    /**
     * Adds a player
     *
     * @param Player $Player
     * @return Tournament
     */
    public function addPlayer(Player $Player): Tournament
    {
        $newArray = $this->Players;
        $newArray[] = $Player;
        $this->Players = $newArray;
        return $this;
    }

    /**
     * Updates player on id to the given Player object
     *
     * @param int $id
     * @param Player $player
     * @return Tournament
     */
    public function updatePlayer(int $id, Player $player): Tournament
    {
        $newArray = $this->Players;
        $newArray[$id] = $player;
        $this->Players = $newArray;
        return $this;
    }

    /**
     * Adds a Tiebreak
     *
     * @param Tiebreak $tiebreak
     * @return Tournament
     */
    public function addTiebreak(Tiebreak $tiebreak): Tournament
    {
        $newArray = $this->Tiebreaks;
        $newArray[] = $tiebreak;
        $this->Tiebreaks = $newArray;
        return $this;
    }

    /**
     * Adds a round with given Round object
     *
     * @param Round $round
     * @return Tournament
     */
    public function addRound(Round $round): Tournament
    {
        $newArray = $this->Rounds;
        $newArray[$round->RoundNo] = $round;
        $this->Rounds = $newArray;
        return $this;
    }

    /**
     * Gets a round by its number.
     *
     * @param int $roundNo
     * @return Round
     */
    public function getRoundByNo(int $roundNo): Round
    {
        return $this->Rounds[$roundNo];
    }

    /**
     * Adds a pairing to the tournament
     *
     * @param Pairing $pairing
     * @return Tournament
     */
    public function addPairing(Pairing $pairing): Tournament
    {
        $newArray = $this->Pairings;
        $newArray[] = $pairing;
        $this->Pairings = $newArray;
        return $this;
    }


    /**
     * Adds an arbiter to the tournament
     *
     * @param string $Arbiter
     * @return Tournament
     */
    public function addArbiter(string $Arbiter): Tournament
    {
        $newArray = $this->Arbiters;
        $newArray[] = $Arbiter;
        $this->Arbiters = $newArray;
        return $this;
    }

    /**
     * Converts pairings into games with a black and white player
     *
     * @return Tournament
     */
    public function pairingsToRounds(): Tournament
    {
        /** @var Pairing[] $pairings */
        $pairings = $this->Pairings;

        /** @var Pairing[] */
        $cache = array();

        /** @var int[] */
        $lastboards;

        /** @var Pairing $pairing */
        foreach ($pairings as $pairing) {
            // Add pairing to player
            $pairing->Player->addPairing($pairing);
            $round = $pairing->Round;
            $color = $pairing->Color;

            $this->getRoundByNo($round)->addPairing($pairing);
            $opponent = null;

            /**
             * @var int $key
             * @var Pairing $cached
             */
            foreach ($cache as $key=>$cached) {
                if (!is_null($cached)) {
                    if (($cached->Opponent == $pairing->Player) && ($cached->Round == $pairing->Round)) {
                        $opponent = $cached;
                        $cache[$key] = null;
                        break;
                    }
                }
            }
            $game = new Game();
            if ($color->getValue() == Color::White) {
                $game->White = $pairing;
                $game->Black = $opponent;
            } elseif ($color->getValue() == Color::Black) {
                $game->White = $opponent;
                $game->Black = $pairing;
            }

            if (is_null($game->White) || is_null($game->Black)) {
                $cache[] = $pairing;
            } else {
                // Check if game already exists
                if (!$this->gameExists($game, $round)) {
                    $game->Board = $game->White->Board;
                    // Add board if inexistent
                    if ($game->Board == -1) {
                        if (isset($lastboards[$round])) {
                            $lastboards[$round] += 1;
                        } else {
                            $lastboards[$round] = 0;
                        }
                        $game->Board = $lastboards[$round];
                        $game->White->Board = $lastboards[$round];
                        $game->Black->Board = $lastboards[$round];
                    }
                    $this->AddGame($game, $round);
                }
            }
        }
        return $this;
    }

    /**
     * Checks if a game already is already registered
     *
     * @param Game $game
     * @param int $round
     * @return bool
     */
    public function gameExists(Game $game, int $round = -1): bool
    {
        $search = [ $round ];
        if ($round == -1) {
            $search = [];
            for ($i = 0; $i < $this->NoOfRounds; $i++) {
                $search[] = $i;
            }
        }

        foreach ($search as $round) {
            if (!isset($this->Rounds[$round])) {
                return false;
            }
            $games = $this->Rounds[$round]->Games;
            if (is_null($games)) {
                return false;
            }
            foreach ($games as $roundgame) {
                if ($game->equals($roundgame)) {
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
     * @return Tournament
     */
    public function addGame(Game $game, int $round): Tournament
    {
        if (!isset($this->Rounds[$round])) {
            $roundObj = new Round();
            $roundObj->RoundNo = $round;
            $this->addRound($roundObj);
        }

        $this->getRoundByNo($round)->addGame($game);
        return $this;
    }

    /**
     * Gets the ranking of the tournament
     *
     * @return Player[]
     */
    public function getRanking(): array
    {
        $players = $this->Players;
        foreach ($this->Tiebreaks as $tbkey=>$tiebreak) {
            foreach ($players as $pkey => $player) {
                $break = $this->calculateTiebreak($tiebreak, $player, $tbkey);
                $tiebreaks = $player->Tiebreaks;
                $tiebreaks[$tbkey] = $break;
                $player->Tiebreaks = $tiebreaks;
                $this->updatePlayer($pkey, $player);
            }
        }
        $sortedplayers[0] = $players;
        foreach ($this->Tiebreaks as $tbkey=>$tiebreak) {
            $newgroupkey = 0;
            $tosortplayers = $sortedplayers;
            $sortedplayers = [];
            foreach ($tosortplayers as $groupkey=>$sortedplayerselem) {
                usort($tosortplayers[$groupkey], $this->sortTiebreak($tbkey));
                foreach ($tosortplayers[$groupkey] as $playerkey => $player) {
                    if (!is_null($player->Tiebreaks[$tbkey])) {
                        if ($playerkey != 0) {
                            $newgroupkey++;
                            if ($player->Tiebreaks[$tbkey] == $tosortplayers[$groupkey][$playerkey - 1]->Tiebreaks[$tbkey]) {
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
     * Sort by tiebreak
     *
     * @param Player $a
     * @param Player $b
     * @return Closure
     */
    private function sortTiebreak(int $key): Closure
    {
        return function (Player $a, Player $b) use ($key) {
            if (($b->Tiebreaks[$key] == $a->Tiebreaks[$key]) || ($a->Tiebreaks[$key] === false) || ($b->Tiebreaks[$key] === false)) {
                return 0;
            }
            return ($b->Tiebreaks[$key] > $a->Tiebreaks[$key]) ? +1 : -1;
        };
    }


    /**
     * Calculates a specific tiebreak for $player
     *
     * @param Tiebreak $tiebreak
     * @param Player $player
     * @param int $tbkey
     * @return float | null
     */
    private function calculateTiebreak(Tiebreak $tiebreak, Player $player, int $tbkey = 0): ?float
    {
        switch ($tiebreak) {
            case Tiebreak::Keizer:
                return $this->calculateKeizer($player);
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
                return $this->calculateMutualResult($player, $this->Players, $tbkey);
                break;
            case Tiebreak::Aro:
                return $this->calculateAverageRating($player, $this->PriorityElo);
                break;
            case Tiebreak::AroCut:
                return $this->calculateAverageRating($player, $this->PriorityElo, 1);
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
            case Tiebreak::BuchholzCut2:
                return $this->calculateBuchholz($player, 2);
                break;
            case Tiebreak::BuchholzMed2:
                return $this->calculateBuchholz($player, 2, 2);
                break;
            case Tiebreak::Sonneborn:
                return $this->calculateSonneborn($player);
                break;
            case Tiebreak::Kashdan:
                return $this->calculateKashdan($player, ["Won" => 4, "Draw" => 2, "Lost" => 1, "NotPlayed" => 0]);
                break;
            case Tiebreak::SoccerKashdan:
                return $this->calculateKashdan($player, ["Won" => 3, "Draw" => 1, "Lost" => 0, "NotPlayed" => -1]);
                break;
            case Tiebreak::Cumulative:
                return $this->calculateCumulative($player);
                break;
            case Tiebreak::AveragePerformance:
                return $this->calculateAveragePerformance($player, $this->PriorityElo);
                break;
            case Tiebreak::Performance:
                return $player->getPerformance($this->PriorityElo, $this->NonRatedElo);
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
        foreach ($this->Players as $player) {
            $toadd = $player->getElo($this->PriorityElo);
            if ($toadd == 0) {
                $toadd = $this->NonRatedElo;
            }

            $totalrating += $toadd;
            $players++;
        }
        return intdiv($totalrating, $players);
    }

    /**
     * Returns the number of participants
     *
     * @return int
     */
    public function getParticipants(): int
    {
        return count($this->Players);
    }

    /**
     * Points following keizer system
     *
     * @param Player $player
     * @return float | null
     */
    private function calculateKeizer(Player $player): ?float
    {
        return $player->ScoreAmerican;
    }

    /**
     * Number of points
     *
     * @param Player $player
     * @return float | null
     */
    private function calculatePoints(Player $player): ?float
    {
        return $player->calculatePoints();
    }


    /**
     * Number of won games
     *
     * @param Player $player
     * @return float | null
     */
    private function calculateBaumbach(Player $player): ?float
    {
        $totalwins = 0;
        foreach ($player->Pairings as $pairing) {
            if (array_search($pairing->Result, Constants::NotPlayed) === false) {
                if (array_search($pairing->Result, Constants::Won) !== false) {
                    $totalwins++;
                }
            }
        }
        return $totalwins;
    }


    /**
     * Number of played games with black
     *
     * @param Player $player
     * @return float | null
     */
    private function calculateBlackPlayed(Player $player): ?float
    {
        $totalwins = 0;
        foreach ($player->Pairings as $pairing) {
            if (array_search($pairing->Color, Constants::Black) !== false) {
                $totalwins++;
            }
        }
        return $totalwins;
    }

    /**
     * Number of won games with black
     *
     * @param Player $player
     * @return float | null
     */
    private function calculateBlackWin(Player $player): ?float
    {
        $totalwins = 0;
        foreach ($player->Pairings as $pairing) {
            if (array_search($pairing->Color, Constants::Black) !== false && array_search($pairing->Result, Constants::Won) !== false) {
                $totalwins++;
            }
        }
        return $totalwins;
    }


    /**
     * Result between the tied players
     *
     * @param Player $player
     * @param array $opponents
     * @param int $key
     * @return float | null
     */
    private function calculateMutualResult(Player $player, array $opponents, int $key): ?float
    {
        $interestingplayers = $opponents;
        if ($key != 0) {
            $interestingplayers = [];
            $playerstiebreaks = $player->Tiebreaks;
            array_splice($playerstiebreaks, $key);
            foreach ($opponents as $opponent) {
                $opponenttiebreaks = $opponent->Tiebreaks;
                array_splice($opponenttiebreaks, $key);
                if (($playerstiebreaks == $opponenttiebreaks) && ($player != $opponent)) {
                    $interestingplayers[] = $opponent;
                }
            }
        }
        $points = 0;
        $totalmatches = 0;
        foreach ($player->Pairings as $pairing) {
            if (array_search($pairing->Opponent, $interestingplayers) !== false) {
                if (array_search($pairing->Result, Constants::Won) !== false) {
                    $points = $points + 1;
                } elseif (array_search($pairing->Result, Constants::Draw) !== false) {
                    $points = $points + 0.5;
                }
                $totalmatches++;
            }
        }
        if ($totalmatches != count($interestingplayers)) {
            $points = 0;
        }
        return $points;
    }


    /**
     * The average rating of the opponents
     *
     * @param Player $player
     * @param int $cut
     * @return float
     */
    private function calculateAverageRating(Player $player, string $type, int $cut = 0): ?float
    {
        $pairings = $player->Pairings;
        $allratings = [];
        foreach ($pairings as $pairing) {
            if (array_search($pairing->Result, Constants::NotPlayed) === false) {
                $toadd = $pairing->Opponent->getElo($type);
                if ($toadd != 0) {
                    $allratings[] = $toadd;
                }
            }
        }
        sort($allratings);
        $allratings = array_slice($allratings, $cut);
        $tiebreak = 0;
        if (count($allratings) > 0) {
            $tiebreak = round(array_sum($allratings) / count($allratings));
        }
        return $tiebreak;
    }


    /**
     * The average performance of the opponents
     *
     * @param Player $player
     * @param int $cut
     * @return float | null
     */
    private function calculateAveragePerformance(Player $player, string $type, int $cut = 0): ?float
    {
        $pairings = $player->Pairings;
        $allratings = [];
        foreach ($pairings as $pairing) {
            if (array_search($pairing->Result, Constants::NotPlayed) === false) {
                $toadd = $pairing->Opponent->getPerformance($type, $this->NonRatedElo);
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
     * Points against players who have more than $cut % points
     *
     * @param Player $player
     * @param int $cut
     * @return float | null
     */
    private function calculateKoya(Player $player, int $cut = 50): ?float
    {
        $tiebreak = 0;
        foreach ($player->Pairings as $plkey => $plpairing) {
            if (($plpairing->Opponent->Points / count($plpairing->Opponent->Pairings) * 100) >= $cut) {
                if (array_search($plpairing->Result, Constants::Won) !== false) {
                    $tiebreak += 1;
                } elseif (array_search($plpairing->Result, Constants::Draw) !== false) {
                    $tiebreak += 0.5;
                }
            }
        }
        return $tiebreak;
    }


    /**
     * The combined points of the opponents
     * @param Player $player
     * @param int $cutlowest
     * @param int $cuthighest
     * @return float | null
     */
    private function calculateBuchholz(Player $player, int $cutlowest = 0, int $cuthighest = 0): ?float
    {
        $tiebreak = 0;
        $intpairingsWithBye = $player->Pairings;

        $intpairings = [];
        $curpoints = 0;
        $curround = 1;
        foreach ($intpairingsWithBye as $pairing) {
            $roundstoplay = (count($intpairingsWithBye)) - $curround;
            if (is_null($pairing->Opponent)) {
                $forfait = explode(' ', $pairing->Result)[0]+0;
                $notaplayer = $curpoints + (1 - $forfait) + 0.5 * $roundstoplay;
                $intpairings[] = $notaplayer;
            } else {
                $intpairings[] = $pairing->Opponent->PointsForBuchholz;
                if (array_search($pairing->Result, Constants::Won) !== false) {
                    $curpoints += 1;
                } elseif (array_search($pairing->Result, Constants::Draw) !== false) {
                    $curpoints += 0.5;
                }
            }
            $curround++;
        }

        usort($intpairings, function ($a, $b) {
            if ($b == $a) {
                return 0;
            }
            return ($a > $b) ? 1 : -1;
        });

        $intpairings = array_slice($intpairings, $cutlowest);
        $intpairings = array_slice($intpairings, 0 - $cuthighest);

        return array_sum($intpairings);
    }


    /**
     * The points of $player's opponents who $player won against, plus half of the points of $player's opponents who $player drew against
     *
     * @param Player $player
     * @return float | null
     */
    private function calculateSonneborn(Player $player): ?float
    {
        $tiebreak = 0;
        foreach ($player->Pairings as $key => $pairing) {
            if ($pairing->Opponent) {
                if (array_search($pairing->Result, Constants::Won) !== false) {
                    $tiebreak += $pairing->Opponent->Points;
                } elseif (array_search($pairing->Result, Constants::Draw) !== false) {
                    $tiebreak += $pairing->Opponent->Points / 2;
                }
            }
        }
        return $tiebreak;
    }


    /**
     * $points["Won"] points for each win, $points["Draw"] for each draw and $points["Lost"] point for losing. $points["NotPlayed"] points for not played games
     *
     * @param Player $player
     * @param int[] $points
     * @return float | null
     */
    private function calculateKashdan(Player $player, array $points): ?float
    {
        $tiebreak = 0;
        foreach ($player->Pairings as $pairing) {
            $toadd = 0;
            if (array_search($pairing->Result, Constants::Won) !== false) {
                $toadd = $points["Won"];
            } elseif (array_search($pairing->Result, Constants::Draw) !== false) {
                $toadd = $points["Draw"];
            } elseif (array_search($pairing->Result, Constants::Lost) !== false) {
                $toadd = $points["Lost"];
            }

            if (array_search($pairing->Result, Constants::NotPlayed) !== false) {
                $toadd = $points["NotPlayed"];
            }
            $tiebreak += $toadd;
        }
        return $tiebreak; // - $player->NoOfWins;
    }

    /**
     * Combined score of $player after each round
     *
     * @param Player $player
     * @return float | null
     */
    private function calculateCumulative(Player $player): ?float
    {
        $tiebreak = 0;
        $score = [];
        foreach ($player->Pairings as $pairing) {
            $toadd = 0;
            if (array_search($pairing->Result, Constants::Won) !== false) {
                $toadd = 1;
            } elseif (array_search($pairing->Result, Constants::Draw) !== false) {
                $toadd = 0.5;
            }
            $tiebreak += $toadd;
            $score[] = $tiebreak;
        }
        return array_sum($score);
    }

    /**
     * Returns binary data that was read out the pairing file but was not needed immediately
     *
     * @param string $Key
     * @return bool|DateTime|int|string|null
     */
    public function __get(string $Key)
    {
        if (isset($this->BinaryData[$Key])) {
            return $this->BinaryData[$Key];
        }
        return null;
    }

    /**
     * Sets binary data that is read out the pairing file but is not needed immediately
     *
     * @param string $Key
     * @param bool|int|DateTime|string $Value
     * @return void
     */
    public function __set(string $Key, $Value): void
    {
        $this->BinaryData[$Key] = $Value;
    }
}
