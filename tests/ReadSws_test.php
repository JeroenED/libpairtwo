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
Use JeroenED\Libpairtwo\Sws;

require_once '../vendor/autoload.php';

$sws = Sws::readSws('../res/testsws.sws');
echo "Name:         " . $sws->getTournament()->getName() . "\n";
echo "Organiser:    " . $sws->getTournament()->getOrganiser(). "\n";
echo "Tempo:        " . $sws->getTournament()->getTempo() . "\n";
echo "Country:      " . $sws->getTournament()->getOrganiserCountry() . "\n";
echo "Arbiter:      " . $sws->getTournament()->getArbiter() . "\n";
echo "Rounds:       " . $sws->getTournament()->getRounds() . "\n";
echo "Participants: " . $sws->getTournament()->getRounds() . "\n";
echo "Fidehomol:    " . $sws->getTournament()->getFideHomol() . "\n";
echo "Start-Date:   " . $sws->getTournament()->getStartDate()->format('d/m/Y') . "\n";
echo "Start-Date:   " . $sws->getTournament()->getEndDate()->format('d/m/Y') . "\n";
//echo "Start-Date hex:   " . $sws->getBinaryData("startdate") . "\n";
//echo $sws->getBinaryData("Tournament");
//echo $sws->getBinaryData("Players");
