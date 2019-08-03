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
use JeroenED\Libpairtwo\Interfaces\ReaderInterface;
use JeroenED\Libpairtwo\Tournament;

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

    /**
     * @param string $filename
     * @return ReaderInterface
     */
    public function read(string $filename): ReaderInterface
    {
        $swshandle = fopen($filename, 'rb');

        $this->setRelease($this->readData('String', $swshandle));

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
        fclose($swshandle);

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
     * @return bool|DateTime|int|string
     */
    public function getBinaryData(string $Key)
    {
        return $this->BinaryData[$Key];
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
        return DateTime::createFromFormat('d/m/Y', $string);
    }
}
