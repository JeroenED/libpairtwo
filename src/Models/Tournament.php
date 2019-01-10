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
class Tournament {

    private $UserCountry;
    private $SavedOffset;
    private $NewPlayer;
    private $AmericanHandicap;
    private $LowOrder;
    private $PairingMethod;
    private $AmericanPresence;
    private $CheckSameClub;
    private $NoColorCheck;
    private $SeparateCategories;
    private $EloUsed;
    Private $AlternateColors;
    private $MaxMeetings;
    private $MaxDistance;
    private $MinimizeKeizer;
    private $MinRoundMeetings;
    private $MaxRoundsAbsent;
    private $SpecialPoints;
    private $NewNamePos;
    private $CurrentRound;
    private $CreatedRounds;
    private $CreatedPlayers;
    private $MaxSelection;
    private $NumOfRounds;
    private $NumOfPairings;
    private $CreatedPairings;
    private $PairingElems;
    private $RandomSeed;
    private $TieOrder;
    private $Categorie;
    
    function getUserCountry() {
        return $this->UserCountry;
    }

    function getSavedOffset() {
        return $this->SavedOffset;
    }

    function getNewPlayer() {
        return $this->NewPlayer;
    }

    function getAmericanHandicap() {
        return $this->AmericanHandicap;
    }

    function getLowOrder() {
        return $this->LowOrder;
    }

    function getPairingMethod() {
        return $this->PairingMethod;
    }

    function getAmericanPresence() {
        return $this->AmericanPresence;
    }

    function getCheckSameClub() {
        return $this->CheckSameClub;
    }

    function getNoColorCheck() {
        return $this->NoColorCheck;
    }

    function getSeparateCategories() {
        return $this->SeparateCategories;
    }

    function getEloUsed() {
        return $this->EloUsed;
    }

    function getAlternateColors() {
        return $this->AlternateColors;
    }

    function getMaxMeetings() {
        return $this->MaxMeetings;
    }

    function getMaxDistance() {
        return $this->MaxDistance;
    }

    function getMinimizeKeizer() {
        return $this->MinimizeKeizer;
    }

    function getMinRoundMeetings() {
        return $this->MinRoundMeetings;
    }

    function getMaxRoundsAbsent() {
        return $this->MaxRoundsAbsent;
    }

    function getSpecialPoints() {
        return $this->SpecialPoints;
    }

    function getNewNamePos() {
        return $this->NewNamePos;
    }

    function getCurrentRound() {
        return $this->CurrentRound;
    }

    function getCreatedRounds() {
        return $this->CreatedRounds;
    }

    function getCreatedPlayers() {
        return $this->CreatedPlayers;
    }

    function getMaxSelection() {
        return $this->MaxSelection;
    }

    function getNumOfRounds() {
        return $this->NumOfRounds;
    }

    function getNumOfPairings() {
        return $this->NumOfPairings;
    }

    function getCreatedPairings() {
        return $this->CreatedPairings;
    }

    function getPairingElems() {
        return $this->PairingElems;
    }

    function getRandomSeed() {
        return $this->RandomSeed;
    }

    function getTieOrder() {
        return $this->TieOrder;
    }

    function getCategorie() {
        return $this->Categorie;
    }

    function setUserCountry($UserCountry) {
        $this->UserCountry = $UserCountry;
        return $this;
    }

    function setSavedOffset($SavedOffset) {
        $this->SavedOffset = $SavedOffset;
        return $this;
    }

    function setNewPlayer($NewPlayer) {
        $this->NewPlayer = $NewPlayer;
        return $this;
    }

    function setAmericanHandicap($AmericanHandicap) {
        $this->AmericanHandicap = $AmericanHandicap;
        return $this;
    }

    function setLowOrder($LowOrder) {
        $this->LowOrder = $LowOrder;
        return $this;
    }

    function setPairingMethod($PairingMethod) {
        $this->PairingMethod = $PairingMethod;
        return $this;
    }

    function setAmericanPresence($AmericanPresence) {
        $this->AmericanPresence = $AmericanPresence;
        return $this;
    }

    function setCheckSameClub($CheckSameClub) {
        $this->CheckSameClub = $CheckSameClub;
        return $this;
    }

    function setNoColorCheck($NoColorCheck) {
        $this->NoColorCheck = $NoColorCheck;
        return $this;
    }

    function setSeparateCategories($SeparateCategories) {
        $this->SeparateCategories = $SeparateCategories;
        return $this;
    }

    function setEloUsed($EloUsed) {
        $this->EloUsed = $EloUsed;
        return $this;
    }

    function setAlternateColors($AlternateColors) {
        $this->AlternateColors = $AlternateColors;
        return $this;
    }

    function setMaxMeetings($MaxMeetings) {
        $this->MaxMeetings = $MaxMeetings;
        return $this;
    }

    function setMaxDistance($MaxDistance) {
        $this->MaxDistance = $MaxDistance;
        return $this;
    }

    function setMinimizeKeizer($MinimizeKeizer) {
        $this->MinimizeKeizer = $MinimizeKeizer;
        return $this;
    }

    function setMinRoundMeetings($MinRoundMeetings) {
        $this->MinRoundMeetings = $MinRoundMeetings;
        return $this;
    }

    function setMaxRoundsAbsent($MaxRoundsAbsent) {
        $this->MaxRoundsAbsent = $MaxRoundsAbsent;
        return $this;
    }

    function setSpecialPoints($SpecialPoints) {
        $this->SpecialPoints = $SpecialPoints;
        return $this;
    }

    function setNewNamePos($NewNamePos) {
        $this->NewNamePos = $NewNamePos;
        return $this;
    }

    function setCurrentRound($CurrentRound) {
        $this->CurrentRound = $CurrentRound;
        return $this;
    }

    function setCreatedRounds($CreatedRounds) {
        $this->CreatedRounds = $CreatedRounds;
        return $this;
    }

    function setCreatedPlayers($CreatedPlayers) {
        $this->CreatedPlayers = $CreatedPlayers;
        return $this;
    }

    function setMaxSelection($MaxSelection) {
        $this->MaxSelection = $MaxSelection;
        return $this;
    }

    function setNumOfRounds($NumOfRounds) {
        $this->NumOfRounds = $NumOfRounds;
        return $this;
    }

    function setNumOfPairings($NumOfPairings) {
        $this->NumOfPairings = $NumOfPairings;
        return $this;
    }

    function setCreatedPairings($CreatedPairings) {
        $this->CreatedPairings = $CreatedPairings;
        return $this;
    }

    function setPairingElems($PairingElems) {
        $this->PairingElems = $PairingElems;
        return $this;
    }

    function setRandomSeed($RandomSeed) {
        $this->RandomSeed = $RandomSeed;
        return $this;
    }

    function setTieOrder($TieOrder) {
        $this->TieOrder = $TieOrder;
        return $this;
    }

    function setCategorie($Categorie) {
        $this->Categorie = $Categorie;
        return $this;
    }
    
}
