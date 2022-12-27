<?php

/**
 * Reader Swar-4
 *
 * Reads out Swar-4 files
 *
 * @author    Jeroen De Meerleer <schaak@jeroened.be>
 * @category  Main
 * @package   Libpairtwo
 * @copyright Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */

namespace JeroenED\Libpairtwo\Readers;

use DateTime;
use InvalidArgumentException;
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

/**
 * Reader Swar5
 *
 * Reads out Swar-5 files
 *
 * @author    Jeroen De Meerleer <schaak@jeroened.be>
 * @category  Main
 * @package   Libpairtwo
 * @copyright Copyright (c) 2018-2021 Jeroen De Meerleer <schaak@jeroened.be>
 */
class Swar5 implements ReaderInterface
{
    /**
     * @var array
     */
    public const COMPATIBLE_VERSIONS = ['v5.'];

    public const TEMPOS = [
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
        ],
        [
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
        ],
        [
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
     * Binary data that was read out of the pairing file
     *
     * @var bool|DateTime|int|string[]
     */
    private $BinaryData;

    /**
     * Version of Pairtwo this file was created with
     *
     * @var string
     */
    public $Release;

    /**
     * The tournament
     *
     * @var Tournament
     */
    public $Tournament;

    /**
     * Returns binary data that was read out the swar file but was not needed immediately
     *
     * @param string $key
     *
     * @return bool|DateTime|int|string|null
     */
    public function __get(string $key)
    {
        if (isset($this->BinaryData[ $key ])) {
            return $this->BinaryData[ $key ];
        }

        return null;
    }

    /**
     * Sets binary data that is read out the swar file but is not needed immediately
     *
     * @param string                   $key
     * @param bool|int|DateTime|string $value
     */
    public function __set(string $key, $value): void
    {
        $this->BinaryData[ $key ] = $value;
    }

    /**
     * Adds the first tiebreak to the tournament
     */
    private function addTiebreaks(): void
    {
        switch ($this->Tournament->System) {
            case TournamentSystem::AMERICAN:
            case TournamentSystem::CLOSED:
            case TournamentSystem::SWISS:
            default:
                $firstElement = new Tiebreak(Tiebreak::POINTS);
        }
        $tiebreaks = $this->Tournament->Tiebreaks;
        array_unshift($tiebreaks, $firstElement);
        $this->Tournament->Tiebreaks = $tiebreaks;
    }

    /**
     * Converts a swar-4 string to a \DateTime object
     *
     * @param string $string
     *
     * @return DateTime
     */
    public function convertStringToDate(string $string): DateTime
    {
        if (strlen($string) == 10) {
            return DateTime::createFromFormat('d/m/Y', $string);
        } elseif (strlen($string) == 8) {
            return DateTime::createFromFormat('Ymd', $string);
        } else {
            $default = new DateTime();
            $default->setTimestamp(0);

            return $default;
        }
    }

    /**
     * Actually reads the Swar-File
     *
     * @param string $filename
     *
     * @throws IncompatibleReaderException
     */
    public function read(string $filename): void
    {
        $swshandle = fopen($filename, 'rb');

        $this->Release = $this->readData('String', $swshandle);
        if (array_search(substr($this->Release, 0, 3), self::COMPATIBLE_VERSIONS) === false) {
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

        $this->readData('String', $swshandle); // some unknown data
        $this->Tournament->NoOfRounds = $this->readData('Int', $swshandle);

        $this->Tournament->FRBEfrom = $this->readData('Int', $swshandle);
        $this->Tournament->FRBEto = $this->readData('Int', $swshandle);
        $this->Tournament->FIDEfrom = $this->readData('Int', $swshandle);
        $this->Tournament->FIDEto = $this->readData('Int', $swshandle);
        $this->Tournament->CatSepares = $this->readData('Int', $swshandle);
        $this->Tournament->AfficherEloOuPays = $this->readData('Int', $swshandle);

        $this->Tournament->FideHomol = $this->readData('Int', $swshandle);

        if (version_compare($this->Release, '5.24', ">=")) {
            $this->Tournament->FideId = $this->readData('Int', $swshandle);
        } else {
            for ($i = 0; $i <= 15; $i++) {
                // First round
                $this->readData('Int', $swshandle);
                //last round
                $this->readData('Int', $swshandle);
                //fide ID
                $this->readData('Int', $swshandle);
            }
        }
        $this->Tournament->FideArbitre1 = $this->readData('String', $swshandle);
        $this->Tournament->FideArbitre2 = $this->readData('String', $swshandle);
        $this->Tournament->FideEmail = $this->readData('String', $swshandle);
        $this->Tournament->FideRemarques = $this->readData('String', $swshandle);

        $applycustompoints = false;
        switch ($this->readData('Int', $swshandle)) {
            case 4:
            case 5:
            case 6:
                $system = TournamentSystem::CLOSED;
                break;
            case 7:
            case 8:
                $system = TournamentSystem::AMERICAN;
                break;
            case 3:
                $applycustompoints = true;
            case 0:
            case 1:
            case 2:
            default:
                $system = TournamentSystem::SWISS;
                break;
        }
        $this->Tournament->System = new TournamentSystem($system);

        $this->Tournament->Dummy1 = $this->readData('Int', $swshandle);
        $this->Tournament->Dummy2 = $this->readData('Int', $swshandle);
        $this->Tournament->SW_AmerPresence = $this->readData('Int', $swshandle);
        $this->Tournament->Plusieurs = $this->readData('Int', $swshandle);
        $this->Tournament->FirstTable = $this->readData('Int', $swshandle);
        $custompoints['win'] = $this->readData('Int', $swshandle) / 4;
        $custompoints['draw'] = $this->readData('Int', $swshandle) / 4;
        $custompoints['loss'] = $this->readData('Int', $swshandle) / 4;
        $custompoints['bye'] = $this->readData('Int', $swshandle) / 4;
        $custompoints['absent'] = $this->readData('Int', $swshandle) / 4;
        if($applycustompoints) $this->Tournament->CustomPoints = $custompoints;
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

        $this->Tournament->Tempo = self::TEMPOS[ $this->Tournament->TournoiStd ][ $this->Tournament->TempoIndex ];

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
                    $tiebreak = Tiebreak::NONE;
                    break;
                case 1:
                    $tiebreak = Tiebreak::BUCHHOLZ;
                    break;
                case 2:
                    $tiebreak = Tiebreak::BUCHHOLZ_MED;
                    break;
                case 3:
                    $tiebreak = Tiebreak::BUCHHOLZ_MED_2;
                    break;
                case 4:
                    $tiebreak = Tiebreak::BUCHHOLZ_CUT;
                    break;
                case 5:
                    $tiebreak = Tiebreak::BUCHHOLZ_CUT_2;
                    break;
                case 6:
                    $tiebreak = Tiebreak::SONNEBORN;
                    break;
                case 7:
                    $tiebreak = Tiebreak::CUMULATIVE;
                    break;
                case 8:
                    $tiebreak = Tiebreak::BETWEEN;
                    break;
                case 9:
                    $tiebreak = Tiebreak::KOYA;
                    break;
                case 10:
                    $tiebreak = Tiebreak::BAUMBACH;
                    break;
                case 11:
                    $tiebreak = Tiebreak::AVERAGE_PERFORMANCE;
                    break;
                case 12:
                    $tiebreak = Tiebreak::ARO;
                    break;
                case 13:
                    $tiebreak = Tiebreak::AROCUT;
                    break;
                case 14:
                    $tiebreak = Tiebreak::BLACK_PLAYED;
                    break;
                case 15:
                    $tiebreak = Tiebreak::BLACK_WIN;
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
            $category[ $i ][ 'Cat1' ] = $this->readData('String', $swshandle);
        }

        for ($i = 0; $i <= 12; $i++) {
            $category[ $i ][ 'Cat2' ] = $this->readData('String', $swshandle);
        }
        $this->Tournament->Category = $category;
        // [XTRA_POINTS]
        $this->readData('String', $swshandle);

        for ($i = 0; $i < 4; $i++) {
            $extrapoints[ $i ][ 'pts' ] = $this->readData('Int', $swshandle);
            $extrapoints[ $i ][ 'elo' ] = $this->readData('Int', $swshandle);
        }
        $this->Tournament->Extrapoints = $extrapoints;

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
            $inscriptionNos[ $this->readData('Int', $swshandle) ] = $i;
            $player->Rank = $this->readData('Int', $swshandle);
            $player->CatIndex = $this->readData('Int', $swshandle);
            $player->DateOfBirth = $this->readData('Date', $swshandle);
            switch ($this->readData('Int', $swshandle)) {
                case 1:
                    $gender = Gender::MALE;
                    break;
                case 2:
                    $gender = Gender::FEMALE;
                    break;
                default:
                    $gender = Gender::NEUTRAL;
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
            $player->Points = $this->readData('Int', $swshandle);         // To Calculate by libpairtwo
            $player->AmericanPoints = $this->readData('Int', $swshandle); // To Calculate by libpairtwo
            for ($t = 0; $t < 5; $t++) {
                $tiebreaks[ $t ] = $this->readData('Int', $swshandle); // To Calculate by libpairtwo
            }
            $player->Tiebreak = $tiebreaks;
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
                    $pairing[ $pt ][ 'player' ] = $i;
                    $pairing[ $pt ][ 'round' ] = $this->readData('Int', $swshandle) - 1;
                    $pairing[ $pt ][ 'table' ] = $this->readData('Int', $swshandle) - 1;
                    $pairing[ $pt ][ 'opponent' ] = $this->readData('Int', $swshandle);
                    $pairing[ $pt ][ 'result' ] = $this->readData('Hex', $swshandle);
                    $pairing[ $pt ][ 'color' ] = $this->readData('Int', $swshandle);
                    $pairing[ $pt ][ 'float' ] = $this->readData('Int', $swshandle);
                    $pairing[ $pt ][ 'extrapoints' ] = $this->readData('Int', $swshandle);

                    $pt++;
                }
                $this->Tournament->Pairing = $pairing;
            }

            $this->Tournament->addPlayer($player);
        }

