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

use JeroenED\Libpairtwo\Interfaces\ReaderInterface;
use JeroenED\Libpairtwo\Tournament;

class Swar4 implements ReaderInterface
{
    /** @var Tournament */
    private $tournament;

    public function read(string $filename): ReaderInterface
    {
        // TODO: Implement read() method.
    }

    public function getTournament(): Tournament
    {
        return $this->tournament;
    }
}
