<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 19/01/19
 * Time: 14:14
 */

namespace JeroenED\Libpairtwo\Models;
use JeroenED\Libpairtwo\Enums\Title;
use JeroenED\Libpairtwo\Enums\Sex;
use DateTime;

class Player
{
    private $Name;
    private $Rank;
    private $FideId;
    private $ExtraPts;
    private $KbsbElo;
    private $dateofbirth;
    private $KbsbID;
    private $Points;
    private $ClubNr;
    private $ScoreBucholtz;
    private $ScoreAmerican;
    private $FideElo;
    private $Nation;
    private $Category;
    private $Title;
    private $Sex;
    private $NumberOfTies;
    private $Absent;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->Name;
    }

    /**
     * @param string $Name
     */
    public function setName($Name): void
    {
        $this->Name = $Name;
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
     */
    public function setRank(int $Rank): void
    {
        $this->Rank = $Rank;
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
     */
    public function setFideId(int $FideId): void
    {
        $this->FideId = $FideId;
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
     */
    public function setExtraPts(int $ExtraPts): void
    {
        $this->ExtraPts = $ExtraPts;
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
     */
    public function setKbsbElo(int $KbsbElo): void
    {
        $this->KbsbElo = $KbsbElo;
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
     */
    public function setDateofbirth(DateTime $dateofbirth): void
    {
        $this->dateofbirth = $dateofbirth;
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
     */
    public function setKbsbID(int $KbsbID): void
    {
        $this->KbsbID = $KbsbID;
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
     */
    public function setPoints(float $Points): void
    {
        $this->Points = $Points;
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
     */
    public function setClubNr(int $ClubNr): void
    {
        $this->ClubNr = $ClubNr;
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
     */
    public function setScoreBucholtz(float $ScoreBucholtz): void
    {
        $this->ScoreBucholtz = $ScoreBucholtz;
    }

    /**
     * @return int
     */
    public function getScoreAmerican(): int
    {
        return $this->ScoreAmerican;
    }

    /**
     * @param int $ScoreAmerican
     */
    public function setScoreAmerican(int $ScoreAmerican): void
    {
        $this->ScoreAmerican = $ScoreAmerican;
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
     */
    public function setFideElo(int $FideElo): void
    {
        $this->FideElo = $FideElo;
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
     * @param string $Nation
     */
    public function setNation(string $Nation): void
    {
        $this->Nation = $Nation;
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
     */
    public function setCategory(string $Category): void
    {
        $this->Category = $Category;
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
     */
    public function setTitle(Title $Title): void
    {
        $this->Title = $Title;
    }

    /**
     * @return Sex
     */
    public function getSex(): Sex
    {
        return $this->Sex;
    }

    /**
     * @param Sex $Sex
     */
    public function setSex(Sex $Sex): void
    {
        $this->Sex = $Sex;
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
     */
    public function setNumberOfTies(int $NumberOfTies): void
    {
        $this->NumberOfTies = $NumberOfTies;
    }

    /**
     * @return bool
     */
    public function getAbsent(): bool
    {
        return $this->Absent;
    }

    /**
     * @param bool $Absent
     */
    public function setAbsent(bool $Absent): void
    {
        $this->Absent = $Absent;
    }
}
