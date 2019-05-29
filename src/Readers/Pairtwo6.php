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

namespace JeroenED\Libpairtwo\Readers;

use JeroenED\Libpairtwo\Enums\Tiebreak;
use JeroenED\Libpairtwo\Enums\Title;
use JeroenED\Libpairtwo\Enums\Gender;
use JeroenED\Libpairtwo\Enums\Color;
use JeroenED\Libpairtwo\Enums\Result;
use JeroenED\Libpairtwo\Exceptions\IncompatibleReaderException;
use JeroenED\Libpairtwo\Tournament;
use JeroenED\Libpairtwo\Player;
use JeroenED\Libpairtwo\Round;
use JeroenED\Libpairtwo\Pairing;
use JeroenED\Libpairtwo\Interfaces\ReaderInterface;
use JeroenED\Libpairtwo\Readers\Models\Pairtwo6 as Pairtwo6Model;
use JeroenED\Libpairtwo\Enums\TournamentSystem;
use DateTime;

/**
 * This class reads a SWS file
 *
 * @author Jeroen De Meerleer
 */
class Pairtwo6 extends Pairtwo6Model implements ReaderInterface
{
    private const PT_DAYFACTOR = 32;
    private const PT_MONTHFACTOR = 16;
    private const PT_YEARFACTOR = 512;
    private const PT_PASTOFFSET = 117;
    private const CompatibleVersions = ['6.', '5.'];

