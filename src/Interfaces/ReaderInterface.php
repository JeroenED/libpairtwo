<?php


namespace JeroenED\Libpairtwo\Interfaces;

use JeroenED\Libpairtwo\Tournament;

interface ReaderInterface
{
    public function read($filename): ReaderInterface;
    public function getTournament(): Tournament;
}
