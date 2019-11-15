<?php
/**
 * Reader Swar4
 *
 * Reads out Swar-4 files
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
 * Class Swar4
 * @package JeroenED\Libpairtwo\Readers
 */
class Swar4 implements ReaderInterface
{
    /** @var Tournament */
    public $Tournament;

    /** @var string */
    public $Release;

    /** @var bool|int|DateTime|string[] */
    private $BinaryData;

    /** @var array  */
    private const CompatibleVersions = ['v4.'];

    private const Tempos = [
        [
            '105 min/40 moves + 15 min. QPF',
            '120 min/40 moves + 15 min. with incr. 30" starting from 40th move',
            '120 min/40 moves + 30 min. QPF',
            '120 min/10 moves + 30 min. avec incr. 30" starting from 40th move',
            '120 min QPF',
            '150 min QPF',
            '60 min QPF',
            '60 min with incr. 30"',
            '65 min QPF',
            '75 min with incr. 30"',
            '90 min/40 moves + 15 min with incr. 30" starting from 1st move',
            '90 min/40 moves + 30 min with incr. 30" starting from 1st move',
            '90 min with incr. 30"',
            '50 min with incr. 10"',
            'other'
        ],[
            '10 min. with incr. 10"',
            '10 min. with incr. 15"',
            '10 min. with incr.5"',
            '11 min. QPF',
            '12 min. QPF',
            '13 min. with incr.3"',
            '13 min. with incr.5"',
            '15 min. QPF',
            '15 min. with incr. 10"',
            '15 min. with incr. 15"',
            '15 min. with incr.5"',
            '20 min. QPF',
            '20 min. with incr. 10"',
            '20 min. with incr. 15"',
            '20 min. with incr.5"',
            '25 min. QPF',
            '25 min. with incr. 10"',
            '25 min. with incr. 15"',
            '25 min. with incr.5"',
            '30 min. QPF',
            '45 min. QPF',
            '8 min. with incr.4"',
            'other'
        ],[
            '3 min. with incr. 2"',
            '3 min. with incr. 3"',
            '4 min. with incr. 2"',
            '4 min. with incr. 3"',
            '5 min. QPF',
            '5 min. with incr. 2"',
            '5 min. with incr. 3"',
            '6 min. with incr. 2"',
            '6 min. with incr. 3"',
            '7 min. with incr. 2"',
            '7 min. with incr. 3"',
            '8 min. with incr. 2"',
            '10 min. QPF',
            'other'
        ]
    ];