    /**
     * Reads out $swsfile and returns a Pairtwo6 class object
     *
     * @param string $filename
     * @return Pairtwo6
     */
    public function read($filename): ReaderInterface
    {
        $swshandle = fopen($filename, 'rb');
        $swscontents = fread($swshandle, filesize($filename));
        fclose($swshandle);

        $offset = 0;
        

        $length = 4;
        $this->setRelease($this->readData('String', substr($swscontents, $offset, $length)));
        $offset += $length;

        if (array_search(substr($this->getRelease(), 0, 2), self::CompatibleVersions) === false) {
            throw new IncompatibleReaderException("This file was not created with Pairtwo 5 or higher");
        }

        $this->setTournament(new Tournament());

        // UserCountry
        $length = 4;
        $this->setBinaryData("UserCountry", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // SavedOffset
        $length = 4;
        $this->setBinaryData("SavedOffset", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // NewPlayer
        $length = 4;
        $this->setBinaryData("NewPlayer", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // AmericanHandicap
        $length = 4;
        $this->setBinaryData("AmericanHandicap", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // LowOrder
        $length = 4;
        $this->setBinaryData("LowOrder", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // PairingMethod
        $length = 4;
        $this->setBinaryData("PairingMethod", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // AmericanPresence
        $length = 4;
        $this->setBinaryData("AmericanPresence", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // CheckSameClub
        $length = 4;
        $this->setBinaryData("CheckSameClub", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // NoColorCheck
        $length = 4;
        $this->setBinaryData("NoColorCheck", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // SeparateCategories
        $length = 4;
        $this->setBinaryData("SeparateCategories", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // EloUsed
        $length = 4;
        $this->setBinaryData("EloUsed", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // AlternateColors
        $length = 4;
        $this->setBinaryData("AlternateColors", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // MaxMeetings
        $length = 4;
        $this->setBinaryData("MaxMeetings", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // MaxDistance
        $length = 4;
        $this->setBinaryData("MaxDistance", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // MinimizeKeizer
        $length = 4;
        $this->setBinaryData("MinimizeKeizer", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // MinRoundsMeetings
        $length = 4;
        $this->setBinaryData("MinRoundsMeetings", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // MaxRoundsAbsent
        $length = 4;
        $this->setBinaryData("MaxRoundsAbsent", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // SpecialPoints
        $length = 4 * 6;
        $this->setBinaryData("SpecialPoints", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // NewNamePos
        $length = 4;
        $this->setBinaryData("NewNamePos", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // CurrentRound
        $length = 4;
        $this->setBinaryData("CurrentRound", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // CreatedRounds
        $length = 4;
        $this->setBinaryData("CreatedRounds", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // CreatedPlayers
        $length = 4;
        $this->setBinaryData("CreatedPlayers", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // MaxSelection
        $length = 4;
        $this->setBinaryData("MaxSelection", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // NumberOfRounds
        $length = 4;
        $this->setBinaryData("NumberOfRounds", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // NumberOfPairings
        $length = 4;
        $this->setBinaryData("NumberOfPairings", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // CreatedPairings
        $length = 4;
        $this->setBinaryData("CreatedPairings", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // PairingElems
        $length = 4;
        $this->setBinaryData("PairingElems", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // RandomSeed
        $length = 4;
        $this->setBinaryData("RandomSeed", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // TieOrder
        for ($i = 0; $i < 5; $i++) {
            $length = 4;
            switch ($this->readData('Int', substr($swscontents, $offset, $length))) {
                case 1:
                    $tiebreak = Tiebreak::Buchholz;
                    break;
                case 2:
                    $tiebreak = Tiebreak::BuchholzMed;
                    break;
                case 3:
                    $tiebreak = Tiebreak::BuchholzMed;
                    break;
                case 4:
                    $tiebreak = Tiebreak::Sonneborn;
                    break;
                case 5:
                    $tiebreak = Tiebreak::Kashdan;
                    break;
                case 6:
                    $tiebreak = Tiebreak::Cumulative;
                    break;
                case 7:
                    $tiebreak = Tiebreak::Between;
                    break;
                case 8:
                    $tiebreak = Tiebreak::Koya;
                    break;
                case 9:
                    $tiebreak = Tiebreak::Baumbach;
                    break;
                case 10:
                    $tiebreak = Tiebreak::Performance;
                    break;
                case 11:
                    $tiebreak = Tiebreak::Aro;
                    break;
                case 12:
                    $tiebreak = Tiebreak::AroCut;
                    break;
                case 13:
                    $tiebreak = Tiebreak::BlackPlayed;
                    break;
                case 14:
                    $tiebreak = Tiebreak::Testmatch;
                    break;
                case 15:
                    $tiebreak = Tiebreak::Drawing;
                    break;
                case 0:
                default:
                    $tiebreak = Tiebreak::None;
                    break;
            }
            $this->getTournament()->addTieBreak(new Tiebreak($tiebreak));
            $offset += $length;
        }

        // Categorie
        $length = 4 * 10;
        $this->setBinaryData("Categorie", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // ExtraPoints
        $length = 4 * 20;
        $this->setBinaryData("ExtraPoints", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // SelectP
        $length = 4 * 20;
        $this->setBinaryData("SelectP", $this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Players
        for ($i = 0; $i < $this->getBinaryData("NewPlayer"); $i++) {
            $player = new Player();

            // Rank (Unused value)
            $length = 4;
            $player->setBinaryData("Rank", $this->readData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 4;
            $player->setBinaryData("NamePos", $this->readData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 4;
            $player->setId('world', $this->readData('Int', substr($swscontents, $offset, $length) . ""));
            $offset += $length;

            $length = 4;
            $player->setBinaryData("ExtraPts", $this->readData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 4;
            $player->setElo('home', $this->readData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 4;
            $player->SetDateOfBirth($this->readData('Date', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 4;
            $player->setId('home', $this->readData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 4;
            $player->setBinaryData("Points", $this->readData('Int', substr($swscontents, $offset, $length)) / 2);
            $offset += $length;

            $length = 4;
            $player->setId('club', $this->readData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 4;
            $player->setBinaryData("ScoreBuchholz", $this->readData('Int', substr($swscontents, $offset, $length)) / 2);
            $offset += $length;

            $length = 4;
            $player->setBinaryData("ScoreAmerican", $this->readData('Int', substr($swscontents, $offset, $length)) / 2);
            $offset += $length;

            $length = 4;
            $player->setBinaryData("HelpValue", $this->readData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 4;
            $player->setElo('world', $this->readData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 1;
            $player->setBinaryData("NameLength", $this->readData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 3;
            $player->setNation($this->readData('String', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 1;
            $player->setCategory($this->readData('String', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 1;
            switch ($this->readData('Int', substr($swscontents, $offset, $length))) {
                case 1:
                    $title = Title::ELO;
                    break;
                case 2:
                    $title = Title::NM;
                    break;
                case 3:
                    $title = Title::WCM;
                    break;
                case 4:
                    $title = Title::WFM;
                    break;
                case 5:
                    $title = Title::CM;
                    break;
                case 6:
                    $title = Title::WIM;
                    break;
                case 7:
                    $title = Title::FM;
                    break;
                case 8:
                    $title = Title::WGM;
                    break;
                case 9:
                    $title = Title::HM;
                    break;
                case 10:
                    $title = Title::IM;
                    break;
                case 11:
                    $title = Title::HG;
                    break;
                case 12:
                    $title = Title::GM;
                    break;
                case 0:
                default:
                    $title = Title::NONE;
                    break;
            }
            $player->setTitle(new Title($title));
            $offset += $length;

            $length = 1;
            switch ($this->readData('Int', substr($swscontents, $offset, $length))) {
                case 1:
                    $gender = Gender::Male;
                    break;
                case 2:
                    $gender = Gender::Female;
                    break;
                default:
                    $gender = Gender::Neutral;
                    break;
            }
            $player->setGender(new Gender($gender));
            $offset += $length;

            $length = 1;
            $player->setBinaryData('NumberOfTies', $this->readData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 1;
            $player->setBinaryData('Absent', $this->readData('Bool', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 1;
            $player->setBinaryData("ColorDiff", $this->readData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 1;
            $player->setBinaryData("ColorPref", $this->readData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 1;
            $player->setBinaryData("Paired", $this->readData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 1;
            $player->setBinaryData("Float", $this->readData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 1;
            $player->setBinaryData("FloatPrev", $this->readData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 1;
            $player->setBinaryData("FloatBefore", $this->readData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 1;
            $player->setBinaryData("TieMatch", $this->readData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $player->setElos($elos);
            $player->setIds($ids);
            $this->getTournament()->addPlayer($player);
        }
        // PlayerNames
        $length = (Integer)$this->getBinaryData("NewNamePos") + 0;
        $this->setBinaryData("PlayerNames", substr($swscontents, $offset, $length));
        $offset += $length;

        for ($i = 0; $i < $this->getBinaryData("NewPlayer"); $i++) {
            $player = $this->getTournament()->getPlayerById($i);
            $namelength = $player->getBinaryData("NameLength");
            $nameoffset = $player->getBinaryData("NamePos");
            $player->setName($this->readData("String", substr($this->getBinaryData("PlayerNames"), $nameoffset, $namelength)));

            $this->getTournament()->updatePlayer($i, $player);
        }

        // TournamentName
        $length = 80;
        $this->getTournament()->setName($this->readData('String', substr($swscontents, $offset, $length)));
        $offset += $length;

        // TournamentOrganiser
        $length = 50;
        $this->getTournament()->setOrganiser($this->readData('String', substr($swscontents, $offset, $length)));
        $offset += $length;

        // TournamentTempo
        $length = 50;
        $this->getTournament()->setTempo($this->readData('String', substr($swscontents, $offset, $length)));
        $offset += $length;

        // TournamentCountry
        $length = 32;
        $this->getTournament()->setOrganiserCountry($this->readData('String', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Arbiters
        $length = 128;
        $this->getTournament()->setArbiter($this->readData('String', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Rounds
        $length = 4;
        $this->getTournament()->setNoOfRounds($this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Participants
        $length = 4;
        $this->getTournament()->setParticipants($this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Fidehomol
        $length = 4;
        $this->getTournament()->setFideHomol($this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // StartDate
        $length = 4;
        $this->getTournament()->setStartDate($this->readData('Date', substr($swscontents, $offset, $length)));
        $offset += $length;

        // EndDate
        $length = 4;
        $this->getTournament()->setEndDate($this->readData('Date', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Place
        $length = 36;
        $this->getTournament()->setOrganiserPlace($this->readData('String', substr($swscontents, $offset, $length)));
        $offset += $length;

        // First period
        $length = 32;
        $this->getTournament()->setFirstPeriod($this->readData('String', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Second period
        $length = 32;
        $this->getTournament()->setSecondPeriod($this->readData('String', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Unrated Elo
        $length = 4;
        $this->getTournament()->setNonRatedElo($this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Type
        $length = 4;
        switch ($this->readData('Int', substr($swscontents, $offset, $length))) {
            case 2:
                $system = TournamentSystem::Closed;
                break;
            case 4:
                $system = TournamentSystem::American;
                break;
            case 6:
                $system = TournamentSystem::Keizer;
                break;
            case 0:
            default:
                $system = TournamentSystem::Swiss;
                break;
        }
        $this->getTournament()->setSystem(new TournamentSystem($system));
        $offset += $length;

        // Federation
        $length = 12;
        $this->getTournament()->setFederation($this->readData('String', substr($swscontents, $offset, $length)));
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
        $this->setBinaryData('SousType', $this->readData('Hex', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Organising club no
        $length = 4;
        $this->getTournament()->setOrganiserClubNo($this->readData('String', substr($swscontents, $offset, $length), 0));
        $offset += $length;

        // Organising club
        $length = 8;
        $this->getTournament()->setOrganiserClub($this->readData('String', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Tournament year
        $length = 4;
        $this->getTournament()->setYear($this->readData('Int', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Round dates
        for ($i = 0; $i < $this->getTournament()->getNoOfRounds(); $i++) {
            $length = 4;
            $round = new Round();
            $round->setRoundNo($i);
            $round->setDate($this->readData('Date', substr($swscontents, $offset, $length)));
            $this->getTournament()->addRound($round);
            $offset += $length;
        }

        if ($this->getBinaryData("CurrentRound") > 0) {
            for ($i = 0; $i < $this->getBinaryData("NewPlayer"); $i++) {
                for ($x = 0; $x < $this->getBinaryData("CreatedRounds"); $x++) {
                    $pairing = new Pairing();

                    $pairing->setPlayer($this->getTournament()->getPlayerById($i));

                    $length = 4;
                    $opponent = $this->readData('Int', substr($swscontents, $offset, $length));
                    if ($opponent != 4294967295) {
                        $pairing->setOpponent($this->getTournament()->getPlayerById($opponent));
                    }
                    $offset += $length;

                    $length = 1;

                    switch ($this->readData('Int', substr($swscontents, $offset, $length))) {
                        case 255:
                        case 253:
                            $color = Color::black;
                            break;
                        case 1:
                        case 3:
                            $color = Color::white;
                           break;
                        case 0:
                        default:
                            $color = Color::none;
                            break;
                    }
                    $pairing->setColor(new Color($color));
                    $offset += $length;

                    $length = 1;
                    switch ($this->readData('Int', substr($swscontents, $offset, $length))) {
                        case 1:
                            $result = Result::lost;
                            break;
                        case 2:
                            $result = Result::absent;
                            break;
                        case 3:
                            $result = Result::adjourned;
                            break;
                        case 4:
                            $result = Result::bye;
                            break;
                        case 6:
                            $result = Result::draw;
                            break;
                        case 8:
                            $result = Result::drawadjourned;
                            break;
                        case 11:
                            $result = Result::won;
                            break;
                        case 12:
                            $result = Result::wonforfait;
                            break;
                        case 13:
                            $result = Result::wonadjourned;
                            break;
                        case 14:
                            $result = Result::wonbye;
                            break;
                        case 0:
                        default:
                            $result = Result::none;
                            break;
                    }
                    $pairing->setResult(new Result($result));
                    $offset += $length;

                    $pairing->setRound($x);
                    $offset += 2;

                    if ($x < $this->getBinaryData("CurrentRound")) {
                        $this->getTournament()->addPairing($pairing);
                    }
                }
            }
        }

        $this->addTiebreaks();

        $this->getTournament()->pairingsToRounds();
        return $this;
    }

    /**
     * Converts $data to $type and defaults to $default if given
     *
     * Possible types for $type are:
     * * String (UTF-8 String representation of $data.   Default: empty string '')
     * * Hex    (Capitalized Hex Value of $data.         Default: 00)
     * * Int    (Unsigned Integer value of $data         Default: 0)
     * * Bool   (Boolean representation of $data.        Default: false)
     * * Date   (Date representation of $data.           Default: 1902/01/01)
     *
     * @param string $type
     * @param string $data
     * @param mixed $default
     * @return bool|DateTime|int|string
     */
    private function readData(string $type, string $data, $default = null)
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
                        return (is_null($default)) ? $this->convertUIntToTimestamp(0) : $default;
                    }
                    return $this->convertUIntToTimestamp(hexdec($hex));
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
     * Converts integer value to a date representation
     *
     * @param int $date
     * @return bool|DateTime
     */
    private function convertUIntToTimestamp(int $date)
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


    /**
     * @return $this
     */
    private function addTiebreaks(): Pairtwo6
    {
        switch ($this->getTournament()->getSystem()) {
            case TournamentSystem::Keizer:
                $firstElement = new Tiebreak(Tiebreak::Keizer);
                break;
            case TournamentSystem::American:
                $firstElement = new Tiebreak(Tiebreak::American);
                break;
            case TournamentSystem::Closed:
            case TournamentSystem::Swiss:
                $firstElement = new Tiebreak(Tiebreak::Points);
        }
        $tiebreaks = $this->getTournament()->getTiebreaks();
        array_unshift($tiebreaks, $firstElement);
        $this->getTournament()->setTiebreaks($tiebreaks);
        return $this;
    }
}
