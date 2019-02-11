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
use JeroenED\Libpairtwo\Enums\TournamentSystem;


/**
 * Description of Sws
 *
 * @author Jeroen De Meerleer <schaak@jeroened.be>
 */
class Tournament
{
    private $Name;
    private $Organiser;
    private $OrganiserClubNo;
    private $OrganiserClub;
    private $OrganiserPlace;
    private $OrganiserCountry;
    private $FideHomol;
    private $StartDate;
    private $EndDate;
    private $Arbiter;
    private $Rounds;
    private $Participants;
    private $Tempo;
    private $NonRatedElo;
    private $System;
    private $FirstPeriod;
    private $SecondPeriod;
    private $Federation;
    private $Players;
    private $Year;
    private $Pairings;

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
     * @return string
     */
    public function getOrganiser()
    {
        return $this->Organiser;
    }

    /**
     * @param string $Organiser
     */
    public function setOrganiser($Organiser): void
    {
        $this->Organiser = $Organiser;
    }

    /**
     * @return String
     */
    public function getOrganiserClub()
    {
        return $this->OrganiserClub;
    }

    /**
     * @param String $OrganiserClub
     */
    public function setOrganiserClub($OrganiserClub): void
    {
        $this->OrganiserClub = $OrganiserClub;
    }

    /**
     * @return integer
     */
    public function getOrganiserClubNo()
    {
        return $this->OrganiserClubNo;
    }

    /**
     * @param integer $OrganiserClubno
     */
    public function setOrganiserClubNo($OrganiserClubNo): void
    {
        $this->OrganiserClubNo = $OrganiserClubNo;
    }

    /**
     * @return string
     */
    public function getOrganiserPlace()
    {
        return $this->OrganiserPlace;
    }

    /**
     * @param string $OrganiserPlace
     */
    public function setOrganiserPlace($OrganiserPlace): void
    {
        $this->OrganiserPlace = $OrganiserPlace;
    }

    /**
     * @return string
     */
    public function getOrganiserCountry()
    {
        return $this->OrganiserCountry;
    }

    /**
     * @param string $OrganiserCountry
     */
    public function setOrganiserCountry($OrganiserCountry): void
    {
        $this->OrganiserCountry = $OrganiserCountry;
    }

    /**
     * @return integer
     */
    public function getFideHomol()
    {
        return $this->FideHomol;
    }

    /**
     * @param integer $FideHomol
     */
    public function setFideHomol($FideHomol): void
    {
        $this->FideHomol = $FideHomol;
    }

    /**
     * @return integer
     */
    public function getStartDate()
    {
        return $this->StartDate;
    }

    /**
     * @param integer $StartDate
     */
    public function setStartDate($StartDate): void
    {
        $this->StartDate = $StartDate;
    }

    /**
     * @return integer
     */
    public function getEndDate()
    {
        return $this->EndDate;
    }

    /**
     * @param integer$EndDate
     */
    public function setEndDate($EndDate): void
    {
        $this->EndDate = $EndDate;
    }

    /**
     * @return string
     */
    public function getArbiter()
    {
        return $this->Arbiter;
    }

    /**
     * @param string $Arbiter
     */
    public function setArbiter($Arbiter): void
    {
        $this->Arbiter = $Arbiter;
    }

    /**
     * @return integer
     */
    public function getRounds()
    {
        return $this->Rounds;
    }

    /**
     * @param integer $Rounds
     */
    public function setRounds($Rounds): void
    {
        $this->Rounds = $Rounds;
    }

    /**
     * @return integer
     */
    public function getParticipants()
    {
        return $this->Participants;
    }

    /**
     * @param integer $Participants
     */
    public function setParticipants($Participants): void
    {
        $this->Participants = $Participants;
    }

    /**
     * @return string
     */
    public function getTempo()
    {
        return $this->Tempo;
    }

    /**
     * @param string $Tempo
     */
    public function setTempo($Tempo): void
    {
        $this->Tempo = $Tempo;
    }

    /**
     * @return integer
     */
    public function getNonRatedElo()
    {
        return $this->NonRatedElo;
    }

    /**
     * @param integer $NonRatedElo
     */
    public function setNonRatedElo($NonRatedElo): void
    {
        $this->NonRatedElo = $NonRatedElo;
    }

    /**
     * @return TournamentSystem
     */
    public function getSystem()
    {
        return $this->System;
    }

    /**
     * @param TournamentSystem $System
     */
    public function setSystem($System): void
    {
        $this->System = $System;
    }

    /**
     * @return String
     */
    public function getFirstPeriod()
    {
        return $this->FirstPeriod;
    }

    /**
     * @param String $FirstPeriod
     */
    public function setFirstPeriod($FirstPeriod): void
    {
        $this->FirstPeriod = $FirstPeriod;
    }

    /**
     * @return String
     */
    public function getSecondPeriod()
    {
        return $this->SecondPeriod;
    }

    /**
     * @param String $SecondPeriod
     */
    public function setSecondPeriod($SecondPeriod): void
    {
        $this->SecondPeriod = $SecondPeriod;
    }

    /**
     * @return String
     */
    public function getFederation()
    {
        return $this->Federation;
    }

    /**
     * @param String $Federation
     */
    public function setFederation($Federation): void
    {
        $this->Federation = $Federation;
    }

    /**
     * @return array
     */
    public function getPlayers()
    {
        return $this->Players;
    }

    /**
     * @param array $Players
     */
    public function setPlayers($Players): void
    {
        $this->Players = $Players;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->Year;
    }

    /**
     * @param mixed $Year
     */
    public function setYear($Year): void
    {
        $this->Year = $Year;
    }

    /**
     * @return Pairing[]
     */
    public function getPairings()
    {
        return $this->Pairings;
    }

    /**
     * @param Pairing[] $Pairings
     */
    public function setPairings($Pairings): void
    {
        $this->Pairings = $Pairings;
    }



}
