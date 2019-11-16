<?php
/**
 * Reader Pairtwo6
 *
 * Reads out Pairtwo-6 files
 *
 * @author      Jeroen De Meerleer <schaak@jeroened.be>
 * @category    Main
 * @package     Libpairtwo
 * @copyright   Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */


namespace JeroenED\Libpairtwo\Readers;

use JeroenED\Libpairtwo\Enums\Color;
use JeroenED\Libpairtwo\Enums\Gender;
use JeroenED\Libpairtwo\Enums\Result;
use JeroenED\Libpairtwo\Enums\Tiebreak;
use JeroenED\Libpairtwo\Enums\Title;
use JeroenED\Libpairtwo\Enums\TournamentSystem;
use JeroenED\Libpairtwo\Exceptions\IncompatibleReaderException;
use JeroenED\Libpairtwo\Interfaces\ReaderInterface;
use JeroenED\Libpairtwo\Pairing;
use JeroenED\Libpairtwo\Player;
use JeroenED\Libpairtwo\Round;
use JeroenED\Libpairtwo\Tournament;
use DateTime;

/**
 * Reader Pairtwo6
 *
 * Reads out Pairtwo-6 files
 *
 * @author      Jeroen De Meerleer <schaak@jeroened.be>
 * @category    Main
 * @package     Libpairtwo
 * @copyright   Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */
class Pairtwo6 implements ReaderInterface
{
    private const PT_DAYFACTOR = 32;
    private const PT_MONTHFACTOR = 16;
    private const PT_YEARFACTOR = 512;
    private const PT_PASTOFFSET = 117;
    private const CompatibleVersions = ['6.', '5.'];

    /** @var string */
    public $Release;

    /** @var Tournament */
    public $Tournament;

    /** @var bool|DateTime|int|string[] */
    private $BinaryData;

    /**
     * Returns binary data that was read out the pairtwo file but was not needed immediately
     *
     * @param string $key
     * @return bool|DateTime|int|string|null
     */
    public function __get(string $key)
    {
        if (isset($this->BinaryData[$key])) {
            return $this->BinaryData[$key];
        }
        return null;
    }

    /**
     * Sets binary data that is read out the pairtwo file but is not needed immediately
     *
     * @param string $key
     * @param bool|int|DateTime|string $Valueey
     */
    public function __set(string $key, $Valueey): void
    {
        $this->BinaryData[$key] = $Valueey;
    }

