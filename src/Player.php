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

use JeroenED\Libpairtwo\Enums\Title;
use JeroenED\Libpairtwo\Enums\Gender;
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
     * @param string $type
     * @return int
     */
    public function getElo(string $type): int
    {
        return $this->getElos()[$type];
    }

    /**
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
     * @param string $type
     * @return string
     */
    public function getId(string $type): string
    {
        return $this->getElos()[$type];
    }

    /**
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
     * @return string
     */
    public function getName(): string
    {
        return $this->Name;
    }

    /**
     * @param string $Name
     * @return \JeroenED\Libpairtwo\Models\Player
     */
    public function setName(string $Name): Player
    {
        $this->Name = $Name;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getIds(): ?array
    {
        return $this->Ids;
    }

    /**
     * @param string[] $Ids
     * @return Player
     */
    public function setIds(array $Ids): Player
    {
        $this->Ids = $Ids;
        return $this;
    }

    /**
     * @return int[]
     */
    public function getElos(): ?array
    {
        return $this->Elos;
    }

    /**
     * @param int[] $Elos
     * @return Player
     */
    public function setElos(array $Elos): Player
    {
        $this->Elos = $Elos;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateOfBirth(): \DateTime
    {
        return $this->DateOfBirth;
    }

    /**
     * @param \DateTime $DateOfBirth
     * @return Player
     */
    public function setDateOfBirth(\DateTime $DateOfBirth): Player
    {
        $this->DateOfBirth = $DateOfBirth;
        return $this;
    }

    /**
     * @return float[]
     */
    public function getTiebreaks(): array
    {
        return $this->Tiebreaks;
    }

    /**
     * @param float[] $Tiebreaks
     * @return Player
     */
    public function setTiebreaks(array $Tiebreaks): Player
    {
        $this->Tiebreaks = $Tiebreaks;
        return $this;
    }

    /**
     * example value: BEL
     *
     * @return string
     */
    public function getNation(): string
    {
        return $this->Nation;
    }

    /**
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
     * @return string
     */
    public function getCategory(): string
    {
        return $this->Category;
    }

    /**
     * @param string $Category
     * @return Player
     */
    public function setCategory(string $Category): Player
    {
        $this->Category = $Category;
        return $this;
    }

    /**
     * @return Title
     */
    public function getTitle(): Title
    {
        return $this->Title;
    }

    /**
     * @param Title $Title
     * @return Player
     */
    public function setTitle(Title $Title): Player
    {
        $this->Title = $Title;
        return $this;
    }

    /**
     * @return Gender
     */
    public function getGender(): Gender
    {
        return $this->Gender;
    }

    /**
     * @param Gender $Gender
     * @return Player
     */
    public function setGender(Gender $Gender): Player
    {
        $this->Gender = $Gender;
        return $this;
    }

    /**
     * @return Pairing[]
     */
    public function getPairings(): array
    {
        return $this->Pairings;
    }

    /**
     * @param Pairing[] $Pairings
     * @return Player
     */
    public function setPairings(array $Pairings): Player
    {
        $this->Pairings = $Pairings;
        return $this;
    }

    /**
     * @param string $Key
     * @return bool|DateTime|int|string
     */
    public function getBinaryData(string $Key)
    {
        return $this->BinaryData[$Key];
    }

    /**
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
