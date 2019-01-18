<?php

namespace JeroenED\Libpairtwo\Models;

class Sws
{
    private $Release;
    private $Tournament;
    private $BinaryData;

    /**
     * @return String
     */
    public function getRelease()
    {
        return $this->Release;
    }

    /**
     * @param String $Release
     */
    public function setRelease(String $Release): void
    {
        $this->Release = $Release;
    }

    /**
     * @return Tournament
     */
    public function getTournament()
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
    public function getBinaryData(String $key)
    {
        return $this->BinaryData[$key];
    }

    /**
     * Sets binary data
     *
     * @param string
     * @param string
     */
    public function setBinaryData(String $key, String $data): void
    {
        $this->BinaryData[$key] = $data;
    }
}
