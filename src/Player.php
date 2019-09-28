<?php
/**
 * Class Player
 *
 * Class for a player of the tournament
 *
 * @author      Jeroen De Meerleer <schaak@jeroened.be>
 * @category    Main
 * @package     Libpairtwo
 * @copyright   Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */

namespace JeroenED\Libpairtwo;

use JeroenED\Libpairtwo\Enums\Gender;
use JeroenED\Libpairtwo\Enums\Title;
use DateTime;

/**
 * Class Player
 *
 * Class for a player of the tournament
 *
 * @author      Jeroen De Meerleer <schaak@jeroened.be>
 * @category    Main
 * @package     Libpairtwo
 * @copyright   Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */
class Player
{
    /** @var string */
    private $Name;

    /** @var int[] */
    private $Ids;

    /** @var int[] */
    private $Elos;

    /** @var DateTime */
    private $DateOfBirth;

    /** @var float[] */
    private $Tiebreaks = [];

    /** @var string */
    private $Nation;

    // TODO: Implement categories
    /** @var string */
    private $Category;

    /** @var Title */
    private $Title;

    /** @var Gender */
    private $Gender;

    /** @var Pairing[] */
    private $Pairings = [];

    /** @var bool|DateTime|int|string[] */
    private $BinaryData;

    /**
     * Adds a pairing to the tournament
     *
     * @param Pairing $pairing
     * @return Player
     */
    public function addPairing(Pairing $pairing): Player
    {
        $newArray = $this->GetPairings();
        $newArray[] = $pairing;
        $this->setPairings($newArray);
        return $this;
    }

    /**
     * Returns an array of Player objects where name matches $search
     *
     * @param string $search
     * @param Tournament $tournament
     * @return Player[]
     */
    public static function getPlayersByName(string $search, Tournament $tournament): array
    {
        /** @var Player[] */
        $players = $tournament->getPlayers();

        /** @var Player[] */
        $return = [];

        foreach ($players as $player) {
            if (fnmatch($search, $player->getName())) {
                $return[] = $player;
            }
        }

        return $return;
    }

    /**
     * Returns the elo of elotype for the player
     * @param string $type
     * @return int
     */
    public function getElo(string $type): int
    {
        return $this->getElos()[$type];
    }

    /**
     * Sets the elo of elotype for the player
     *
     * @param string $type
     * @param int $value
     * @return Player
     */
    public function setElo(string $type, int $value): Player
    {
        $currentElos = $this->getElos();
        $currentElos[$type] = $value;
        $this->setElos($currentElos);
        return $this;
    }

    /**
     * Returns the identifier of type for the player
     *
     * Common possible values are Fide or National
     *
     * @param string $type
     * @return string
     */
    public function getId(string $type): string
    {
        return $this->getIds()[$type];
    }

    /**
     * Sets the identifier of type for the player
     *
     * Common possible values are Fide or National
     *
     * @param string $type
     * @param string $value
     * @return Player
     */
    public function setId(string $type, string $value): Player
    {
        $currentIds = $this->getIds();
        $currentIds[$type] = $value;
        $this->setIds($currentIds);
        return $this;
    }

    /**
     * Returns the number of won matches for the player
     *
     * @return int
     */
    public function getNoOfWins(): int
    {
        $wins = 0;
        foreach ($this->getPairings() as $pairing) {
            if (array_search($pairing->getResult(), Constants::Won) !== false) {
                $wins++;
            }
        }
        return $wins;
    }

    /**
     * Returns the points of the player.
     *
     * 1 Point is awarded for winning
     * 0.5 points are awarded for draw
     *
     * @return float
     */
    public function getPoints(): float
    {
        $points = 0;
        foreach ($this->getPairings() as $pairing) {
            if (array_search($pairing->getResult(), Constants::Won) !== false) {
                $points = $points + 1;
            } elseif (array_search($pairing->getResult(), Constants::Draw) !== false) {
                $points = $points + 0.5;
            }
        }
        return $points;
    }

    /**
     * Returns the points of the player that should be used for buchholz.
     *
     * 1 Point is awarded for winning
     * 0.5 points are awarded for draw
     * 0.5 points for not played
     *
     * @return float
     */
    public function getPointsForBuchholz(): float
    {
        $points = 0;
        foreach ($this->getPairings() as $pairing) {
            if (array_search($pairing->getResult(), Constants::NotPlayed) !== false) {
                $points = $points + 0.5;
            } elseif (array_search($pairing->getResult(), Constants::Won) !== false) {
                $points = $points + 1;
            } elseif (array_search($pairing->getResult(), Constants::Draw) !== false) {
                $points = $points + 0.5;
            }
        }
        return $points;
    }
    /**
     * Returns the performance rating of the player
     *
     * WARNING: Calculation currently incorrect. Uses the rule of 400 as temporary solution
     *
     * @return int
     */
    public function getPerformance(string $type, int $unratedElo): float
    {
        $total = 0;
        $opponents = 0;
        foreach ($this->getPairings() as $pairing) {
            if (array_search($pairing->getResult(), Constants::NotPlayed) === false) {
                $opponentElo = $pairing->getOpponent()->getElo($type);
                $opponentElo = $opponentElo != 0 ? $opponentElo : $unratedElo;
                if (array_search($pairing->getResult(), Constants::Won) !== false) {
                    $total += $opponentElo + 400;
                } elseif (array_search($pairing->getResult(), Constants::Lost) !== false) {
                    $total += $opponentElo - 400;
                } elseif (array_search($pairing->getResult(), Constants::Draw) !== false) {
                    $total += $opponentElo;
                }
                $opponents++;
            }
        }
        return round($total / $opponents);
    }


