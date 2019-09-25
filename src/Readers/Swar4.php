<?php
/**
 * Reader Pairtwo6
 *
 * Reads out Swar-4 files
 *
 * @author      Jeroen De Meerleer <schaak@jeroened.be>
 * @category    Main
 * @package     Libpairtwo
 * @copyright   Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */


namespace JeroenED\Libpairtwo\Readers;

use DateTime;
use JeroenED\Libpairtwo\Enums\TournamentSystem;
use JeroenED\Libpairtwo\Exceptions\IncompatibleReaderException;
use JeroenED\Libpairtwo\Interfaces\ReaderInterface;
use JeroenED\Libpairtwo\Pairing;
use JeroenED\Libpairtwo\Player;
use JeroenED\Libpairtwo\Tournament;
use JeroenED\Libpairtwo\Enums\Gender;
use JeroenED\Libpairtwo\Enums\Title;
use JeroenED\Libpairtwo\Enums\Result;

/**
 * Class Swar4
 * @package JeroenED\Libpairtwo\Readers
 */
class Swar4 implements ReaderInterface
{
    /** @var Tournament */
    private $tournament;

    /** @var bool|int|DateTime|string[] */
    private $binaryData;

    /** @var string */
    private $release;

    /** @var array  */
    private const CompatibleVersions = ['v4.'];


