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
    public function getName()
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
     * @return integer
     */
    public function getRank()
    {
        return $this->Rank;
    }

    /**
     * @param integer $Rank
     */
    public function setRank($Rank): void
    {
        $this->Rank = $Rank;
    }

    /**
     * @return integer
     */
    public function getFideId()
    {
        return $this->FideId;
    }

    /**
     * @param integer $FideId
     */
    public function setFideId($FideId): void
    {
        $this->FideId = $FideId;
    }

    /**
     * @return integer
     */
    public function getExtraPts()
    {
        return $this->ExtraPts;
    }

    /**
     * @param integer $ExtraPts
     */
    public function setExtraPts($ExtraPts): void
    {
        $this->ExtraPts = $ExtraPts;
    }

    /**
     * @return integer
     */
    public function getKbsbElo()
    {
        return $this->KbsbElo;
    }

    /**
     * @param integer $KbsbElo
     */
    public function setKbsbElo($KbsbElo): void
    {
        $this->KbsbElo = $KbsbElo;
    }

    /**
     * @return integer
     */
    public function getDateofbirth()
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
     * @return integer
     */
    public function getKbsbID()
    {
        return $this->KbsbID;
    }

    /**
     * @param integer $KbsbID
     */
    public function setKbsbID($KbsbID): void
    {
        $this->KbsbID = $KbsbID;
    }

    /**
     * Note: SWS file returns points * 2 to circumvent use of floating point
     *
     * @return integer
     */
    public function getPoints()
    {
        return $this->Points;
    }

    /**
     * Note: SWS file returns points * 2 to circumvent use of floating point
     *
     * @param integer $Points
     */
    public function setPoints($Points): void
    {
        $this->Points = $Points;
    }

    /**
     * @return integer
     */
    public function getClubNr()
    {
        return $this->ClubNr;
    }

    /**
     * @param integer $ClubNr
     */
    public function setClubNr($ClubNr): void
    {
        $this->ClubNr = $ClubNr;
    }

    /**
     * @return integer
     */
    public function getScoreBucholtz()
    {
        return $this->ScoreBucholtz;
    }

    /**
     * @param integer $ScoreBucholtz
     */
    public function setScoreBucholtz($ScoreBucholtz): void
    {
        $this->ScoreBucholtz = $ScoreBucholtz;
    }

    /**
     * @return integer
     */
    public function getScoreAmerican()
    {
        return $this->ScoreAmerican;
    }

    /**
     * @param integer $ScoreAmerican
     */
    public function setScoreAmerican($ScoreAmerican): void
    {
        $this->ScoreAmerican = $ScoreAmerican;
    }

    /**
     * @return integer
     */
    public function getFideElo()
    {
        return $this->FideElo;
    }

    /**
     * @param integer $FideElo
     */
    public function setFideElo($FideElo): void
    {
        $this->FideElo = $FideElo;
    }

    /**
     * example value: BEL
     *
     * @return String
     */
    public function getNation()
    {
        return $this->Nation;
    }

    /**
     * @param string $Nation
     */
    public function setNation($Nation): void
    {
        $this->Nation = $Nation;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->Category;
    }

    /**
     * @param string $Category
     */
    public function setCategory($Category): void
    {
        $this->Category = $Category;
    }

    /**
     * @return FideTitle
     */
    public function getTitle()
    {
        return $this->Title;
    }

    /**
     * @param Title $Title
     */
    public function setTitle($Title): void
    {
        $this->Title = $Title;
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->Sex;
    }

    /**
     * @param mixed $Sex
     */
    public function setSex($Sex): void
    {
        $this->Sex = $Sex;
    }

    /**
     * @return mixed
     */
    public function getNumberOfTies()
    {
        return $this->NumberOfTies;
    }

    /**
     * @param mixed $NumberOfTies
     */
    public function setNumberOfTies($NumberOfTies): void
    {
        $this->NumberOfTies = $NumberOfTies;
    }

    /**
     * @return mixed
     */
    public function getAbsent()
    {
        return $this->Absent;
    }

    /**
     * @param mixed $Absent
     */
    public function setAbsent($Absent): void
    {
        $this->Absent = $Absent;
    }
}
