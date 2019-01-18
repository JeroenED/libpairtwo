<?php

namespace JeroenED\Libpairtwo\Models;

class Sws
{
    private $Release;
    private $Tournament;

    /**
     * @return mixed
     */
    public function getRelease()
    {
        return $this->Release;
    }

    /**
     * @param mixed $Release
     */
    public function setRelease($Release)
    {
        $this->Release = $Release;
    }

    /**
     * @return mixed
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