    /**
     * @param string $filename
     * @return ReaderInterface
     * @throws IncompatibleReaderException
     */
    public function read(string $filename): ReaderInterface
    {
        $swshandle = fopen($filename, 'rb');

        $this->setRelease($this->readData('String', $swshandle));
        if (array_search(substr($this->getRelease(), 0, 3), self::CompatibleVersions) === false) {
            throw new IncompatibleReaderException("This file was not created with Swar 4");
        }

        $this->setTournament(new Tournament());

        $this->setBinaryData('Guid', $this->readData('String', $swshandle));
        $this->setBinaryData('MacAddress', $this->readData('String', $swshandle));
        $this->setBinaryData('[Tournoi]', $this->readData('String', $swshandle));
        $this->getTournament()->setName($this->readData('String', $swshandle));
        $this->getTournament()->setOrganiser($this->readData('String', $swshandle));
        $this->getTournament()->setOrganiserClub($this->readData('String', $swshandle));
        $this->getTournament()->setOrganiserPlace($this->readData('String', $swshandle));

        // @todo: Make arbiter an array to set multiple arbiters
        $this->getTournament()->setArbiter($this->readData('String', $swshandle));
        $this->getTournament()->setBinaryData('Arbiter2', $this->readData('String', $swshandle));

        $this->getTournament()->setStartDate($this->readData('Date', $swshandle));
        $this->getTournament()->setEndDate($this->readData('Date', $swshandle));

        // Tempo string is not variable and dependant on kind of tournament
        $this->getTournament()->setBinaryData('TempoIndex', $this->readData('Int', $swshandle));

        $this->getTournament()->setNoOfRounds($this->readData('Int', $swshandle));

        $this->getTournament()->setBinaryData('FRBEfrom', $this->readData('Int', $swshandle));
        $this->getTournament()->setBinaryData('FRBEto', $this->readData('Int', $swshandle));
        $this->getTournament()->setBinaryData('FIDEfrom', $this->readData('Int', $swshandle));
        $this->getTournament()->setBinaryData('FIDEto', $this->readData('Int', $swshandle));
        $this->getTournament()->setBinaryData('CatSepares', $this->readData('Int', $swshandle));
        $this->getTournament()->setBinaryData('AfficherEloOuPays', $this->readData('Int', $swshandle));

        $this->getTournament()->setFideHomol($this->readData('Int', $swshandle));

        $this->getTournament()->setBinaryData('FideId', $this->readData('String', $swshandle));
        $this->getTournament()->setBinaryData('FideArbitre1', $this->readData('String', $swshandle));
        $this->getTournament()->setBinaryData('FideArbitre2', $this->readData('String', $swshandle));
        $this->getTournament()->setBinaryData('FideEmail', $this->readData('String', $swshandle));
        $this->getTournament()->setBinaryData('FideRemarques', $this->readData('String', $swshandle));

        $typeIndex = $this->readData('Int', $swshandle);

        $this->getTournament()->setBinaryData('Dummy1', $this->readData('Int', $swshandle));
        $this->getTournament()->setBinaryData('Dummy2', $this->readData('Int', $swshandle));
        $this->getTournament()->setBinaryData('SW_AmerPresence', $this->readData('Int', $swshandle));
        $this->getTournament()->setBinaryData('Plusieurs', $this->readData('Int', $swshandle));
        $this->getTournament()->setBinaryData('FirstTable', $this->readData('Int', $swshandle));
        $this->getTournament()->setBinaryData('SW321_Win', $this->readData('Int', $swshandle));
        $this->getTournament()->setBinaryData('SW321_Nul', $this->readData('Int', $swshandle));
        $this->getTournament()->setBinaryData('SW321_Los', $this->readData('Int', $swshandle));
        $this->getTournament()->setBinaryData('SW321_Bye', $this->readData('Int', $swshandle));
        $this->getTournament()->setBinaryData('SW321_Pre', $this->readData('Int', $swshandle));
        $this->getTournament()->setBinaryData('EloUsed', $this->readData('Int', $swshandle));
        $this->getTournament()->setBinaryData('TournoiStd', $this->readData('Int', $swshandle));
        $this->getTournament()->setBinaryData('TbPersonel', $this->readData('Int', $swshandle));
        $this->getTournament()->setBinaryData('ApparOrder', $this->readData('Int', $swshandle));
        $this->getTournament()->setBinaryData('EloEqual', $this->readData('Int', $swshandle));
        $this->getTournament()->setBinaryData('ByeValue', $this->readData('Int', $swshandle));
        $this->getTournament()->setBinaryData('AbsValue', $this->readData('Int', $swshandle));
        $this->getTournament()->setBinaryData('FF_Value', $this->readData('Int', $swshandle));
        $this->getTournament()->setBinaryData('Federation', $this->readData('Int', $swshandle));
        $this->getTournament()->setBinaryData('[DATES]', $this->readData('String', $swshandle));

        for ($i = 0; $i < $this->getTournament()->getNoOfRounds(); $i++) {
            $this->getTournament()->setBinaryData('Round_' . $i . '_date', $this->readData('Date', $swshandle));
        }

        $this->getTournament()->setBinaryData('[TIE_BREAK]', $this->readData('String', $swshandle));

        for ($i = 0; $i < 5; $i++) {
            $this->getTournament()->setBinaryData('Tiebreak_' . $i, $this->readData('Int', $swshandle));
        }

        $this->getTournament()->setBinaryData('[EXCLUSION]', $this->readData('String', $swshandle));
        $this->getTournament()->setBinaryData('ExclusionType', $this->readData('Int', $swshandle));
        $this->getTournament()->setBinaryData('ExclusionValue', $this->readData('String', $swshandle));

        $this->getTournament()->setBinaryData('[CATEGORIES]', $this->readData('String', $swshandle));

        $this->getTournament()->setBinaryData('Catogory_type', $this->readData('Int', $swshandle));
        for ($i = 0; $i <= 12; $i++) {
            $this->getTournament()->setBinaryData('Category_' . $i . '_Cat1', $this->readData('String', $swshandle));
        }

        for ($i = 0; $i <= 12; $i++) {
            $this->getTournament()->setBinaryData('Category_' . $i . '_Cat2', $this->readData('String', $swshandle));
        }

        $this->getTournament()->setBinaryData('[XTRA_POINTS]', $this->readData('String', $swshandle));

        for ($i = 0; $i < 4; $i++) {
            $this->getTournament()->setBinaryData('Extrapoints_' . $i . '_pts', $this->readData('Int', $swshandle));
            $this->getTournament()->setBinaryData('Extrapoints_' . $i . '_elo', $this->readData('Int', $swshandle));
        }

        $this->getTournament()->setBinaryData('[JOUEURS]', $this->readData('String', $swshandle));

        $roundNo = 0;
        $playerNo = 0;
        $this->getTournament()->setBinaryData('NumberOfPlayers', $this->readData('Int', $swshandle));

        $pt = 0;
        for ($i = 0; $i < $this->getTournament()->getBinaryData('NumberOfPlayers'); $i++) {
            $player = new Player();
            $player->setBinaryData('Classement', $this->readData('Int', $swshandle));
            $player->setName($this->readData('String', $swshandle));
            $player->setBinaryData('InscriptionNo', $this->readData('Int', $swshandle));
            $player->setBinaryData('Rank', $this->readData('Int', $swshandle));
            $player->setBinaryData('CatIndex', $this->readData('Int', $swshandle));
            $player->setDateOfBirth($this->readData('Date', $swshandle));
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
            $player->setGender(new Gender($gender));

            $player->setNation($this->readData('String', $swshandle));
            $player->setId('Nation', $this->readData('Int', $swshandle));
            $player->setId('Fide', $this->readData('Int', $swshandle));
            $player->setBinaryData('Affliation', $this->readData('Int', $swshandle));
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
            $player->setTitle(new Title($title));

            $player->setId('Club', $this->readData('Int', $swshandle));
            $player->setBinaryData('ClubName', $this->readData('String', $swshandle));
            $player->setBinaryData('NoOfMatchesNoBye', $this->readData('Int', $swshandle));
            $player->setBinaryData('Points', $this->readData('Int', $swshandle)); // To Calculate by libpairtwo
            $player->setBinaryData('AmericanPoints', $this->readData('Int', $swshandle)); // To Calculate by libpairtwo
            for ($t = 0; $t < 5; $t++) {
                $player->setBinaryData('Tiebreak_' . $t, $this->readData('Int', $swshandle)); // To Calculate by libpairtwo
            }
            $player->setBinaryData('Performance', $this->readData('Int', $swshandle)); // To Calculate by libpairtwo
            $player->setBinaryData('Absent', $this->readData('Int', $swshandle));
            $player->setBinaryData('AbsentRounds', $this->readData('String', $swshandle));
            $player->setBinaryData('ExtraPoints', $this->readData('Int', $swshandle));
            $player->setBinaryData('SpecialPoints', $this->readData('Int', $swshandle));
            $player->setBinaryData('AllocatedRounds', $this->readData('Int', $swshandle));
            $player->setBinaryData('[RONDE]', $this->readData('String', $swshandle));

            if ($player->getBinaryData('AllocatedRounds') != 0) {
                for ($j = 0; $j < $player->getBinaryData('AllocatedRounds'); $j++) {
                    $this->getTournament()->setBinaryData('Pairing_' . $pt . '_player', $i);
                    $this->getTournament()->setBinaryData('Pairing_' . $pt . '_round', $this->readData('Int', $swshandle));
                    $this->getTournament()->setBinaryData('Pairing_' . $pt . '_table', $this->readData('Int', $swshandle));
                    $this->getTournament()->setBinaryData('Pairing_' . $pt . '_opponent', $this->readData('Int', $swshandle) - 1);
                    $this->getTournament()->setBinaryData('Pairing_' . $pt . '_result', $this->readData('Hex', $swshandle));
                    $this->getTournament()->setBinaryData('Pairing_' . $pt . '_color', $this->readData('Int', $swshandle));
                    $this->getTournament()->setBinaryData('Pairing_' . $pt . '_float', $this->readData('Int', $swshandle));
                    $this->getTournament()->setBinaryData('Pairing_' . $pt . '_extrapoints', $this->readData('Int', $swshandle));

                    $pt++;
                }
            }

            $this->getTournament()->addPlayer($player);
        }

        $ptn = 0;
        while (null !== $this->getTournament()->getBinaryData('Pairing_' . $ptn . '_round')) {
            $pairing = new Pairing();

            $pairing->setPlayer($this->getTournament()->getPlayerById($this->getTournament()->getBinaryData('Pairing_' . $ptn . '_player')));
            $pairing->setRound($this->getTournament()->getBinaryData('Pairing_' . $ptn . '_round'));
            if($this->getTournament()->getBinaryData('Pairing_' . $ptn . '_opponent') != 4294967294) {
                $pairing->setOpponent($this->getTournament()->getPlayerById($this->getTournament()->getBinaryData('Pairing_' . $ptn . '_opponent')));
            }
            //echo $ptn . ' ' . $this->getTournament()->getBinaryData('Pairing_' . $ptn . '_round') . ' ' . $pairing->getPlayer()->getName() . ' -  ' . $opponent . ' ' . $this->getTournament()->getBinaryData('Pairing_' . $ptn . '_result') . PHP_EOL;
            switch ($this->getTournament()->getBinaryData('Pairing_' . $ptn . '_result')) {
                case '1000':
                    $result = Result::lost;
                    break;
                case '01':
                    $result = Result::absent;
                    break;
                case '0010':
                    $result = Result::bye;
                    break;
                case '2000':
                    $result = Result::draw;
                    break;
                case '4000':
                    $result = Result::won;
                    break;
                case '04':
                    $result = Result::wonforfait;
                    break;
                case '40':
                    $result = Result::wonbye;
                    break;
                case '00':
                default:
                    $result = Result::none;
                    break;
            }
            $pairing->setResult(new Result($result));
            $ptn++;
        }
        fclose($swshandle);
        $this->getTournament()->pairingsToRounds();
        return $this;
    }

    /**
     * @return Tournament
     */
    public function getTournament(): Tournament
    {
        return $this->tournament;
    }

    /**
     * @param Tournament $tournament
     */
    public function setTournament(Tournament $tournament): void
    {
        $this->tournament = $tournament;
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
     * @return string
     */
    public function getRelease(): string
    {
        return $this->release;
    }

    /**
     * @param string $release
     */
    public function setRelease(string $release): void
    {
        $this->release = $release;
    }

    /**
     * Returns binary data that was read out the swar file but was not needed immediately
     *
     * @param string $Key
     * @return bool|DateTime|int|string|null
     */
    public function getBinaryData(string $Key)
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
     * @return Pairtwo6
     */
    public function setBinaryData(string $Key, $Value): Swar4
    {
        $this->BinaryData[$Key] = $Value;
        return $this;
    }

    /**
     * @param string $string
     * @return DateTime
     */
    public function convertStringToDate(string $string): \DateTime
    {
        if (strlen($string) == 10) {
            return DateTime::createFromFormat('d/m/Y', $string);
        } elseif (strlen($string) == 8) {
            return DateTime::createFromFormat('Ymd', $string);
        }
    }
}
