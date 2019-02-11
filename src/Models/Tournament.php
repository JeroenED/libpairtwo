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
use DateTime;


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
    public function getName(): string
    {
        return $this->Name;
    }

    /**
     * @param string $Name
     */
    public function setName(string $Name): void
    {
        $this->Name = $Name;
    }

    /**
     * @return string
     */
    public function getOrganiser(): string
    {
        return $this->Organiser;
    }

    /**
     * @param string $Organiser
     */
    public function setOrganiser(string $Organiser): void
    {
        $this->Organiser = $Organiser;
    }

    /**
     * @return string
     */
    public function getOrganiserClub(): string
    {
        return $this->OrganiserClub;
    }

    /**
     * @param string $OrganiserClub
     */
    public function setOrganiserClub(string $OrganiserClub): void
    {
        $this->OrganiserClub = $OrganiserClub;
    }

    /**
     * @return int
     */
    public function getOrganiserClubNo(): int
    {
        return $this->OrganiserClubNo;
    }

    /**
     * @param int $OrganiserClubNo
     */
    public function setOrganiserClubNo(int $OrganiserClubNo): void
    {
        $this->OrganiserClubNo = $OrganiserClubNo;
    }

    /**
     * @return string
     */
    public function getOrganiserPlace(): string
    {
        return $this->OrganiserPlace;
    }

    /**
     * @param string $OrganiserPlace
     */
    public function setOrganiserPlace(string $OrganiserPlace): void
    {
        $this->OrganiserPlace = $OrganiserPlace;
    }

    /**
     * @return string
     */
    public function getOrganiserCountry(): string
    {
        return $this->OrganiserCountry;
    }

    /**
     * @param string $OrganiserCountry
     */
    public function setOrganiserCountry(string $OrganiserCountry): void
    {
        $this->OrganiserCountry = $OrganiserCountry;
    }

    /**
     * @return int
     */
    public function getFideHomol(): int
    {
        return $this->FideHomol;
    }

    /**
     * @param int $FideHomol
     */
    public function setFideHomol(int $FideHomol): void
    {
        $this->FideHomol = $FideHomol;
    }

    /**
     * @return DateTime
     */
    public function getStartDate(): DateTime
    {
        return $this->StartDate;
    }

    /**
     * @param DateTime $StartDate
     */
    public function setStartDate(DateTime $StartDate): void
    {
        $this->StartDate = $StartDate;
    }

    /**
     * @return DateTime
     */
    public function getEndDate(): DateTime
    {
        return $this->EndDate;
    }

    /**
     * @param DateTime $EndDate
     */
    public function setEndDate(DateTime $EndDate): void
    {
        $this->EndDate = $EndDate;
    }

    /**
     * @return string
     */
    public function getArbiter(): string
    {
        return $this->Arbiter;
    }

    /**
     * @param string $Arbiter
     */
    public function setArbiter(string $Arbiter): void
    {
        $this->Arbiter = $Arbiter;
    }

    /**
     * @return int
     */
    public function getRounds(): int
    {
        return $this->Rounds;
    }

    /**
     * @param int $Rounds
     */
    public function setRounds(int $Rounds): void
    {
        $this->Rounds = $Rounds;
    }

    /**
     * @return int
     */
    public function getParticipants(): int
    {
        return $this->Participants;
    }

    /**
     * @param int $Participants
     */
    public function setParticipants(int $Participants): void
    {
        $this->Participants = $Participants;
    }

    /**
     * @return string
     */
    public function getTempo(): string
    {
        return $this->Tempo;
    }

    /**
     * @param string $Tempo
     */
    public function setTempo(string $Tempo): void
    {
        $this->Tempo = $Tempo;
    }

    /**
     * @return int
     */
    public function getNonRatedElo(): int
    {
        return $this->NonRatedElo;
    }

    /**
     * @param int $NonRatedElo
     */
    public function setNonRatedElo(int $NonRatedElo): void
    {
        $this->NonRatedElo = $NonRatedElo;
    }

    /**
     * @return TournamentSystem
     */
    public function getSystem(): TournamentSystem
    {
        return $this->System;
    }

    /**
     * @param TournamentSystem $System
     */
    public function setSystem(TournamentSystem $System): void
    {
        $this->System = $System;
    }

    /**
     * @return string
     */
    public function getFirstPeriod(): string
    {
        return $this->FirstPeriod;
    }

    /**
     * @param string $FirstPeriod
     */
    public function setFirstPeriod(string $FirstPeriod): void
    {
        $this->FirstPeriod = $FirstPeriod;
    }

    /**
     * @return string
     */
    public function getSecondPeriod(): string
    {
        return $this->SecondPeriod;
    }

    /**
     * @param string $SecondPeriod
     */
    public function setSecondPeriod(string $SecondPeriod): void
    {
        $this->SecondPeriod = $SecondPeriod;
    }

    /**
     * @return string
     */
    public function getFederation(): string
    {
        return $this->Federation;
    }

    /**
     * @param string $Federation
     */
    public function setFederation(string $Federation): void
    {
        $this->Federation = $Federation;
    }

    /**
     * @return Player[]
     */
    public function getPlayers()
    {
        return $this->Players;
    }

    /**
     * @param Player[] $Players
     */
    public function setPlayers($Players): void
    {
        $this->Players = $Players;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->Year;
    }

    /**
     * @param int $Year
     */
    public function setYear(int $Year): void
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
