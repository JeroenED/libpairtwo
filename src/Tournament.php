<?php
/**
 * The file contains the Tournament class which takes care of almost every element in your tournament
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
    /**
     * Name of the Tournament
     *
     * @var string
     */
    public $Name;

    /**
     * Organiser of the tournament (eg. Donald J. Trump)
     *
     *
     * @var string
     */
    public $Organiser;

    /**
     * Club ID of the tournament organiser (eg. 205001600)
     *
     * @var string
     */
    public $OrganiserClubNo;

    /**
     * Club name of the tournament organiser (eg. The White House Chess Club)
     *
     * @var string
     */
    public $OrganiserClub;

    /**
     * Place where the Tounament is held (eg. The Oval Office)
     *
     * @var string
     */
    public $OrganiserPlace;

    /**
     * The country where the tournament is held
     *
     * @var string
     */
    public $OrganiserCountry;

    /**
     * Whether or not the tournament is an official tournament and send to the world chess organisation
     *
     * @var int
     */
    public $FideHomol;

    /**
     * Start date (First round or Players meeting) of the tournament
     * @var DateTime
     */
    public $StartDate;

    /**
     * End date (Last round or Award Ceremony) of the tournament
     *
     * @var DateTime
     */
    public $EndDate;

    /**
     * An Array of the assigned arbiters
     *
     * @var string[]
     */
    public $Arbiters;

    /**
     * Number of round the tournament has
     *
     * @var int
     */
    public $NoOfRounds;

    /**
     * Round objects of all rounds in the tournament
     *
     * @var Round[]
     */
    public $Rounds = [];

    /**
     * The tempo of the tournament (eg. 90 min/40 moves + 30 sec. increment starting from move 1)
     * @var string
     */
    public $Tempo;

    /**
     * The elo a player gets if he does not have an official elo
     *
     * @var int
     */
    public $NonRatedElo;

    /**
     * The system the tournament (eg. Swiss, Closed, American)
     *
     * @var TournamentSystem
     */
    public $System;

    /**
     * The tempo for the first period of a game in the tournament
     *
     * @var string
     */
    public $FirstPeriod;

    /**
     * The tempo for the second period of a game in the tournament
     *
     * @var string
     */
    public $SecondPeriod;

    /**
     * The federation for which this tournament is held
     *
     * @var string
     */
    public $Federation;

    /**
     * All players of the tournament
     *
     * @var Player[]
     */
    public $Players = [];

    /**
     * The year or season the tournament is held or is count for
     *
     * @var int
     */
    public $Year;

    /**
     * All pairings of the tournament
     *
     * @var Pairing[]
     */
    public $Pairings = [];

    /**
     * The tiebreaks for the tournament
     *
     * @var Tiebreak[]
     */
    public $Tiebreaks = [];

    /**
     * The elo that priority above all others
     *
     * @var string
     */
    public $PriorityElo = 'Fide';

    /**
     * The Id that has priority above all other
     *
     * @var string
     */
    public $PriorityId = 'Nation';

    /**
     * Binary data that was read out of the pairing file
     *
     * @var bool|DateTime|int|string[]
     */
    private $BinaryData = [];

    /**
     * Gets a player by its ID
     *
     * @param integer $id
     * @return Player
     */
    public function PlayerById(int $id): Player
    {
        return $this->Players[$id];
    }

    /**
     * Adds a player
     *
     * @param Player $Player
     *
     */
    public function addPlayer(Player $Player): void
    {
        $newArray = $this->Players;
        $newArray[] = $Player;
        $this->Players = $newArray;
    }

    /**
     * Updates player on id to the given Player object
     *
     * @param int $id
     * @param Player $player
     *
     */
    public function updatePlayer(int $id, Player $player): void
    {
        $newArray = $this->Players;
        $newArray[$id] = $player;
        $this->Players = $newArray;
    }

    /**
     * Adds a Tiebreak
     *
     * @param Tiebreak $tiebreak
     *
     */
    public function addTiebreak(Tiebreak $tiebreak): void
    {
        $newArray = $this->Tiebreaks;
        $newArray[] = $tiebreak;
        $this->Tiebreaks = $newArray;
    }

    /**
     * Adds a round with given Round object
     *
     * @param Round $round
     *
     */
    public function addRound(Round $round): void
    {
        $newArray = $this->Rounds;
        $newArray[$round->RoundNo] = $round;
        $this->Rounds = $newArray;
    }

    /**
     * Gets a round by its number.
     *
     * @param int $roundNo
     * @return Round
     */
    public function RoundByNo(int $roundNo): Round
    {
        return $this->Rounds[$roundNo];
    }

    /**
     * Adds a pairing to the tournament
     *
     * @param Pairing $pairing
     *
     */
    public function addPairing(Pairing $pairing): void
    {
        $newArray = $this->Pairings;
        $newArray[] = $pairing;
        $this->Pairings = $newArray;
    }


    /**
     * Adds an arbiter to the tournament
     *
     * @param string $Arbiter
     *
     */
    public function addArbiter(string $Arbiter): void
    {
        $newArray = $this->Arbiters;
        $newArray[] = $Arbiter;
        $this->Arbiters = $newArray;
    }

    /**
     * Converts pairings into games with a black and white player
     *
     *
     */
    public function pairingsToRounds(): void
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

            $this->RoundByNo($round)->addPairing($pairing);
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
     *
     */
    public function addGame(Game $game, int $round): void
    {
        if (!isset($this->Rounds[$round])) {
            $roundObj = new Round();
            $roundObj->RoundNo = $round;
            $this->addRound($roundObj);
        }

        $this->RoundByNo($round)->addGame($game);
    }

    /**
     * Gets the ranking of the tournament
     *
     * @return Player[]
     */
    private function ranking(): array
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
     * @param int $key
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
     * @return float
     */
    private function calculateTiebreak(Tiebreak $tiebreak, Player $player, int $tbkey = 0): float
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
                return $player->Performance($this->PriorityElo, $this->NonRatedElo);
                break;
            default:
                return 0;
        }
    }

    /**
     * Return the average rating for tournament
     *
     * @return int
     */
    private function averageElo(): int
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
    private function participants(): int
    {
        return count($this->Players);
    }

    /**
     * Points following keizer system
     *
     * @param Player $player
     * @return float
     */
    private function calculateKeizer(Player $player): float
    {
        return $player->ScoreAmerican;
    }

    /**
     * Number of points
     *
     * @param Player $player
     * @return float
     */
    private function calculatePoints(Player $player): float
    {
        return $player->calculatePoints();
    }


    /**
     * Number of won games
     *
     * @param Player $player
     * @return float
     */
    private function calculateBaumbach(Player $player): float
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
     * @return float
     */
    private function calculateBlackPlayed(Player $player): float
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
     * @return float
     */
    private function calculateBlackWin(Player $player): float
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
     * @return float
     */
    private function calculateMutualResult(Player $player, array $opponents, int $key): float
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
        if ($interestingplayers) {
            $allintplayers = $interestingplayers;
            $allintplayers[] = $player;
            foreach ($allintplayers as $player) {
                if (!$player->hasPlayedAllPlayersOfArray($allintplayers)) {
                    return 0;
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
     * @param string $type
     * @param int $cut
     * @return float
     */
    private function calculateAverageRating(Player $player, string $type, int $cut = 0): float
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
     * @param string $type
     * @param int $cut
     * @return float
     */
    private function calculateAveragePerformance(Player $player, string $type, int $cut = 0): float
    {
        $pairings = $player->Pairings;
        $allratings = [];
        foreach ($pairings as $pairing) {
            if (array_search($pairing->Result, Constants::NotPlayed) === false) {
                $toadd = $pairing->Opponent->Performance($type, $this->NonRatedElo);
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
     * @return float
     */
    private function calculateKoya(Player $player, int $cut = 50): float
    {
        $tiebreak = 0;
        foreach ($player->Pairings as $plkey => $plpairing) {
            if (($plpairing->Opponent->calculatePoints() / count($plpairing->Opponent->Pairings) * 100) >= $cut) {
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
     * @return float
     */
    private function calculateBuchholz(Player $player, int $cutlowest = 0, int $cuthighest = 0): float
    {
        $tiebreak = 0;
        $intpairingsWithBye = $player->Pairings;

        $intpairings = [];
        $curpoints = 0;
        $curround = 1;
        foreach ($intpairingsWithBye as $key=>$pairing) {
            $roundstoplay = (count($intpairingsWithBye)) - $curround;
            if (is_null($pairing->Opponent)) {
                $intpairings[] = $player->calculatePointsForVirtualPlayer($key);
            } else {
                $intpairings[] = $pairing->Opponent->calculatePointsForTiebreaks();
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
     * @return float
     */
    private function calculateSonneborn(Player $player): float
    {
        $tiebreak = 0;
        foreach ($player->Pairings as $key => $pairing) {
            if ($pairing->Opponent) {
                if (array_search($pairing->Result, Constants::Won) !== false) {
                    $tiebreak += $pairing->Opponent->calculatePointsForTiebreaks();
                } elseif (array_search($pairing->Result, Constants::Draw) !== false) {
                    $tiebreak += $pairing->Opponent->calculatePointsForTiebreaks() / 2;
                }
            }
            if (array_search($pairing->Result, Constants::NotPlayed) !== false) {
                $tiebreak += $player->calculatePointsForVirtualPlayer($key);
            }
        }
        return $tiebreak;
    }


    /**
     * $points["Won"] points for each win, $points["Draw"] for each draw and $points["Lost"] point for losing. $points["NotPlayed"] points for not played games
     *
     * @param Player $player
     * @param int[] $points
     * @return float
     */
    private function calculateKashdan(Player $player, array $points): float
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
     * @return float
     */
    private function calculateCumulative(Player $player): float
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
     * Magic method to read out several fields. If field was not found it is being searched in the binary data fields
     *
     * @param string $key
     * @return bool|DateTime|int|string|null
     */
    public function __get(string $key)
    {
        if ($key == 'Participants') {
            return $this->participants();
        } elseif ($key == 'AverageElo') {
            return $this->averageElo();
        } elseif ($key == 'Ranking') {
            return $this->ranking();
        } elseif (isset($this->BinaryData[$key])) {
            return $this->BinaryData[$key];
        }
        return null;
    }

    /**
     * Sets binary data that is read out the pairing file but is not needed immediately
     *
     * @param string $key
     * @param bool|int|DateTime|string $value
     * @return void
     */
    public function __set(string $key, $value): void
    {
        $this->BinaryData[$key] = $value;
    }
}
