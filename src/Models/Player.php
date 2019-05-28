<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 19/01/19
 * Time: 14:14
 */

namespace JeroenED\Libpairtwo\Models;

use JeroenED\Libpairtwo\Enums\Title;
use JeroenED\Libpairtwo\Enums\Gender;
use JeroenED\Libpairtwo\Pairing;
use DateTime;

abstract class Player
{
    /** @var string */
    private $Name;

    /** @var int */
    private $Rank;

    /** @var int */
    private $FideId;

    /** @var int */
    private $ExtraPts;

    /** @var int */
    private $KbsbElo;

    /** @var DateTime */
    private $dateofbirth;

    /** @var int */
    private $KbsbID;

    /** @var float */
    private $Points;

    /** @var int */
    private $ClubNr;

    /** @var float */
    private $ScoreBucholtz;

    /** @var float */
    private $ScoreAmerican;

    /** @var int */
    private $FideElo;

    /** @var string */
    private $Nation;

    /** @var string */
    private $Category;

    /** @var Title */
    private $Title;

    /** @var Gender */
    private $Gender;

    /** @var int */
    private $NumberOfTies;

    /** @var bool */
    private $Absent;

    /** @var Pairing[] */
    private $Pairings = [];

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->Name;
    }

    /**
     * @param string $Name
     * @return Player
     */
    public function setName(string $Name): Player
    {
        $this->Name = $Name;
        return $this;
    }

    /**
     * @return int
     */
    public function getRank(): int
    {
        return $this->Rank;
    }

    /**
     * @param int $Rank
     * @return Player
     */
    public function setRank(int $Rank): Player
    {
        $this->Rank = $Rank;
        return $this;
    }

    /**
     * @return int
     */
    public function getFideId(): int
    {
        return $this->FideId;
    }

    /**
     * @param int $FideId
     * @return Player
     */
    public function setFideId(int $FideId): Player
    {
        $this->FideId = $FideId;
        return $this;
    }

    /**
     * @return int
     */
    public function getExtraPts(): int
    {
        return $this->ExtraPts;
    }

    /**
     * @param int $ExtraPts
     * @return Player
     */
    public function setExtraPts(int $ExtraPts): Player
    {
        $this->ExtraPts = $ExtraPts;
        return $this;
    }

    /**
     * @return int
     */
    public function getKbsbElo(): int
    {
        return $this->KbsbElo;
    }

    /**
     * @param int $KbsbElo
     * @return Player
     */
    public function setKbsbElo(int $KbsbElo): Player
    {
        $this->KbsbElo = $KbsbElo;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDateofbirth(): DateTime
    {
        return $this->dateofbirth;
    }

    /**
     * @param DateTime $dateofbirth
     * @return Player
     */
    public function setDateofbirth(DateTime $dateofbirth): Player
    {
        $this->dateofbirth = $dateofbirth;
        return $this;
    }

    /**
     * @return int
     */
    public function getKbsbID(): int
    {
        return $this->KbsbID;
    }

    /**
     * @param int $KbsbID
     * @return Player
     */
    public function setKbsbID(int $KbsbID): Player
    {
        $this->KbsbID = $KbsbID;
        return $this;
    }

    /**
     * @return float
     */
    public function getPoints(): float
    {
        return $this->Points;
    }

    /**
     * @param float $Points
     * @return Player
     */
    public function setPoints(float $Points): Player
    {
        $this->Points = $Points;
        return $this;
    }

    /**
     * @return int
     */
    public function getClubNr(): int
    {
        return $this->ClubNr;
    }

    /**
     * @param int $ClubNr
     * @return Player
     */
    public function setClubNr(int $ClubNr): Player
    {
        $this->ClubNr = $ClubNr;
        return $this;
    }

    /**
     * @return float
     */
    public function getScoreBucholtz(): float
    {
        return $this->ScoreBucholtz;
    }

    /**
     * @param float $ScoreBucholtz
     * @return Player
     */
    public function setScoreBucholtz(float $ScoreBucholtz): Player
    {
        $this->ScoreBucholtz = $ScoreBucholtz;
        return $this;
    }

    /**
     * @return float
     */
    public function getScoreAmerican(): float
    {
        return $this->ScoreAmerican;
    }

    /**
     * @param float $ScoreAmerican
     * @return Player
     */
    public function setScoreAmerican(float $ScoreAmerican): Player
    {
        $this->ScoreAmerican = $ScoreAmerican;
        return $this;
    }

    /**
     * @return int
     */
    public function getFideElo(): int
    {
        return $this->FideElo;
    }

    /**
     * @param int $FideElo
     * @return Player
     */
    public function setFideElo(int $FideElo): Player
    {
        $this->FideElo = $FideElo;
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
     * @return int
     */
    public function getNumberOfTies(): int
    {
        return $this->NumberOfTies;
    }

    /**
     * @param int $NumberOfTies
     * @return Player
     */
    public function setNumberOfTies(int $NumberOfTies): Player
    {
        $this->NumberOfTies = $NumberOfTies;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAbsent(): bool
    {
        return $this->Absent;
    }

    /**
     * @param bool $Absent
     * @return Player
     */
    public function setAbsent(bool $Absent): Player
    {
        $this->Absent = $Absent;
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
}
