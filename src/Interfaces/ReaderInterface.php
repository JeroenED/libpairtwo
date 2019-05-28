<?php


namespace JeroenED\Libpairtwo\Interfaces;

use JeroenED\Libpairtwo\Tournament;

interface ReaderInterface
{
    public function read($filename);
    public function getTournament(): Tournament;
}