        $ptn = 0;
        while (isset($this->Tournament->Pairing[ $ptn ][ 'round' ])) {
            $pairing = new Pairing();

            $pairing->Player = $this->Tournament->playerById($this->Tournament->Pairing[ $ptn ][ 'player' ]);
            $pairing->Round = $this->Tournament->Pairing[ $ptn ][ 'round' ];
            if ($this->Tournament->Pairing[ $ptn ][ 'opponent' ] != 4294967295) {
                $pairing->Opponent =
                    $this->Tournament->playerById($inscriptionNos[ $this->Tournament->Pairing[ $ptn ][ 'opponent' ] ]);
            }
            switch ($this->Tournament->Pairing[ $ptn ][ 'result' ]) {
                case '1000':
                    $result = Result::LOST;
                    break;
                case '01':
                    $result = Result::ABSENT;
                    break;
                case '0010':
                    $result = Result::BYE;
                    break;
                case '2000':
                    $result = Result::DRAW;
                    break;
                case '4000':
                    $result = Result::WON;
                    break;
                case '04':
                    $result = Result::WON_FORFAIT;
                    break;
                case '40':
                    $result = Result::WON_BYE;
                    break;
                case '00':
                default:
                    $result = Result::NONE;
                    break;
            }
            if (array_search($this->Tournament->Pairing[ $ptn ][ 'table' ], [16383, 8191]) !== false) {
                $result = Result::ABSENT;
            }
            $pairing->Result = new Result($result);

            switch ($this->Tournament->Pairing[ $ptn ][ 'color' ]) {
                case 4294967295:
                    $color = Color::BLACK;
                    break;
                case 1:
                    $color = Color::WHITE;
                    break;
                case 0:
                default:
                    $color = Color::NONE;
                    break;
            }
            $pairing->Color = new Color($color);

            $pairing->Board = $this->Tournament->Pairing[ $ptn ][ 'table' ];
            $ptn++;
            $this->Tournament->addPairing($pairing);
        }
        fclose($swshandle);
        $this->Tournament->pairingsToRounds();
        $this->addTiebreaks();
    }

    /**
     * Reads data of the filehandle and converts to $type. defaults to $default if given
     *
     * Possible types for $type are:
     * * String (UTF-8 String representation of $data.   Default: empty string '')
     * * Hex    (Capitalized Hex Value of $data.         Default: 00)
     * * Int    (Unsigned Integer value of $data         Default: 0)
     * * Bool   (Boolean representation of $data.        Default: false)
     * * Date   (Date representation of $data.           Default: 1902/01/01)
     *
     * @param string $type
     * @param        $handle
     * @param null   $default
     *
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
                        $hex[ $key ] = "";
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
                    return ($hex == "01");
                }
                break;
            default:
                throw new InvalidArgumentException("Datatype not known");
        }

        return false;
    }
}
