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
     * @param mixed $Tournament
     */
    public function setTournament($Tournament)
    {
        $this->Tournament = $Tournament;
    }
}
