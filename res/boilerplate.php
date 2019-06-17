<?php


use JeroenED\Libpairtwo\IOFactory;

require_once 'vendor/autoload.php';

$reader = IOFactory::createReader('Pairtwo-6');
$reader->read('your pairing-file.sws');

// From here on you can start. Please use the examples on https://github.com/jeroened/libpairtwo/wiki
// You can also use the doc/api folder to get all possible methods and fields