    /**
     * Returns the number of played games of the player
     *
     * @return int
     */
    public function getPlayedGames(): int
    {
        $total = 0;
        foreach ($this->getPairings() as $pairing) {
            if (array_search($pairing->getResult(), Constants::Played) !== false) {
                $total++;
            }
        }
        return $total;
    }

    /**
     * Returns the name of the player
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->Name;
    }

    /**
     * Sets the name of the player
     *
     * @param string $Name
     * @return Player
     */
    public function setName(string $Name): Player
    {
        $this->Name = $Name;
        return $this;
    }

    /**
     * Returns an array of all ID's of the player
     *
     * @return string[]
     */
    public function getIds(): ?array
    {
        return $this->Ids;
    }

    /**
     * Sets an array of all ID's of the player
     *
     * @param string[] $Ids
     * @return Player
     */
    public function setIds(array $Ids): Player
    {
        $this->Ids = $Ids;
        return $this;
    }

    /**
     * Returns an array of all elos of the player
     *
     * @return int[]
     */
    public function getElos(): ?array
    {
        return $this->Elos;
    }

    /**
     * Sets an array of all elos of the player
     *
     * @param int[] $Elos
     * @return Player
     */
    public function setElos(array $Elos): Player
    {
        $this->Elos = $Elos;
        return $this;
    }

    /**
     * Returns the date of birth of the player
     *
     * @return DateTime
     */
    public function getDateOfBirth(): DateTime
    {
        return $this->DateOfBirth;
    }

    /**
     * Sets the date of birth of the player
     *
     * @param DateTime $DateOfBirth
     * @return Player
     */
    public function setDateOfBirth(DateTime $DateOfBirth): Player
    {
        $this->DateOfBirth = $DateOfBirth;
        return $this;
    }

    /**
     * Returns an array of all tiebreaks for the player
     *
     * @return float[]
     */
    public function getTiebreaks(): array
    {
        return $this->Tiebreaks;
    }

    /**
     * Sets an array of all tiebreaks for the player
     *
     * @param float[] $Tiebreaks
     * @return Player
     */
    public function setTiebreaks(array $Tiebreaks): Player
    {
        $this->Tiebreaks = $Tiebreaks;
        return $this;
    }

    /**
     * Returns the nation of the player
     * example value: BEL
     *
     * @return string
     */
    public function getNation(): string
    {
        return $this->Nation;
    }

    /**
     * Sets the nation of the player
     * example value: BEL
     *
     * @param string $Nation
     * @return Player
     */
    public function setNation(string $Nation): Player
    {
        $this->Nation = $Nation;
        return $this;
    }

    /**
     * Returns the category of the player
     *
     * @return string
     */
    public function getCategory(): string
    {
        return $this->Category;
    }

    /**
     * Sets the category of the player
     *
     * @param string $Category
     * @return Player
     */
    public function setCategory(string $Category): Player
    {
        $this->Category = $Category;
        return $this;
    }

    /**
     * Returns the title of the player
     *
     * @return Title
     */
    public function getTitle(): Title
    {
        return $this->Title;
    }

    /**
     * Sets the title of the player
     *
     * @param Title $Title
     * @return Player
     */
    public function setTitle(Title $Title): Player
    {
        $this->Title = $Title;
        return $this;
    }

    /**
     * Returns the gender of the player
     *
     * @return Gender
     */
    public function getGender(): Gender
    {
        return $this->Gender;
    }

    /**
     * Sets the gender of the player
     *
     * @param Gender $Gender
     * @return Player
     */
    public function setGender(Gender $Gender): Player
    {
        $this->Gender = $Gender;
        return $this;
    }

    /**
     * Returns an array of all pairings of the player
     *
     * @return Pairing[]
     */
    public function getPairings(): array
    {
        return $this->Pairings;
    }

    /**
     * Sets an array of all pairings of the player
     *
     * @param Pairing[] $Pairings
     * @return Player
     */
    public function setPairings(array $Pairings): Player
    {
        $this->Pairings = $Pairings;
        return $this;
    }

    /**
     * Returns binary data that was read out the pairtwo file but was not needed immediately
     *
     * @param string $Key
     * @return bool|DateTime|int|string|null
     */
    public function getBinaryData(string $Key)
    {
        if (isset($this->BinaryData[$Key])) {
            return $this->BinaryData[$Key];
        }
        return null;
    }

    /**
     * Sets binary data that is read out the pairtwo file but is not needed immediately
     *
     * @param string $Key
     * @param bool|int|DateTime|string $Value
     * @return Player
     */
    public function setBinaryData(string $Key, $Value): Player
    {
        $this->BinaryData[$Key] = $Value;
        return $this;
    }
}
