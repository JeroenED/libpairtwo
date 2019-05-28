<?php

namespace JeroenED\Libpairtwo\Readers\Models;

use JeroenED\Libpairtwo\Tournament;

abstract class Pairtwo6
{
    /** @var string */
    private $Release;

    /** @var tournament */
    private $Tournament;

    /** @var bool|DateTime|int|string[] */
    private $BinaryData;

    /**
     * @return string
     */
    public function getRelease(): string
    {
        return $this->Release;
    }

    /**
     * @param string $Release
     * @return Pairtwo6
     */
    public function setRelease(string $Release): Pairtwo6
    {
        $this->Release = $Release;
        return $this;
    }

    /**
     * @return Tournament
     */
    public function getTournament(): Tournament
    {
        return $this->Tournament;
    }

    /**
     * @param Tournament $Tournament
     * @return Pairtwo6
     */
    public function setTournament(Tournament $Tournament): Pairtwo6
    {
        $this->Tournament = $Tournament;
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
     * @return Pairtwo6
     */
    public function setBinaryData(string $Key, $Value): Pairtwo6
    {
        $this->BinaryData[$Key] = $Value;
        return $this;
    }


}
