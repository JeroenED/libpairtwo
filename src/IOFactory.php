<?php


namespace JeroenED\Libpairtwo;

use JeroenED\LibPairtwo\Exceptions\LibpairtwoException;
use JeroenED\Libpairtwo\Interfaces\ReaderInterface;
use JeroenED\Libpairtwo\Readers\Pairtwo6;

abstract class IOFactory
{
    private static $readers = [
        'Pairtwo-6' => Readers\Pairtwo6::class,
        'Pairtwo-5' => Readers\Pairtwo6::class // File structure identical
    ];


    /**
     * Creates a reader for $type
     *
     * @param string $type
     * @return ReaderInterface
     */
    public static function createReader(string $type): ReaderInterface
    {
        if (!isset(self::$readers[$type])) {
            throw new LibpairtwoException("Cannot read type $type");
        }

        // create reader class
        $readerClass = self::$readers[$type];
        $reader = new $readerClass;

        return $reader;
    }
}
