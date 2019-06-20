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

use Closure;
use DateTime;
use JeroenED\Libpairtwo\Enums\Tiebreak;
use JeroenED\Libpairtwo\Enums\Color;
use JeroenED\Libpairtwo\Enums\TournamentSystem;

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
    private $Name;

    /** @var string */
    private $Organiser;

    /** @var int */
    private $OrganiserClubNo;

    /** @var string */
    private $OrganiserClub;

    /** @var string */
    private $OrganiserPlace;

    /** @var string */
    private $OrganiserCountry;

    /** @var int */
    private $FideHomol;

    /** @var DateTime */
    private $StartDate;

    /** @var DateTime */
    private $EndDate;

    /** @var string */
    private $Arbiter;

    /** @var int */
    private $NoOfRounds;

    /** @var Round[] */
    private $Rounds = [];

    /** @var string */
    private $Tempo;

    /** @var int */
    private $NonRatedElo;

    /** @var TournamentSystem */
    private $System;

    /** @var string */
    private $FirstPeriod;

    /** @var string */
    private $SecondPeriod;

    /** @var string */
    private $Federation;

    /** @var Player[] */
    private $Players = [];

    /** @var int */
    private $Year;

    /** @var Pairing[] */
    private $Pairings = [];

    /** @var Tiebreak[] */
    private $Tiebreaks = [];

    /** @var string */
    private $PriorityElo = 'Fide';

    /** @var string */
    private $PriorityId = 'Nation';

    /**
     * Gets a player by its ID
     *
     * @param integer $id
     * @return Player
     */
    public function getPlayerById(int $id): Player
    {
        return $this->GetPlayers()[$id];
    }

    /**
     * Adds a player
     *
     * @param Player $Player
     * @return Tournament
     */
    public function addPlayer(Player $Player): Tournament
    {
        $newArray = $this->GetPlayers();
        $newArray[] = $Player;
        $this->setPlayers($newArray);
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
        $newArray = $this->GetPlayers();
        $newArray[$id] = $player;
        $this->setPlayers($newArray);
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
        $newArray = $this->getTiebreaks();
        $newArray[] = $tiebreak;
        $this->setTiebreaks($newArray);
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
        $newArray = $this->getRounds();
        $newArray[$round->getRoundNo()] = $round;
        $this->setRounds($newArray);
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
        return $this->getRounds()[$roundNo];
    }

    /**
     * Adds a pairing to the tournament
     *
     * @param Pairing $pairing
     * @return Tournament
     */
    public function addPairing(Pairing $pairing): Tournament
    {
        $newArray = $this->GetPairings();
        $newArray[] = $pairing;
        $this->setPairings($newArray);
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
                if (!$this->gameExists($game, $round)) {
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
     * @return Tournament
     */
    public function addGame(Game $game, int $round): Tournament
    {
        if (!isset($this->getRounds()[$round])) {
            $roundObj = new Round();
            $roundObj->setRoundNo($round);
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
     * @return Closure
     */

    private function sortTiebreak(int $key): Closure
    {
        return function (Player $a, Player $b) use ($key) {
            if (($b->getTiebreaks()[$key] == $a->getTiebreaks()[$key]) || ($a->getTiebreaks()[$key] === false) || ($b->getTiebreaks()[$key] === false)) {
                return 0;
            }
            return ($b->getTiebreaks()[$key] > $a->getTiebreaks()[$key]) ? +1 : -1;
        };
    }


    /**
     * @return float | null
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
                return $this->calculateAverageRating($player, $this->getPriorityElo());
                break;
            case Tiebreak::AroCut:
                return $this->calculateAverageRating($player, $this->getPriorityElo(), 1);
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
            case Tiebreak::SoccerKashdan:
                return $this->calculateSoccerKashdan($player);
                break;
            case Tiebreak::Cumulative:
                return $this->calculateCumulative($player);
                break;
            case Tiebreak::AveragePerformance:
                return $this->calculateAveragePerformance($player, $this->getPriorityElo());
                break;
            case Tiebreak::Performance:
                return $player->getPerformance($this->getPriorityElo(), $this->getNonRatedElo());
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

    /**
     * Returns the number of participants
     *
     * @return int
     */
    public function getParticipants(): int
    {
        return count($this->getPlayers());
    }

    /**
     * @param Player $player
     * @return float | null
     */
    private function calculateKeizer(Player $player): ?float
    {
        return $player->getBinaryData('ScoreAmerican');
    }


    /**
     * @param Player $player
     * @return float | null
     */
    private function calculateAmerican(Player $player): ?float
    {
        return $player->getBinaryData('ScoreAmerican');
    }


    /**
     * @param Player $player
     * @return float | null
     */
    private function calculatePoints(Player $player): ?float
    {
        return $player->getPoints();
    }


    /**
     * @param Player $player
     * @return float | null
     */
    private function calculateBaumbach(Player $player): ?float
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
     * @return float | null
     */
    private function calculateBlackPlayed(Player $player): ?float
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
     * @return float | null
     */
    private function calculateBlackWin(Player $player): ?float
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
            $playerstiebreaks = $player->getTiebreaks();
            array_splice($playerstiebreaks, $key);
            foreach ($opponents as $opponent) {
                $opponenttiebreaks = $opponent->getTiebreaks();
                array_splice($opponenttiebreaks, $key);
                if (($playerstiebreaks == $opponenttiebreaks) && ($player != $opponent)) {
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
     * The average rating of the opponents
     *
     * @param Player $player
     * @param int $cut
     * @return float
     */
    private function calculateAverageRating(Player $player, string $type, int $cut = 0): ?float
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
     * The average performance of the opponents
     *
     * @param Player $player
     * @param int $cut
     * @return float | null
     */
    private function calculateAveragePerformance(Player $player, string $type, int $cut = 0): ?float
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
     * Points against players who have more than $cut % points
     *
     * @param Player $player
     * @param int $cut
     * @return float | null
     */
    private function calculateKoya(Player $player, int $cut = 50): ?float
    {
        $tiebreak = 0;
        foreach ($player->getPairings() as $plkey => $plpairing) {
            if (($plpairing->getOpponent()->getPoints() / count($plpairing->getOpponent()->getPairings()) * 100) >= $cut) {
                if (array_search($plpairing->getResult(), Constants::Won) !== false) {
                    $tiebreak += 1;
                } elseif (array_search($plpairing->getResult(), Constants::Draw) !== false) {
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
        $intpairings = $player->getPairings();

        usort($intpairings, function ($a, $b) {
            if (is_null($a->getOpponent())) {
                return -1;
            }
            if (is_null($b->getOpponent())) {
                return 1;
            }

            if ($b->getOpponent()->getPoints() == $a->getOpponent()->getPoints()) {
                return 0;
            }
            return ($a->getOpponent()->getPoints() > $b->getOpponent()->getPoints()) ? 1 : -1;
        });

        $intpairings = array_slice($intpairings, $cutlowest);
        $intpairings = array_slice($intpairings, 0 - $cuthighest);

        foreach ($intpairings as $intkey => $intpairing) {
            if (!is_null($intpairing->getOpponent())) {
                $tiebreak += $intpairing->getOpponent()->getPoints();
            }
        }
        return $tiebreak;
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
     * 3 points for each, 1 for each draw and no for losing. -1 for not played games
     *
     * @param Player $player
     * @return float | null
     */
    private function calculateSoccerKashdan(Player $player): ?float
    {
        $tiebreak = 0;
        foreach ($player->getPairings() as $pairing) {
            $toadd = 0;
            if (array_search($pairing->getResult(), Constants::Won) !== false) {
                $toadd = 3;
            } elseif (array_search($pairing->getResult(), Constants::Draw) !== false) {
                $toadd = 1;
            } elseif (array_search($pairing->getResult(), Constants::Lost) !== false) {
                $toadd = 0;
            }

            if (array_search($pairing->getResult(), Constants::NotPlayed) !== false) {
                $toadd = -1;
            }
            $tiebreak += $toadd;
        }
        return $tiebreak; // - $player->getNoOfWins();
    }

    /**
     * 4 points for each, 2 for each draw and 1 point for losing. 0 points for not played games
     *
     * @param Player $player
     * @return float | null
     */
    private function calculateKashdan(Player $player): ?float
    {
        $tiebreak = 0;
        foreach ($player->getPairings() as $pairing) {
            $toadd = 0;
            if (array_search($pairing->getResult(), Constants::Won) !== false) {
                $toadd = 4;
            } elseif (array_search($pairing->getResult(), Constants::Draw) !== false) {
                $toadd = 2;
            } elseif (array_search($pairing->getResult(), Constants::Lost) !== false) {
                $toadd = 1;
            }

            if (array_search($pairing->getResult(), Constants::NotPlayed) !== false) {
                $toadd = 0;
            }
            $tiebreak += $toadd;
        }
        return $tiebreak; // - $player->getNoOfWins();
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
        foreach ($player->getPairings() as $pairing) {
            $toadd = 0;
            if (array_search($pairing->getResult(), Constants::Won) !== false) {
                $toadd = 1;
            } elseif (array_search($pairing->getResult(), Constants::Draw) !== false) {
                $toadd = 0.5;
            }
            $tiebreak += $toadd;
            $score[] = $tiebreak;
        }
        return array_sum($score);
    }

    /**
     * Returns the name of the tournament
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->Name;
    }

    /**
     * Sets the name of the tournament
     *
     * @param string $Name
     * @return Tournament
     */
    public function setName(string $Name): Tournament
    {
        $this->Name = $Name;
        return $this;
    }

    /**
     * Returns the organiser of the tournament
     *
     * @return string
     */
    public function getOrganiser(): string
    {
        return $this->Organiser;
    }

    /**
     * Sets the organiser of the tournament
     *
     * @param string $Organiser
     * @return Tournament
     */
    public function setOrganiser(string $Organiser): Tournament
    {
        $this->Organiser = $Organiser;
        return $this;
    }

    /**
     * Returns the clubidentifier of the tournament
     *
     * @return int
     */
    public function getOrganiserClubNo(): int
    {
        return $this->OrganiserClubNo;
    }

    /**
     * Sets the clubidentifier of the tournament
     *
     * @param int $OrganiserClubNo
     * @return Tournament
     */
    public function setOrganiserClubNo(int $OrganiserClubNo): Tournament
    {
        $this->OrganiserClubNo = $OrganiserClubNo;
        return $this;
    }

    /**
     * Returns the club of the organiser
     *
     * @return string
     */
    public function getOrganiserClub(): string
    {
        return $this->OrganiserClub;
    }

    /**
     * Sets the club of the organiser
     *
     * @param string $OrganiserClub
     * @return Tournament
     */
    public function setOrganiserClub(string $OrganiserClub): Tournament
    {
        $this->OrganiserClub = $OrganiserClub;
        return $this;
    }

    /**
     * Returns the location of the tournament
     *
     * @return string
     */
    public function getOrganiserPlace(): string
    {
        return $this->OrganiserPlace;
    }

    /**
     * Sets the location of the tournament
     *
     * @param string $OrganiserPlace
     * @return Tournament
     */
    public function setOrganiserPlace(string $OrganiserPlace): Tournament
    {
        $this->OrganiserPlace = $OrganiserPlace;
        return $this;
    }

    /**
     * Returns the country where the tournament is held
     *
     * @return string
     */
    public function getOrganiserCountry(): string
    {
        return $this->OrganiserCountry;
    }

    /**
     * Sets the country where the tournament is held
     *
     * @param string $OrganiserCountry
     * @return Tournament
     */
    public function setOrganiserCountry(string $OrganiserCountry): Tournament
    {
        $this->OrganiserCountry = $OrganiserCountry;
        return $this;
    }

    /**
     * Returns the fide homologation
     *
     * @return int
     */
    public function getFideHomol(): int
    {
        return $this->FideHomol;
    }

    /**
     * Sets the fide homologation
     *
     * @param int $FideHomol
     * @return Tournament
     */
    public function setFideHomol(int $FideHomol): Tournament
    {
        $this->FideHomol = $FideHomol;
        return $this;
    }

    /**
     * Returns the start date of the tournament
     *
     * @return DateTime
     */
    public function getStartDate(): DateTime
    {
        return $this->StartDate;
    }

    /**
     * Sets the start date of the tournament
     *
     * @param DateTime $StartDate
     * @return Tournament
     */
    public function setStartDate(DateTime $StartDate): Tournament
    {
        $this->StartDate = $StartDate;
        return $this;
    }

    /**
     * Returns the end date of the tournament
     *
     * @return DateTime
     */
    public function getEndDate(): DateTime
    {
        return $this->EndDate;
    }

    /**
     * Sets the end date of the tournament
     *
     * @param DateTime $EndDate
     * @return Tournament
     */
    public function setEndDate(DateTime $EndDate): Tournament
    {
        $this->EndDate = $EndDate;
        return $this;
    }

    /**
     * Returns the arbiter of the tournament
     *
     * @return string
     */
    public function getArbiter(): string
    {
        return $this->Arbiter;
    }

    /**
     * Sets the arbiter of the tournament
     *
     * @param string $Arbiter
     * @return Tournament
     */
    public function setArbiter(string $Arbiter): Tournament
    {
        $this->Arbiter = $Arbiter;
        return $this;
    }

    /**
     * Returns the number of round
     *
     * @return int
     */
    public function getNoOfRounds(): int
    {
        return $this->NoOfRounds;
    }

    /**
     * Sets the number of rounds
     *
     * @param int $NoOfRounds
     * @return Tournament
     */
    public function setNoOfRounds(int $NoOfRounds): Tournament
    {
        $this->NoOfRounds = $NoOfRounds;
        return $this;
    }

    /**
     * Returns an array containing all rounds of the tournament
     *
     * @return Round[]
     */
    public function getRounds(): array
    {
        return $this->Rounds;
    }

    /**
     * Sets an array containing all rounds of the tournament
     *
     * @param Round[] $Rounds
     * @return Tournament
     */
    public function setRounds(array $Rounds): Tournament
    {
        $this->Rounds = $Rounds;
        return $this;
    }

    /**
     * Returns the tempo of the tournament
     *
     * @return string
     */
    public function getTempo(): string
    {
        return $this->Tempo;
    }

    /**
     * Sets the tempo of the tournament
     *
     * @param string $Tempo
     * @return Tournament
     */
    public function setTempo(string $Tempo): Tournament
    {
        $this->Tempo = $Tempo;
        return $this;
    }

    /**
     * Returns the elo of a player if the player does not have one
     *
     * @return int
     */
    public function getNonRatedElo(): int
    {
        return $this->NonRatedElo;
    }

    /**
     * Sets the elo of a player if the player does not have one
     *
     * @param int $NonRatedElo
     * @return Tournament
     */
    public function setNonRatedElo(int $NonRatedElo): Tournament
    {
        $this->NonRatedElo = $NonRatedElo;
        return $this;
    }

    /**
     * Returns the tournament system
     *
     * @return TournamentSystem
     */
    public function getSystem(): TournamentSystem
    {
        return $this->System;
    }

    /**
     * Sets the tournament system
     *
     * @param TournamentSystem $System
     * @return Tournament
     */
    public function setSystem(TournamentSystem $System): Tournament
    {
        $this->System = $System;
        return $this;
    }

    /**
     * Returns the first period of the tempo
     *
     * @return string
     */
    public function getFirstPeriod(): string
    {
        return $this->FirstPeriod;
    }

    /**
     * Sets the first period of the tempo
     *
     * @param string $FirstPeriod
     * @return Tournament
     */
    public function setFirstPeriod(string $FirstPeriod): Tournament
    {
        $this->FirstPeriod = $FirstPeriod;
        return $this;
    }

    /**
     * Returns the second period of the tempo
     *
     * @return string
     */
    public function getSecondPeriod(): string
    {
        return $this->SecondPeriod;
    }

    /**
     * Sets the second period of the tempo
     *
     * @param string $SecondPeriod
     * @return Tournament
     */
    public function setSecondPeriod(string $SecondPeriod): Tournament
    {
        $this->SecondPeriod = $SecondPeriod;
        return $this;
    }

    /**
     * Returns the federation the tournament belongs to
     *
     * @return string
     */
    public function getFederation(): string
    {
        return $this->Federation;
    }

    /**
     * Sets the federation the tournament belongs to
     *
     * @param string $Federation
     * @return Tournament
     */
    public function setFederation(string $Federation): Tournament
    {
        $this->Federation = $Federation;
        return $this;
    }

    /**
     * Returns an array of all players of the tournament
     *
     * @return Player[]
     */
    public function getPlayers(): array
    {
        return $this->Players;
    }

    /**
     * Sets an array of all players of the tournament
     *
     * @param Player[] $Players
     * @return Tournament
     */
    public function setPlayers(array $Players): Tournament
    {
        $this->Players = $Players;
        return $this;
    }

    /**
     * Returns the year the tournament is held in
     *
     * @return int
     */
    public function getYear(): int
    {
        return $this->Year;
    }

    /**
     * Sets the year the tournament is held in
     *
     * @param int $Year
     * @return Tournament
     */
    public function setYear(int $Year): Tournament
    {
        $this->Year = $Year;
        return $this;
    }

    /**
     * Returns an array of all pairings of the tournament
     *
     * @return Pairing[]
     */
    public function getPairings(): array
    {
        return $this->Pairings;
    }

    /**
     * Sets an array of all pairings of the tournament
     *
     * @param Pairing[] $Pairings
     * @return Tournament
     */
    public function setPairings(array $Pairings): Tournament
    {
        $this->Pairings = $Pairings;
        return $this;
    }

    /**
     * Returns an array of all tiebreaks of the tournament
     *
     * @return Tiebreak[]
     */
    public function getTiebreaks(): array
    {
        return $this->Tiebreaks;
    }

    /**
     * Sets an array of all tiebreaks of the tournament
     *
     * @param Tiebreak[] $Tiebreaks
     * @return Tournament
     */
    public function setTiebreaks(array $Tiebreaks): Tournament
    {
        $this->Tiebreaks = $Tiebreaks;
        return $this;
    }

    /**
     * Returns the elo that has priority
     *
     * @return string
     */
    public function getPriorityElo(): string
    {
        return $this->PriorityElo;
    }

    /**
     * Sets the elo that has priority
     *
     * @param string $PriorityElo
     * @return Tournament
     */
    public function setPriorityElo(string $PriorityElo): Tournament
    {
        $this->PriorityElo = $PriorityElo;
        return $this;
    }
    /**
     * Returns the identifier that has priority
     *
     * @return string
     */
    public function getPriorityId(): string
    {
        return $this->PriorityId;
    }

    /**
     * Sets the identifier that has priority
     *
     * @param string $PriorityId
     * @return Tournament
     */
    public function setPriorityId(string $PriorityId): Tournament
    {
        $this->PriorityId = $PriorityId;
        return $this;
    }
}
