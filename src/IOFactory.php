<?php
/**
 * Class IOFactory
 *
 * Class for creating readers for pairing files
 *
 * @author      Jeroen De Meerleer <schaak@jeroened.be>
 * @category    Main
 * @package     Libpairtwo
 * @copyright   Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */

namespace JeroenED\Libpairtwo;

use JeroenED\LibPairtwo\Exceptions\LibpairtwoException;
use JeroenED\Libpairtwo\Interfaces\ReaderInterface;
use JeroenED\Libpairtwo\Readers\Pairtwo6;

/**
 * Class IOFactory
 *
 * Class for creating readers for pairing files
 *
 * @author      Jeroen De Meerleer <schaak@jeroened.be>
 * @category    Main
 * @package     Libpairtwo
 * @copyright   Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */
abstract class IOFactory
{
    /**
     * Compatible readers
     *
     * @var array
     */
    private static $readers = [
        'Pairtwo-6' => Readers\Pairtwo6::class,
        'Pairtwo-5' => Readers\Pairtwo6::class // File structure identical
    ];


    /**
     * Creates a reader for $type
     *
     * Compatible types are Pairtwo-5 and Pairtwo-6
     *
     * @param string $type
     * @return ReaderInterface
     * @throws LibpairtwoException
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
