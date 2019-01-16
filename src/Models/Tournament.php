<?php

/*
 * The MIT License
 *
 * Copyright 2019 Jeroen De Meerleer <schaak@jeroened.be>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace JeroenED\Libpairtwo\Models;

/**
 * Description of Sws
 *
 * @author Jeroen De Meerleer <schaak@jeroened.be>
 */
class Tournament
{
    private $Name;
    private $Organiser;
    private $OrganiserClub;
    private $OrganiserPlace;
    private $OrganiserCountry;
    private $StartDate;
    private $EndDate;
    private $Arbiter;
    private $Rounds;
    private $Participants;
    private $Tempo;
    private $NonRatedElo;
    private $System;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * @param mixed $Name
     */
    public function setName($Name): void
    {
        $this->Name = $Name;
    }

    /**
     * @return mixed
     */
    public function getOrganiser()
    {
        return $this->Organiser;
    }

    /**
     * @param mixed $Organiser
     */
    public function setOrganiser($Organiser): void
    {
        $this->Organiser = $Organiser;
    }

    /**
     * @return mixed
     */
    public function getOrganiserClub()
    {
        return $this->OrganiserClub;
    }

    /**
     * @param mixed $OrganiserClub
     */
    public function setOrganiserClub($OrganiserClub): void
    {
        $this->OrganiserClub = $OrganiserClub;
    }

    /**
     * @return mixed
     */
    public function getOrganiserPlace()
    {
        return $this->OrganiserPlace;
    }

    /**
     * @param mixed $OrganiserPlace
     */
    public function setOrganiserPlace($OrganiserPlace): void
    {
        $this->OrganiserPlace = $OrganiserPlace;
    }

    /**
     * @return mixed
     */
    public function getOrganiserCountry()
    {
        return $this->OrganiserCountry;
    }

    /**
     * @param mixed $OrganiserCountry
     */
    public function setOrganiserCountry($OrganiserCountry): void
    {
        $this->OrganiserCountry = $OrganiserCountry;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->StartDate;
    }

    /**
     * @param mixed $StartDate
     */
    public function setStartDate($StartDate): void
    {
        $this->StartDate = $StartDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->EndDate;
    }

    /**
     * @param mixed $EndDate
     */
    public function setEndDate($EndDate): void
    {
        $this->EndDate = $EndDate;
    }

    /**
     * @return mixed
     */
    public function getArbiter()
    {
        return $this->Arbiter;
    }

    /**
     * @param mixed $Arbiter
     */
    public function setArbiter($Arbiter): void
    {
        $this->Arbiter = $Arbiter;
    }

    /**
     * @return mixed
     */
    public function getRounds()
    {
        return $this->Rounds;
    }

    /**
     * @param mixed $Rounds
     */
    public function setRounds($Rounds): void
    {
        $this->Rounds = $Rounds;
    }

    /**
     * @return mixed
     */
    public function getParticipants()
    {
        return $this->Participants;
    }

    /**
     * @param mixed $Participants
     */
    public function setParticipants($Participants): void
    {
        $this->Participants = $Participants;
    }

    /**
     * @return mixed
     */
    public function getTempo()
    {
        return $this->Tempo;
    }

    /**
     * @param mixed $Tempo
     */
    public function setTempo($Tempo): void
    {
        $this->Tempo = $Tempo;
    }

    /**
     * @return mixed
     */
    public function getNonRatedElo()
    {
        return $this->NonRatedElo;
    }

    /**
     * @param mixed $NonRatedElo
     */
    public function setNonRatedElo($NonRatedElo): void
    {
        $this->NonRatedElo = $NonRatedElo;
    }

    /**
     * @return mixed
     */
    public function getSystem()
    {
        return $this->System;
    }

    /**
     * @param mixed $System
     */
    public function setSystem($System): void
    {
        $this->System = $System;
    }


}