    /**
     * Reads out $swsfile and returns a Pairtwo6 class object
     *
     * @param string $filename
     * @throws IncompatibleReaderException
     */
    public function read(string $filename): void
    {
        $swshandle = fopen($filename, 'rb');
        $swscontents = fread($swshandle, filesize($filename));
        fclose($swshandle);

        $offset = 0;


        $length = 4;
        $this->Release = $this->readData('String', substr($swscontents, $offset, $length));
        $offset += $length;

        if (array_search(substr($this->Release, 0, 2), self::CompatibleVersions) === false) {
            throw new IncompatibleReaderException("This file was not created with Pairtwo 5 or higher");
        }

        $this->Tournament = new Tournament();
        $this->Tournament->PriorityElo = 'Nation';
        $this->Tournament->PriorityId = 'Nation';
        // UserCountry
        $length = 4;
        $this->UserCountry = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // SavedOffset
        $length = 4;
        $this->SavedOffset = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // NewPlayer
        $length = 4;
        $this->NewPlayer = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // AmericanHandicap
        $length = 4;
        $this->AmericanHandicap = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // LowOrder
        $length = 4;
        $this->LowOrder = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // PairingMethod
        $length = 4;
        $this->PairingMethod = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // AmericanPresence
        $length = 4;
        $this->AmericanPresence = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // CheckSameClub
        $length = 4;
        $this->CheckSameClub = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // NoColorCheck
        $length = 4;
        $this->NoColorCheck = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // SeparateCategories
        $length = 4;
        $this->SeparateCategories = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // EloUsed
        $length = 4;
        $this->EloUsed = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // AlternateColors
        $length = 4;
        $this->AlternateColors = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // MaxMeetings
        $length = 4;
        $this->MaxMeetings = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // MaxDistance
        $length = 4;
        $this->MaxDistance = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // MinimizeKeizer
        $length = 4;
        $this->MinimizeKeizer = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // MinRoundsMeetings
        $length = 4;
        $this->MinRoundsMeetings = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // MaxRoundsAbsent
        $length = 4;
        $this->MaxRoundsAbsent = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // SpecialPoints
        $length = 4 * 6;
        $this->SpecialPoints = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // NewNamePos
        $length = 4;
        $this->NewNamePos = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // CurrentRound
        $length = 4;
        $this->CurrentRound = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // CreatedRounds
        $length = 4;
        $this->CreatedRounds = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // CreatedPlayers
        $length = 4;
        $this->CreatedPlayers = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // MaxSelection
        $length = 4;
        $this->MaxSelection = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // NumberOfRounds
        $length = 4;
        $this->NumberOfRounds = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // NumberOfPairings
        $length = 4;
        $this->NumberOfPairings = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // CreatedPairings
        $length = 4;
        $this->CreatedPairings = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // PairingElems
        $length = 4;
        $this->PairingElems = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // RandomSeed
        $length = 4;
        $this->RandomSeed = $this->readData('Int', substr($swscontents, $offset, $length));
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
                    $tiebreak = Tiebreak::BuchholzCut;
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
            $this->Tournament->addTieBreak(new Tiebreak($tiebreak));
            $offset += $length;
        }

