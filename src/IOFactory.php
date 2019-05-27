<?php


namespace JeroenED\Libpairtwo;

use JeroenED\LibPairtwo\Exceptions\LibpairtwoException;
use JeroenED\Libpairtwo\Interfaces\ReaderInterface;

abstract class IOFactory
{
    private static $readers = [
        'Pairtwo-6' => Readers\Pairtwo6::class
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
