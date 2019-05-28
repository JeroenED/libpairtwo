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

use JeroenED\Libpairtwo\Enums\Tiebreak;
use JeroenED\Libpairtwo\Enums\TournamentSystem;
use JeroenED\Libpairtwo\Player;
use DateTime;

/**
 * Description of Sws
 *
 * @author Jeroen De Meerleer <schaak@jeroened.be>
 */
abstract class Tournament
{
    /** @var string */
    private $Name;

    /** @var string */
    private $Organiser;

    /** @var int */
    private $OrganiserClubNo;

    /** @var string */
    private $OrganiserClub;

    /** @var string */
    private $OrganiserPlace;

    /** @var string */
    private $OrganiserCountry;

    /** @var int */
    private $FideHomol;

    /** @var DateTime */
    private $StartDate;

    /** @var DateTime */
    private $EndDate;

    /** @var string */
    private $Arbiter;

    /** @var int */
    private $NoOfRounds;

    /** @var Round[] */
    private $Rounds = [];

    /** @var int */
    private $Participants;

    /** @var string */
    private $Tempo;

    /** @var int */
    private $NonRatedElo;

    /** @var TournamentSystem */
    private $System;

    /** @var string */
    private $FirstPeriod;

    /** @var string */
    private $SecondPeriod;

    /** @var string */
    private $Federation;

    /** @var Player[] */
    private $Players = [];

    /** @var int */
    private $Year;

    /** @var Pairing[] */
    private $Pairings = [];

    /** @var Tiebreak[] */
    private $Tiebreaks = [];

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->Name;
    }

    /**
     * @param string $Name
     * @return Tournament
     */
    public function setName(string $Name): Tournament
    {
        $this->Name = $Name;
        return $this;
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
     * @return Tournament
     */
    public function setOrganiser(string $Organiser): Tournament
    {
        $this->Organiser = $Organiser;
        return $this;
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
     * @return Tournament
     */
    public function setOrganiserClubNo(int $OrganiserClubNo): Tournament
    {
        $this->OrganiserClubNo = $OrganiserClubNo;
        return $this;
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
     * @return Tournament
     */
    public function setOrganiserClub(string $OrganiserClub): Tournament
    {
        $this->OrganiserClub = $OrganiserClub;
        return $this;
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
     * @return Tournament
     */
    public function setOrganiserPlace(string $OrganiserPlace): Tournament
    {
        $this->OrganiserPlace = $OrganiserPlace;
        return $this;
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
     * @return Tournament
     */
    public function setOrganiserCountry(string $OrganiserCountry): Tournament
    {
        $this->OrganiserCountry = $OrganiserCountry;
        return $this;
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
     * @return Tournament
     */
    public function setFideHomol(int $FideHomol): Tournament
    {
        $this->FideHomol = $FideHomol;
        return $this;
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
     * @return Tournament
     */
    public function setStartDate(DateTime $StartDate): Tournament
    {
        $this->StartDate = $StartDate;
        return $this;
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
     * @return Tournament
     */
    public function setEndDate(DateTime $EndDate): Tournament
    {
        $this->EndDate = $EndDate;
        return $this;
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
     * @return Tournament
     */
    public function setArbiter(string $Arbiter): Tournament
    {
        $this->Arbiter = $Arbiter;
        return $this;
    }

    /**
     * @return int
     */
    public function getNoOfRounds(): int
    {
        return $this->NoOfRounds;
    }

    /**
     * @param int $NoOfRounds
     * @return Tournament
     */
    public function setNoOfRounds(int $NoOfRounds): Tournament
    {
        $this->NoOfRounds = $NoOfRounds;
        return $this;
    }

    /**
     * @return Round[]
     */
    public function getRounds(): array
    {
        return $this->Rounds;
    }

    /**
     * @param Round[] $Rounds
     * @return Tournament
     */
    public function setRounds(array $Rounds): Tournament
    {
        $this->Rounds = $Rounds;
        return $this;
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
     * @return Tournament
     */
    public function setParticipants(int $Participants): Tournament
    {
        $this->Participants = $Participants;
        return $this;
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
     * @return Tournament
     */
    public function setTempo(string $Tempo): Tournament
    {
        $this->Tempo = $Tempo;
        return $this;
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
     * @return Tournament
     */
    public function setNonRatedElo(int $NonRatedElo): Tournament
    {
        $this->NonRatedElo = $NonRatedElo;
        return $this;
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
     * @return Tournament
     */
    public function setSystem(TournamentSystem $System): Tournament
    {
        $this->System = $System;
        return $this;
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
     * @return Tournament
     */
    public function setFirstPeriod(string $FirstPeriod): Tournament
    {
        $this->FirstPeriod = $FirstPeriod;
        return $this;
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
     * @return Tournament
     */
    public function setSecondPeriod(string $SecondPeriod): Tournament
    {
        $this->SecondPeriod = $SecondPeriod;
        return $this;
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
     * @return Tournament
     */
    public function setFederation(string $Federation): Tournament
    {
        $this->Federation = $Federation;
        return $this;
    }

    /**
     * @return Player[]
     */
    public function getPlayers(): array
    {
        return $this->Players;
    }

    /**
     * @param Player[] $Players
     * @return Tournament
     */
    public function setPlayers(array $Players): Tournament
    {
        $this->Players = $Players;
        return $this;
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
     * @return Tournament
     */
    public function setYear(int $Year): Tournament
    {
        $this->Year = $Year;
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
     * @return Tournament
     */
    public function setPairings(array $Pairings): Tournament
    {
        $this->Pairings = $Pairings;
        return $this;
    }

    /**
     * @return Tiebreak[]
     */
    public function getTiebreaks(): array
    {
        return $this->Tiebreaks;
    }

    /**
     * @param Tiebreak[] $Tiebreaks
     * @return Tournament
     */
    public function setTiebreaks(array $Tiebreaks): Tournament
    {
        $this->Tiebreaks = $Tiebreaks;
        return $this;
    }

}