        // Categorie
        $length = 4 * 10;
        $this->Categorie = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // ExtraPoints
        $length = 4 * 20;
        $this->ExtraPoints = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // SelectP
        $length = 4 * 20;
        $this->SelectP = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // Players
        for ($i = 0; $i < $this->NewPlayer; $i++) {
            $player = new Player();

            // Rank (Unused value)
            $length = 4;
            $player->Rank = $this->readData('Int', substr($swscontents, $offset, $length));
            $offset += $length;

            $length = 4;
            $player->NamePos = $this->readData('Int', substr($swscontents, $offset, $length));
            $offset += $length;

            $length = 4;
            $player->setId('Fide', $this->readData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 4;
            $player->ExtraPts = $this->readData('Int', substr($swscontents, $offset, $length));
            $offset += $length;

            $length = 4;
            $player->setElo('Nation', $this->readData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 4;
            $player->DateOfBirth = $this->readData('Date', substr($swscontents, $offset, $length));
            $offset += $length;

            $length = 4;
            $player->setId('Nation', $this->readData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 4;
            $player->Points = $this->readData('Int', substr($swscontents, $offset, $length)) / 2;
            $offset += $length;

            $length = 4;
            $player->setId('Club', $this->readData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 4;
            $player->ScoreBuchholz = $this->readData('Int', substr($swscontents, $offset, $length)) / 2;
            $offset += $length;

            $length = 4;
            $player->ScoreAmerican = $this->readData('Int', substr($swscontents, $offset, $length)) / 2;
            $offset += $length;

            $length = 4;
            $player->HelpValue = $this->readData('Int', substr($swscontents, $offset, $length));
            $offset += $length;

            $length = 4;
            $player->setElo('Fide', $this->readData('Int', substr($swscontents, $offset, $length)));
            $offset += $length;

            $length = 1;
            $player->NameLength = $this->readData('Int', substr($swscontents, $offset, $length));
            $offset += $length;

            $length = 3;
            $player->Nation = $this->readData('String', substr($swscontents, $offset, $length));
            $offset += $length;

            $length = 1;
            $player->Category = $this->readData('String', substr($swscontents, $offset, $length));
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
            $player->Title = new Title($title);
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
            $player->Gender = new Gender($gender);
            $offset += $length;

            $length = 1;
            $player->NumberOfTies = $this->readData('Int', substr($swscontents, $offset, $length));
            $offset += $length;

            $length = 1;
            $player->Absent = $this->readData('Bool', substr($swscontents, $offset, $length));
            $offset += $length;

            $length = 1;
            $player->ColorDiff = $this->readData('Int', substr($swscontents, $offset, $length));
            $offset += $length;

            $length = 1;
            $player->ColorPref = $this->readData('Int', substr($swscontents, $offset, $length));
            $offset += $length;

            $length = 1;
            $player->Paired = $this->readData('Int', substr($swscontents, $offset, $length));
            $offset += $length;

            $length = 1;
            $player->Float = $this->readData('Int', substr($swscontents, $offset, $length));
            $offset += $length;

            $length = 1;
            $player->FloatPrev = $this->readData('Int', substr($swscontents, $offset, $length));
            $offset += $length;

            $length = 1;
            $player->FloatBefore = $this->readData('Int', substr($swscontents, $offset, $length));
            $offset += $length;

            $length = 1;
            $player->TieMatch = $this->readData('Int', substr($swscontents, $offset, $length));
            $offset += $length;

            $this->Tournament->addPlayer($player);
        }
        // PlayerNames
        $length = (Integer)$this->NewNamePos + 0;
        $this->PlayerNames = substr($swscontents, $offset, $length);
        $offset += $length;

        for ($i = 0; $i < $this->NewPlayer; $i++) {
            $player = $this->Tournament->PlayerById($i);
            $namelength = $player->NameLength;
            $nameoffset = $player->NamePos;
            $player->Name = $this->readData("String", substr($this->PlayerNames, $nameoffset, $namelength));

            $this->Tournament->updatePlayer($i, $player);
        }

        // TournamentName
        $length = 80;
        $this->Tournament->Name = $this->readData('String', substr($swscontents, $offset, $length));
        $offset += $length;

        // TournamentOrganiser
        $length = 50;
        $this->Tournament->Organiser = $this->readData('String', substr($swscontents, $offset, $length));
        $offset += $length;

        // TournamentTempo
        $length = 50;
        $this->Tournament->Tempo = $this->readData('String', substr($swscontents, $offset, $length));
        $offset += $length;

        // TournamentCountry
        $length = 32;
        $this->Tournament->OrganiserCountry = $this->readData('String', substr($swscontents, $offset, $length));
        $offset += $length;

        // Arbiters
        $length = 128;
        $this->Tournament->addArbiter($this->readData('String', substr($swscontents, $offset, $length)));
        $offset += $length;

        // Rounds
        $length = 4;
        $this->Tournament->NoOfRounds = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // Participants
        $length = 4;
        $this->Participants = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // Fidehomol
        $length = 4;
        $this->Tournament->FideHomol = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // StartDate
        $length = 4;
        $this->Tournament->StartDate = $this->readData('Date', substr($swscontents, $offset, $length));
        $offset += $length;

        // EndDate
        $length = 4;
        $this->Tournament->EndDate = $this->readData('Date', substr($swscontents, $offset, $length));
        $offset += $length;

        // Place
        $length = 36;
        $this->Tournament->OrganiserPlace = $this->readData('String', substr($swscontents, $offset, $length));
        $offset += $length;

        // First period
        $length = 32;
        $this->Tournament->FirstPeriod = $this->readData('String', substr($swscontents, $offset, $length));
        $offset += $length;

        // Second period
        $length = 32;
        $this->Tournament->SecondPeriod = $this->readData('String', substr($swscontents, $offset, $length));
        $offset += $length;

        // Unrated Elo
        $length = 4;
        $this->Tournament->NonRatedElo = $this->readData('Int', substr($swscontents, $offset, $length));
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
        $this->Tournament->System = new TournamentSystem($system);
        $offset += $length;

        // Federation
        $length = 12;
        $this->Tournament->Federation = $this->readData('String', substr($swscontents, $offset, $length));
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
        $this->SousType = $this->readData('Hex', substr($swscontents, $offset, $length));
        $offset += $length;

        // Organising club no
        $length = 4;
        $this->Tournament->OrganiserClubNo = $this->readData('String', substr($swscontents, $offset, $length), 0);
        $offset += $length;

        // Organising club
        $length = 8;
        $this->Tournament->OrganiserClub = $this->readData('String', substr($swscontents, $offset, $length));
        $offset += $length;

        // Tournament year
        $length = 4;
        $this->Tournament->Year = $this->readData('Int', substr($swscontents, $offset, $length));
        $offset += $length;

        // Round dates
        for ($i = 0; $i < $this->Tournament->NoOfRounds; $i++) {
            $length = 4;
            $round = new Round();
            $round->RoundNo = $i;
            $round->Date = $this->readData('Date', substr($swscontents, $offset, $length));
            $this->Tournament->addRound($round);
            $offset += $length;
        }

        if ($this->CurrentRound > 0) {
            for ($i = 0; $i < $this->NewPlayer; $i++) {
                for ($x = 0; $x < $this->CreatedRounds; $x++) {
                    $pairing = new Pairing();

                    $pairing->Player = $this->Tournament->PlayerById($i);

                    $length = 4;
                    $opponent = $this->readData('Int', substr($swscontents, $offset, $length));
                    if ($opponent != 4294967295) {
                        $pairing->Opponent = $this->Tournament->PlayerById($opponent);
                    }
                    $offset += $length;

                    $length = 1;

                    switch ($this->readData('Int', substr($swscontents, $offset, $length))) {
                        case 255:
                        case 253:
                            $color = Color::Black;
                            break;
                        case 1:
                        case 3:
                            $color = Color::White;
                           break;
                        case 0:
                        default:
                            $color = Color::None;
                            break;
                    }
                    $pairing->Color = new Color($color);
                    $offset += $length;

                    $length = 1;
                    switch ($this->readData('Int', substr($swscontents, $offset, $length))) {
                        case 1:
                            $result = Result::Lost;
                            break;
                        case 2:
                            $result = Result::Absent;
                            break;
                        case 3:
                            $result = Result::Adjourned;
                            break;
                        case 4:
                            $result = Result::Bye;
                            break;
                        case 6:
                            $result = Result::Draw;
                            break;
                        case 8:
                            $result = Result::DrawAdjourned;
                            break;
                        case 11:
                            $result = Result::Won;
                            break;
                        case 12:
                            $result = Result::WonForfait;
                            break;
                        case 13:
                            $result = Result::WonAdjourned;
                            break;
                        case 14:
                            $result = Result::WonBye;
                            break;
                        case 0:
                        default:
                            $result = Result::None;
                            break;
                    }
                    $pairing->Result = new Result($result);
                    $offset += $length;

                    $pairing->Round = $x;
                    $offset += 2;

                    $pairing->Board = -1;
                    if ($x < $this->CurrentRound) {
                        $this->Tournament->addPairing($pairing);
                    }
                }
            }
        }

        $this->addTiebreaks();

        $this->Tournament->pairingsToRounds();
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
        switch ($this->Tournament->System) {
            case TournamentSystem::Keizer:
                $firstElement = new Tiebreak(Tiebreak::Keizer);
                break;
            case TournamentSystem::American:
            case TournamentSystem::Closed:
            case TournamentSystem::Swiss:
                $firstElement = new Tiebreak(Tiebreak::Points);
                break;
        }
        $tiebreaks = $this->Tournament->Tiebreaks;
        array_unshift($tiebreaks, $firstElement);
        $this->Tournament->Tiebreaks = $tiebreaks;
    }
}
