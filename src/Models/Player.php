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
     * @return int[]
     */
    public function getIds(): array
    {
        return $this->Ids;
    }

    /**
     * @param int[] $Ids
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
    public function getElos(): array
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