    /**
     * @param string $filename
     * @return ReaderInterface
     * @throws IncompatibleReaderException
     */
    public function read(string $filename): ReaderInterface
    {
        $swshandle = fopen($filename, 'rb');

        $this->Release = $this->readData('String', $swshandle);
        if (array_search(substr($this->Release, 0, 3), self::CompatibleVersions) === false) {
            throw new IncompatibleReaderException("This file was not created with Swar 4");
        }

        $this->Tournament = new Tournament();

        $this->Guid = $this->readData('String', $swshandle);
        $this->MacAddress = $this->readData('String', $swshandle);

        // [Tournoi]
        $this->readData('String', $swshandle);

        $this->Tournament->Name = $this->readData('String', $swshandle);
        $this->Tournament->Organiser = $this->readData('String', $swshandle);
        $this->Tournament->OrganiserClub = $this->readData('String', $swshandle);
        $this->Tournament->OrganiserPlace = $this->readData('String', $swshandle);

        $this->Tournament->addArbiter($this->readData('String', $swshandle));
        $this->Tournament->addArbiter($this->readData('String', $swshandle));

        $this->Tournament->StartDate = $this->readData('Date', $swshandle);
        $this->Tournament->EndDate = $this->readData('Date', $swshandle);

        // Tempo string is not variable and dependant on kind of tournament
        $this->Tournament->TempoIndex = $this->readData('Int', $swshandle);

        $this->Tournament->NoOfRounds = $this->readData('Int', $swshandle);

        $this->Tournament->FRBEfrom = $this->readData('Int', $swshandle);
        $this->Tournament->FRBEto = $this->readData('Int', $swshandle);
        $this->Tournament->FIDEfrom = $this->readData('Int', $swshandle);
        $this->Tournament->FIDEto = $this->readData('Int', $swshandle);
        $this->Tournament->CatSepares = $this->readData('Int', $swshandle);
        $this->Tournament->AfficherEloOuPays = $this->readData('Int', $swshandle);

        $this->Tournament->FideHomol = $this->readData('Int', $swshandle);

        $this->Tournament->FideId = $this->readData('String', $swshandle);
        $this->Tournament->FideArbitre1 = $this->readData('String', $swshandle);
        $this->Tournament->FideArbitre2 = $this->readData('String', $swshandle);
        $this->Tournament->FideEmail = $this->readData('String', $swshandle);
        $this->Tournament->FideRemarques = $this->readData('String', $swshandle);

        switch ($this->readData('Int', $swshandle)) {
            case 0:
            case 1:
            case 2:
            case 3:
            case 4:
            default:
                $system = TournamentSystem::Swiss;
                break;
            case 5:
            case 6:
            case 7:
                $system = TournamentSystem::Closed;
                break;
            case 8:
            case 9:
                $system = TournamentSystem::American;
                break;
        }
        $this->Tournament->System = new TournamentSystem($system);

        $this->Tournament->Dummy1 = $this->readData('Int', $swshandle);
        $this->Tournament->Dummy2 = $this->readData('Int', $swshandle);
        $this->Tournament->SW_AmerPresence = $this->readData('Int', $swshandle);
        $this->Tournament->Plusieurs = $this->readData('Int', $swshandle);
        $this->Tournament->FirstTable = $this->readData('Int', $swshandle);
        $this->Tournament->SW321_Win = $this->readData('Int', $swshandle);
        $this->Tournament->SW321_Nul = $this->readData('Int', $swshandle);
        $this->Tournament->SW321_Los = $this->readData('Int', $swshandle);
        $this->Tournament->SW321_Bye = $this->readData('Int', $swshandle);
        $this->Tournament->SW321_Pre = $this->readData('Int', $swshandle);
        $this->Tournament->EloUsed = $this->readData('Int', $swshandle);
        $this->Tournament->TournoiStd = $this->readData('Int', $swshandle);
        $this->Tournament->TbPersonel = $this->readData('Int', $swshandle);
        $this->Tournament->ApparOrder = $this->readData('Int', $swshandle);
        $this->Tournament->EloEqual = $this->readData('Int', $swshandle);
        $this->Tournament->ByeValue = $this->readData('Int', $swshandle);
        $this->Tournament->AbsValue = $this->readData('Int', $swshandle);
        $this->Tournament->FF_Value = $this->readData('Int', $swshandle);

        switch ($this->readData('Int', $swshandle)) {
            case 0:
            default:
                $federation = '';
                break;
            case 1:
                $federation = 'FRBE';
                break;
            case 2:
                $federation = 'KBSB';
                break;
            case 3:
                $federation = 'FEFB';
                break;
            case 4:
                $federation = 'VSF';
                break;
            case 5:
                $federation = 'SVDB';
                break;
            case 6:
                $federation = 'FIDE';
                break;
        }
        $this->Tournament->Federation = $federation;
        $this->Tournament->NonRatedElo = 0;
        $this->Tournament->OrganiserClubNo = 0;
        // [DATES]
        $this->readData('String', $swshandle);

        $this->Tournament->Tempo = Self::Tempos[$this->Tournament->TournoiStd][$this->Tournament->TempoIndex];

        for ($i = 0; $i < $this->Tournament->NoOfRounds; $i++) {
            $round = new Round();
            $round->RoundNo = $i;
            $round->Date = $this->readData('Date', $swshandle);
            $this->Tournament->addRound($round);
        }

        // [TIE_BREAK]
        $this->readData('String', $swshandle);

        $tiebreaks = [];
        for ($i = 0; $i < 5; $i++) {
            switch ($this->readData('Int', $swshandle)) {
                case 0:
                default:
                    $tiebreak = Tiebreak::None;
                    break;
                case 1:
                    $tiebreak = Tiebreak::Buchholz;
                    break;
                case 2:
                    $tiebreak = Tiebreak::BuchholzMed;
                    break;
                case 3:
                    $tiebreak = Tiebreak::BuchholzMed2;
                    break;
                case 4:
                    $tiebreak = Tiebreak::BuchholzCut;
                    break;
                case 5:
                    $tiebreak = Tiebreak::BuchholzCut2;
                    break;
                case 6:
                    $tiebreak = Tiebreak::Sonneborn;
                    break;
                case 7:
                    $tiebreak = Tiebreak::Cumulative;
                    break;
                case 8:
                    $tiebreak = Tiebreak::Between;
                    break;
                case 9:
                    $tiebreak = Tiebreak::Koya;
                    break;
                case 10:
                    $tiebreak = Tiebreak::Baumbach;
                    break;
                case 11:
                    $tiebreak = Tiebreak::AveragePerformance;
                    break;
                case 12:
                    $tiebreak = Tiebreak::Aro;
                    break;
                case 13:
                    $tiebreak = Tiebreak::AroCut;
                    break;
                case 14:
                    $tiebreak = Tiebreak::BlackPlayed;
                    break;
                case 15:
                    $tiebreak = Tiebreak::BlackWin;
                    break;
            }
            $tiebreaks[] = new Tiebreak($tiebreak);
        }
        $this->Tournament->Tiebreaks = $tiebreaks;

        // [EXCLUSION]
        $this->readData('String', $swshandle);
        $this->Tournament->ExclusionType = $this->readData('Int', $swshandle);
        $this->Tournament->ExclusionValue = $this->readData('String', $swshandle);

        // [CATEGORIES]
        $this->readData('String', $swshandle);

        $this->Tournament->Catogory_type = $this->readData('Int', $swshandle);
        for ($i = 0; $i <= 12; $i++) {
            $this->Tournament->Category[$i]['Cat1'] =$this->readData('String', $swshandle);
        }

        for ($i = 0; $i <= 12; $i++) {
            $this->Tournament->Category[$i]['Cat2'] =$this->readData('String', $swshandle);
        }

        // [XTRA_POINTS]
        $this->readData('String', $swshandle);

        for ($i = 0; $i < 4; $i++) {
            $this->Tournament->Extrapoints[$i]['pts'] =$this->readData('Int', $swshandle);
            $this->Tournament->Extrapoints[$i]['elo'] =$this->readData('Int', $swshandle);
        }

        // [JOUEURS]
        $this->readData('String', $swshandle);

        $roundNo = 0;
        $playerNo = 0;
        $this->Tournament->NumberOfPlayers = $this->readData('Int', $swshandle);

        $pt = 0;
        for ($i = 0; $i < $this->Tournament->NumberOfPlayers; $i++) {
            $player = new Player();
            $player->Classement = $this->readData('Int', $swshandle);
            $player->Name = $this->readData('String', $swshandle);
            $inscriptionNos[$this->readData('Int', $swshandle)] = $i;
            $player->Rank = $this->readData('Int', $swshandle);
            $player->CatIndex = $this->readData('Int', $swshandle);
            $player->DateOfBirth = $this->readData('Date', $swshandle);
            switch ($this->readData('Int', $swshandle)) {
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

            $player->Nation = $this->readData('String', $swshandle);
            $player->setId('Nation', $this->readData('Int', $swshandle));
            $player->setId('Fide', $this->readData('Int', $swshandle));
            $player->Affliation = $this->readData('Int', $swshandle);
            $player->setElo('Nation', $this->readData('Int', $swshandle));
            $player->setElo('Fide', $this->readData('Int', $swshandle));
            switch ($this->readData('Int', $swshandle)) {
                case 1:
                    $title = Title::WCM;
                    break;
                case 2:
                    $title = Title::WFM;
                    break;
                case 3:
                    $title = Title::CM;
                    break;
                case 4:
                    $title = Title::WIM;
                    break;
                case 5:
                    $title = Title::FM;
                    break;
                case 6:
                    $title = Title::WGM;
                    break;
                case 7:
                    $title = Title::HM;
                    break;
                case 8:
                    $title = Title::IM;
                    break;
                case 9:
                    $title = Title::HG;
                    break;
                case 10:
                    $title = Title::GM;
                    break;
                case 0:
                default:
                    $title = Title::NONE;
                    break;
            }
            $player->Title = new Title($title);

            $player->setId('Club', $this->readData('Int', $swshandle));
            $player->ClubName = $this->readData('String', $swshandle);
            $player->NoOfMatchesNoBye = $this->readData('Int', $swshandle);
            $player->Points = $this->readData('Int', $swshandle); // To Calculate by libpairtwo
            $player->AmericanPoints = $this->readData('Int', $swshandle); // To Calculate by libpairtwo
            for ($t = 0; $t < 5; $t++) {
                $player->Tiebreak[$t] = $this->readData('Int', $swshandle); // To Calculate by libpairtwo
            }
            $player->Performance = $this->readData('Int', $swshandle); // To Calculate by libpairtwo
            $player->Absent = $this->readData('Int', $swshandle);
            $player->AbsentRounds = $this->readData('String', $swshandle);
            $player->ExtraPoints = $this->readData('Int', $swshandle);
            $player->SpecialPoints = $this->readData('Int', $swshandle);
            $player->AllocatedRounds = $this->readData('Int', $swshandle);
            // [RONDE]
            $this->readData('String', $swshandle);

            if ($player->AllocatedRounds != 0) {
                for ($j = 0; $j < $player->AllocatedRounds; $j++) {
                    $this->Tournament->Pairing[$pt]['player'] =$i;
                    $this->Tournament->Pairing[$pt]['round'] =$this->readData('Int', $swshandle) - 1;
                    $this->Tournament->Pairing[$pt]['table'] =$this->readData('Int', $swshandle) - 1;
                    $this->Tournament->Pairing[$pt]['opponent'] =$this->readData('Int', $swshandle);
                    $this->Tournament->Pairing[$pt]['result'] =$this->readData('Hex', $swshandle);
                    $this->Tournament->Pairing[$pt]['color'] =$this->readData('Int', $swshandle);
                    $this->Tournament->Pairing[$pt]['float'] =$this->readData('Int', $swshandle);
                    $this->Tournament->Pairing[$pt]['extrapoints'] =$this->readData('Int', $swshandle);

                    $pt++;
                }
            }

            $this->Tournament->addPlayer($player);
        }

        $ptn = 0;
        while (null !== $this->Tournament->Pairing[$ptn]['round']) {
            $pairing = new Pairing();

            $pairing->Player = $this->Tournament->getPlayerById($this->Tournament->Pairing[$ptn]['player']);
            $pairing->Round = $this->Tournament->Pairing[$ptn]['round'];
            if ($this->Tournament->Pairing[$ptn]['opponent'] != 4294967295) {
                $pairing->Opponent = $this->Tournament->getPlayerById($inscriptionNos[$this->Tournament->Pairing[$ptn]['opponent']]);
            }
            switch ($this->Tournament->Pairing[$ptn]['result']) {
                case '1000':
                    $result = Result::Lost;
                    break;
                case '01':
                    $result = Result::Absent;
                    break;
                case '0010':
                    $result = Result::Bye;
                    break;
                case '2000':
                    $result = Result::Draw;
                    break;
                case '4000':
                    $result = Result::Won;
                    break;
                case '04':
                    $result = Result::WonForfait;
                    break;
                case '40':
                    $result = Result::WonBye;
                    break;
                case '00':
                default:
                    $result = Result::None;
                    break;
            }
            if (array_search($this->Tournament->Pairing[$ptn]['table'], [ 16383, 8191 ]) !== false) {
                $result = Result::Absent;
            }
            $pairing->Result = new Result($result);

            switch ($this->Tournament->Pairing[$ptn]['color']) {
                case 4294967295:
                    $color = Color::Black;
                    break;
                case 1:
                    $color = Color::White;
                    break;
                case 0:
                default:
                    $color = Color::None;
                    break;
            }
            $pairing->Color = new Color($color);

            $pairing->Board = $this->Tournament->Pairing[$ptn]['table'];
            $ptn++;
            $this->Tournament->addPairing($pairing);
        }
        fclose($swshandle);
        $this->Tournament->pairingsToRounds();
        $this->addTiebreaks();
        return $this;
    }

    /**
     * @param string $type
     * @param $handle
     * @param null $default
     * @return array|bool|DateTime|false|float|int|string|null
     */
    private function readData(string $type, $handle, $default = null)
    {
        switch ($type) {
            case 'String':
            case 'Date':
                $length = $this->readData('Int', $handle);
                if ($length == 0) {
                    return '';
                }
                $data = fread($handle, $length);
                if ($type == 'String') {
                    if ($data == '') {
                        return (is_null($default)) ? '' : $default;
                    }
                    return iconv('windows-1252', 'utf-8', $data);
                } elseif ($type == 'Date') {
                    if ($data == '') {
                        return (is_null($default)) ? $this->convertStringToDate('01/01/1900') : $default;
                    }
                    return $this->convertStringToDate($data);
                }
                break;
            case 'Hex':
            case 'Int':
            case 'Bool':
                $data = fread($handle, 4);
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
     * Returns binary data that was read out the swar file but was not needed immediately
     *
     * @param string $Key
     * @return bool|DateTime|int|string|null
     */
    public function __get(string $Key)
    {
        if (isset($this->BinaryData[$Key])) {
            return $this->BinaryData[$Key];
        }
        return null;
    }

    /**
     * Sets binary data that is read out the swar file but is not needed immediately
     *
     * @param string $Key
     * @param bool|int|DateTime|string $Value
     * @return void
     */
    public function __set(string $Key, $Value): void
    {
        $this->BinaryData[$Key] = $Value;
    }

    /**
     * @param string $string
     * @return DateTime
     */
    public function convertStringToDate(string $string): DateTime
    {
        if (strlen($string) == 10) {
            return DateTime::createFromFormat('d/m/Y', $string);
        } elseif (strlen($string) == 8) {
            return DateTime::createFromFormat('Ymd', $string);
        }
    }

    /**
     * @return $this
     */
    private function addTiebreaks(): Swar4
    {
        switch ($this->Tournament->System) {
            case TournamentSystem::American:
            case TournamentSystem::Closed:
            case TournamentSystem::Swiss:
            default:
                $firstElement = new Tiebreak(Tiebreak::Points);
        }
        $tiebreaks = $this->Tournament->Tiebreaks;
        array_unshift($tiebreaks, $firstElement);
        $this->Tournament->Tiebreaks = $tiebreaks;
        return $this;
    }
}
