<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 11/02/19
 * Time: 14:51
 */

namespace JeroenED\LibPairtwo\Enums;

use MyCLabs\Enum\Enum;

class Color extends Enum
{
    const black = 255; // Implementing two's-complement for these values only is not worth the trick
    const black3 = 253; // Especially if you can just do unsigned
    const white = 1;
    const white3 = 3;
    const none = 0;
}