<?php

/**
 * Interface ReaderInterface
 *
 * Sets the methods a reader needs to implement
 *
 * @author    Jeroen De Meerleer <schaak@jeroened.be>
 * @category  Main
 * @package   Libpairtwo
 * @copyright Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */

namespace JeroenED\Libpairtwo\Interfaces;

use JeroenED\Libpairtwo\Tournament;

/**
 * Interface ReaderInterface
 *
 * Sets the methods a reader needs to implement
 *
 * @author    Jeroen De Meerleer <schaak@jeroened.be>
 * @category  Main
 * @package   Libpairtwo
 * @copyright Copyright (c) 2018-2019 Jeroen De Meerleer <schaak@jeroened.be>
 */
interface ReaderInterface
{
    /**
     * Reads out $filename
     *
     * @param  $filename
     * @return void
     */
    public function read(string $filename): void;
}
