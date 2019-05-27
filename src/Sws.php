<?php

/*
 * The MIT License
 *
 * Copyright 2019 Jeroen De Meerleer <schaak@jeroened.be>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace JeroenED\Libpairtwo;



/**
 * This class reads a SWS file
 *
 * @deprecated
 * @author Jeroen De Meerleer
 */
class Sws
{

    /**
     * Reads out $swsfile and returns a Pairtwo6 class object
     *
     * @param string $swsfile
     * @deprecated
     */
    public static function ReadSws(string $swsfile)
    {
        trigger_error ( "This function is deprecated. Please convert your code to use the new pattern. More info to be found on Github (<Insert URL still to be created>).", E_USER_DEPRECATED);
        $reader = IOFactory::createReader("Pairtwo-6");
        return $reader->read($swsfile);
    }

}
