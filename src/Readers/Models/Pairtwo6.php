<?php

namespace JeroenED\Libpairtwo\Readers\Models;

use JeroenED\Libpairtwo\Tournament;

class Pairtwo6
{
    /** @var string */
    private $Release;

    /** @var tournament */
    private $Tournament;

    /** @var bool|DateTime|int|string[] */
    private $BinaryData;

    /**
     * @return String
     */
    public function getRelease(): string
    {
        return $this->Release;
    }

    /**
     * @param String $Release
     */
    public function setRelease(string $Release): void
    {
        $this->Release = $Release;
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
     */
    public function setTournament(Tournament $Tournament): void
    {
        $this->Tournament = $Tournament;
    }

    /**
     * Returns binary data from the sws-file
     *
     * @param string
     * @return string
     */
    public function getBinaryData(string $key)
    {
        return $this->BinaryData[$key];
    }

    /**
     * Sets binary data
     *
     * @param string
     * @param mixed
     */
    public function setBinaryData(string $key, $data): void
    {
        $this->BinaryData[$key] = $data;
    }
}
