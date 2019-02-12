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

namespace JeroenED\Libpairtwo;

use JeroenED\Libpairtwo\Enums\Title;
use JeroenED\Libpairtwo\Enums\Sex;
use JeroenED\Libpairtwo\Enums\Color;
use JeroenED\Libpairtwo\Enums\Result;
use JeroenED\Libpairtwo\Models\Sws as SwsModel;
use JeroenED\Libpairtwo\Enums\TournamentSystem;
use DateTime;


/**
 * This class reads a SWS file
 *
 * @author Jeroen De Meerleer
 */
class Sws extends SwsModel
{
    private const PT_DAYFACTOR = 32;
    private const PT_MONTHFACTOR = 16;
    private const PT_YEARFACTOR = 512;
    private const PT_PASTOFFSET = 117;


    /**
     *
     * This function reads the sws-file
     *
     * @param string $swsfile
     * @return SwsModel
     */
    public static function ReadSws(string $swsfile)
    {
        $swshandle = fopen($swsfile, 'rb');
        $swscontents = fread($swshandle, filesize($swsfile));
        fclose($swshandle);

        $sws = new SwsModel();
        $offset = 0;
        

        $length = 4;
        $sws->setRelease(self::ReadData('String', substr($swscontents, $offset, $length)));
        $offset += $length;

        $sws->setTournament(new Tournament());

        // UserCountry
        $length = 4;
        $sws->setBinaryData("UserCountry", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // SavedOffset
        $length = 4;
        $sws->setBinaryData("SavedOffset", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // NewPlayer
        $length = 4;
        $sws->setBinaryData("NewPlayer", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // AmericanHandicap
        $length = 4;
        $sws->setBinaryData("AmericanHandicap", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // LowOrder
        $length = 4;
        $sws->setBinaryData("LowOrder", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // PairingMethod
        $length = 4;
        $sws->setBinaryData("PairingMethod", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // AmericanPresence
        $length = 4;
        $sws->setBinaryData("AmericanPresence", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // CheckSameClub
        $length = 4;
        $sws->setBinaryData("CheckSameClub", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // NoColorCheck
        $length = 4;
        $sws->setBinaryData("NoColorCheck", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // SeparateCategories
        $length = 4;
        $sws->setBinaryData("SeparateCategories", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // EloUsed
        $length = 4;
        $sws->setBinaryData("EloUsed", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // AlternateColors
        $length = 4;
        $sws->setBinaryData("AlternateColors", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // MaxMeetings
        $length = 4;
        $sws->setBinaryData("MaxMeetings", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // MaxDistance
        $length = 4;
        $sws->setBinaryData("MaxDistance", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // MinimizeKeizer
        $length = 4;
        $sws->setBinaryData("MinimizeKeizer", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // MinRoundsMeetings
        $length = 4;
        $sws->setBinaryData("MinRoundsMeetings", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // MaxRoundsAbsent
        $length = 4;
        $sws->setBinaryData("MaxRoundsAbsent", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // SpecialPoints
        $length = 4 * 6;
        $sws->setBinaryData("SpecialPoints", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // NewNamePos
        $length = 4;
        $sws->setBinaryData("NewNamePos", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // CurrentRound
        $length = 4;
        $sws->setBinaryData("CurrentRound", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // CreatedRounds
        $length = 4;
        $sws->setBinaryData("CreatedRounds", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // CreatedPlayers
        $length = 4;
        $sws->setBinaryData("CreatedPlayers", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // MaxSelection
        $length = 4;
        $sws->setBinaryData("MaxSelection", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // NumberOfRounds
        $length = 4;
        $sws->setBinaryData("NumberOfRounds", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // NumberOfPairings
        $length = 4;
        $sws->setBinaryData("NumberOfPairings", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // CreatedPairings
        $length = 4;
        $sws->setBinaryData("CreatedPairings", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // PairingElems
        $length = 4;
        $sws->setBinaryData("PairingElems", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // RandomSeed
        $length = 4;
        $sws->setBinaryData("RandomSeed", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // TieOrder
        $length = 4 * 5;
        $sws->setBinaryData("TieOrder", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Categorie
        $length = 4 * 10;
        $sws->setBinaryData("Categorie", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // ExtraPoints
        $length = 4 * 20;
        $sws->setBinaryData("ExtraPoints", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // SelectP
        $length = 4 * 20;
        $sws->setBinaryData("SelectP", self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Players
        for ($i = 0; $i < $sws->getBinaryData("NewPlayer"); $i++) {
            $player = new Player();

            $length = 4;
            $player->SetRank(self::ReadData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 4;
            $sws->setBinaryData("Players($i)_NamePos", self::ReadData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 4;
            $player->SetFideId(self::ReadData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 4;
            $player->SetExtraPts(self::ReadData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 4;
            $player->SetKbsbElo(self::ReadData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 4;
            $player->SetDateOfBirth(self::ReadData('Date', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 4;
            $player->setKbsbID(self::ReadData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 4;
            $player->setPoints(self::ReadData('Int', substr($swscontents, $offset, $length)) / 2);
            $offset += $length;

            $length = 4;
            $player->setClubNr(self::ReadData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 4;
            $player->setScoreBucholtz(self::ReadData('Int', substr($swscontents, $offset, $length)) / 2);
            $offset += $length;

            $length = 4;
            $player->setScoreAmerican(self::ReadData('Int', substr($swscontents, $offset, $length)) / 2);
            $offset += $length;

            $length = 4;
            $sws->setBinaryData("Players($i)_HelpValue", self::ReadData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 4;
            $player->setFideElo(self::ReadData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 1;
            $sws->setBinaryData("Players($i)_NameLength", self::ReadData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 3;
            $player->setNation(self::ReadData('String', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 1;
            $player->setCategory(self::ReadData('String', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 1;
            $player->setTitle(new Title(self::ReadData('Int', substr($swscontents, $offset, $length))));
            $offset += $length;

            $length = 1;
            $player->setSex(new Sex(self::ReadData('Int', substr($swscontents, $offset, $length))));
            $offset += $length;

            $length = 1;
            $player->setNumberOfTies(self::ReadData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 1;
            $player->setAbsent(self::ReadData('Bool', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 1;
            $sws->setBinaryData("Players($i)_ColorDiff", self::ReadData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 1;
            $sws->setBinaryData("Players($i)_ColorPref", self::ReadData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 1;
            $sws->setBinaryData("Players($i)_Paired", self::ReadData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 1;
            $sws->setBinaryData("Players($i)_Float", self::ReadData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 1;
            $sws->setBinaryData("Players($i)_FloatPrev", self::ReadData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 1;
            $sws->setBinaryData("Players($i)_FloatBefore", self::ReadData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 1;
            $sws->setBinaryData("Players($i)_TieMatch", self::ReadData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $sws->getTournament()->addPlayer($player);
        }
        // PlayerNames
        $length = (Integer)$sws->getBinaryData("NewNamePos") + 0;
        $sws->setBinaryData("PlayerNames", substr($swscontents, $offset, $length));
        $offset += $length;

        for ($i = 0; $i < $sws->getBinaryData("NewPlayer"); $i++) {
            $namelength = $sws->getBinaryData("Players($i)_NameLength");
            $nameoffset = $sws->getBinaryData("Players($i)_NamePos");
            $player = $sws->getTournament()->getPlayerById($i);
            $player->setName(self::ReadData("String", substr($sws->getBinaryData("PlayerNames"), $nameoffset, $namelength)));

            $sws->getTournament()->updatePlayer($i, $player);
        }

        // TournamentName
        $length = 80;
        $sws->getTournament()->setName(self::ReadData('String', substr($swscontents, $offset, $length)));
        $offset += $length;

        // TournamentOrganiser
        $length = 50;
        $sws->getTournament()->setOrganiser(self::ReadData('String', substr($swscontents, $offset, $length)));
        $offset += $length;

        // TournamentTempo
        $length = 50;
        $sws->getTournament()->setTempo(self::ReadData('String', substr($swscontents, $offset, $length)));
        $offset += $length;

        // TournamentCountry
        $length = 32;
        $sws->getTournament()->setOrganiserCountry(self::ReadData('String', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Arbiters
        $length = 128;
        $sws->getTournament()->setArbiter(self::ReadData('String', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Rounds
        $length = 4;
        $sws->getTournament()->setNoOfRounds(self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Participants
        $length = 4;
        $sws->getTournament()->setParticipants(self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Fidehomol
        $length = 4;
        $sws->getTournament()->setFideHomol(self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // StartDate
        $length = 4;
        $sws->getTournament()->setStartDate(self::ReadData('Date', substr($swscontents, $offset, $length)));
        $offset += $length;

        // EndDate
        $length = 4;
        $sws->getTournament()->setEndDate(self::ReadData('Date', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Place
        $length = 36;
        $sws->getTournament()->setOrganiserPlace(self::ReadData('String', substr($swscontents, $offset, $length)));
        $offset += $length;

        // First period
        $length = 32;
        $sws->getTournament()->setFirstPeriod(self::ReadData('String', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Second period
        $length = 32;
        $sws->getTournament()->setSecondPeriod(self::ReadData('String', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Unrated Elo
        $length = 4;
        $sws->getTournament()->setNonRatedElo(self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Type
        $length = 4;
        $sws->getTournament()->setSystem(new TournamentSystem(self::ReadData('Int', substr($swscontents, $offset, $length))));
        $offset += $length;

        // Federation
        $length = 12;
        $sws->getTournament()->setFederation(self::ReadData('String', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Soustype
        /*
         * 32 Bits:
         * 1 bit  = Libre?
         * 6 bits = First round sent to FIDE
         * 6 bits = First round sent to FRBE-KBSB
         * 6 bits = Last round sent to FIDE
         * 6 bits = Last round sent to FRBE-KBSB
         * 6 bits = Number of the First board
         * 1 bit  = Double round robin
         */
        $length = 4;
        $sws->setBinaryData('SousType', self::ReadData('Hex', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Organising club no
        $length = 4;
        $sws->getTournament()->setOrganiserClubNo(self::ReadData('String', substr($swscontents, $offset, $length), 0));
        $offset += $length;

        // Organising club
        $length = 8;
        $sws->getTournament()->setOrganiserClub(self::ReadData('String', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Tournament year
        $length = 4;
        $sws->getTournament()->setYear(self::ReadData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Round dates
        for ($i = 0; $i < $sws->getTournament()->getNoOfRounds(); $i++) {
            $length = 4;
            $round = new Round();
            $round->setRoundNo($i);
            $round->setDate(self::ReadData('Date', substr($swscontents, $offset, $length)));
            $sws->getTournament()->addRound($round);
            $offset += $length;
        }

        if ($sws->getBinaryData("CurrentRound") > 0) {
            for ($i = 0; $i < $sws->getBinaryData("NewPlayer"); $i++) {
                for ($x = 0; $x < $sws->getBinaryData("CreatedRounds"); $x++) {
                    $pairing = new Pairing();

                    $pairing->setPlayer($sws->getTournament()->getPlayerById($i));

                    $length = 4;
                    $opponent = self::ReadData('Int', substr($swscontents, $offset, $length));
                    if ($opponent != 4294967295) {
                        $pairing->setOpponent($sws->getTournament()->getPlayerById($opponent));
                    }
                    $offset += $length;

                    $length = 1;
                    $pairing->setColor(new Color(self::ReadData('Int', substr($swscontents, $offset, $length))));
                    $offset += $length;

                    $length = 1;
                    $pairing->setResult(new Result(self::ReadData('Int', substr($swscontents, $offset, $length))));
                    $offset += $length;

                    $pairing->setRound($x);
                    $offset += 2;

                    $sws->getTournament()->addPairing($pairing);
                }
            }
        }

        $sws->getTournament()->pairingsToRounds();
        return $sws;
    }

    /**
     * @param string $type
     * @param string $data
     * @param mixed $default
     * @return bool|DateTime|int|string
     */
    private static function ReadData(string $type, string $data, $default = null)
    {
        switch ($type) {
            case 'String':
                $data = trim($data);
                if ($data == '') {
                    return (is_null($default)) ? '' : $default;
                }
                return iconv('windows-1252', 'utf-8', $data);
                break;
            case 'Hex':
            case 'Int':
            case 'Bool':
            case 'Date':
                $hex = implode(unpack("H*", $data));
                $hex = array_reverse(str_split($hex, 2));

                foreach ($hex as $key => $item) {
                    if ($item == "00") {
                        $hex[$key] = "";
                    } else {
                        break;
                    }
                }

                $hex = implode($hex);
                $hex = ($hex == "") ? "00" : $hex;
                if ($type == 'Hex') {
                    if ($hex == '00') {
                        return (is_null($default)) ? '00' : $default;
                    }
                    return $hex;
                } elseif ($type == 'Int') {
                    if ($hex == '00') {
                        return (is_null($default)) ? 0 : $default;
                    }
                    return hexdec($hex);
                } elseif ($type == 'Date') {
                    if ($hex == '00') {
                        return (is_null($default)) ? self::UIntToTimestamp(0) : $default;
                    }
                    return self::UIntToTimestamp(hexdec($hex));
                } elseif ($type == 'Bool') {
                    return ($hex == "01") ? true : false;
                }
                break;
            default:
                throw new \InvalidArgumentException("Datatype not known");
                break;
        }

        return false;
    }

    /**
     * @param int $date
     * @return bool|DateTime
     */
    private static function UIntToTimestamp(int $date)
    {
        $curyear = date('Y');
        $yearoffset = $curyear - self::PT_PASTOFFSET;

        // Day
        $day = $date % self::PT_DAYFACTOR;
        if ($day < 1) {
            $day = 1;
        }

        // Month
        $month = ($date / self::PT_DAYFACTOR) % self::PT_MONTHFACTOR;
        if ($month < 1) {
            $month = 1;
        }

        // Year
        $year = ($date / self::PT_YEARFACTOR) + $yearoffset;

        $concat = $month . '/' . $day . '/' . intval($year);
        $format = 'm/d/Y';


        return DateTime::createFromFormat($format, $concat);
    }
}
