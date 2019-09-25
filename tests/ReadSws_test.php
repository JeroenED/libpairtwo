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
use JeroenED\Libpairtwo\IOFactory;

require_once '../vendor/autoload.php';

$sws = IOFactory::createReader('Swar-4');
$sws->read('../res/testswar.swar');

echo "Release:      " . $sws->getRelease() . PHP_EOL;
echo "Name:         " . $sws->getTournament()->getName() . PHP_EOL;
echo "Organiser:    " . $sws->getTournament()->getOrganiser(). PHP_EOL;
echo "TempoIndex:   " . $sws->getTournament()->getBinaryData('TempoIndex') . PHP_EOL;
echo "TempoType:    " . $sws->getTournament()->getBinaryData('TournoiStd') . PHP_EOL;
echo "Tempo:        " . $sws->getTournament()->getTempo() . PHP_EOL;
echo "Place:        " . $sws->getTournament()->getOrganiserPlace() . PHP_EOL;
echo "Arbiter:      " . $sws->getTournament()->getArbiter() . PHP_EOL;
echo "Rounds:       " . $sws->getTournament()->getNoOfRounds() . PHP_EOL;
echo "Fidehomol:    " . $sws->getTournament()->getFideHomol() . PHP_EOL;
echo "Start-Date:   " . $sws->getTournament()->getStartDate()->format('d/m/Y') . PHP_EOL;
echo "End-Date:     " . $sws->getTournament()->getEndDate()->format('d/m/Y') . PHP_EOL;
echo "System:       " . $sws->getTournament()->getSystem()->getKey() . PHP_EOL;
echo "Place:        " . $sws->getTournament()->getOrganiserPlace() . PHP_EOL;
echo "Unrated-Elo:  " . $sws->getTournament()->getNonRatedElo() . PHP_EOL;
echo "Federation:   " . $sws->getTournament()->getFederation() . PHP_EOL;
echo "Organiser:    " . $sws->getTournament()->getOrganiserClubNo() . PHP_EOL;
echo "Fide Elo P1:  " . $sws->getTournament()->getPlayerById(0)->getElo('Fide') . PHP_EOL;
echo "Fide Elo P2:  " . $sws->getTournament()->getPlayerById(1)->getElo('Fide') . PHP_EOL;
echo "Fide Elo P3:  " . $sws->getTournament()->getPlayerById(2)->getElo('Fide') . PHP_EOL;
echo "KBSB Elo P1:  " . $sws->getTournament()->getPlayerById(0)->getElo('Nation') . PHP_EOL;
echo "KBSB Elo P2:  " . $sws->getTournament()->getPlayerById(1)->getElo('Nation') . PHP_EOL;
echo "KBSB Elo P3:  " . $sws->getTournament()->getPlayerById(2)->getElo('Nation') . PHP_EOL;
echo "Name P1:      " . $sws->getTournament()->getPlayerById(0)->getName() . PHP_EOL;
echo "Name P2:      " . $sws->getTournament()->getPlayerById(1)->getName() . PHP_EOL;
echo "Name P3:      " . $sws->getTournament()->getPlayerById(2)->getName() . PHP_EOL;
echo "Gender P1:    " . $sws->getTournament()->getPlayerById(0)->getGender()->getKey() . PHP_EOL;
echo "Gender P2:    " . $sws->getTournament()->getPlayerById(1)->getGender()->getKey() . PHP_EOL;
echo "Gender P3:    " . $sws->getTournament()->getPlayerById(2)->getGender()->getKey() . PHP_EOL;
echo "Absent P1:    " . $sws->getTournament()->getPlayerById(0)->getBinaryData("Absent") . PHP_EOL;
echo "Absent P2:    " . $sws->getTournament()->getPlayerById(1)->getBinaryData("Absent") . PHP_EOL;
echo "Absent P3:    " . $sws->getTournament()->getPlayerById(2)->getBinaryData("Absent") . PHP_EOL;
echo "Date Round 1: " . $sws->getTournament()->getRoundByNo(0)->getDate()->format('d/m/Y') . PHP_EOL;
echo "Date Round 2: " . $sws->getTournament()->getRoundByNo(1)->getDate()->format('d/m/Y') . PHP_EOL;
echo "Date Round 3: " . $sws->getTournament()->getRoundByNo(2)->getDate()->format('d/m/Y') . PHP_EOL;
echo "Game Round 1: " . $sws->getTournament()->getRoundByNo(0)->getGames()[0]->getResult()->getValue() . PHP_EOL;
echo "Game Round 2: " . $sws->getTournament()->getRoundByNo(1)->getGames()[0]->getResult()->getValue() . PHP_EOL;
echo "Game Round 3: " . $sws->getTournament()->getRoundByNo(2)->getGames()[0]->getResult()->getValue() . PHP_EOL;
echo "Color Pairing 1: " . $sws->getTournament()->getPairings()[1]->getColor()->getKey() . PHP_EOL;
echo "Color Pairing 2: " . $sws->getTournament()->getPairings()[2]->getColor()->getKey() . PHP_EOL;
echo "Color Pairing 3: " . $sws->getTournament()->getPairings()[3]->getColor()->getKey() . PHP_EOL;
echo "Player Pairing 1: " . $sws->getTournament()->getPairings()[0]->getPlayer()->getName() . PHP_EOL;
echo "Player Pairing 2: " . $sws->getTournament()->getPairings()[1]->getPlayer()->getName()  . PHP_EOL;
echo "Player Pairing 3: " . $sws->getTournament()->getPairings()[2]->getPlayer()->getName()  . PHP_EOL;
echo "Bye Round 1:  " . $sws->getTournament()->getRoundByNo(2)->getBye()[0]->getPlayer()->getName()  . PHP_EOL;
echo "Absent Round 1: " . $sws->getTournament()->getRoundByNo(2)->getAbsent()[0]->getPlayer()->getName()  . PHP_EOL;
echo "Tiebreak 1:   " . $sws->getTournament()->getTiebreaks()[0]->getValue() . PHP_EOL;
echo "Tiebreak 2:   " . $sws->getTournament()->getTiebreaks()[1]->getValue() . PHP_EOL;
echo "Tiebreak 3:   " . $sws->getTournament()->getTiebreaks()[2]->getValue() . PHP_EOL;
echo "Tiebreak 4:   " . $sws->getTournament()->getTiebreaks()[3]->getValue() . PHP_EOL;
echo "Tiebreak 5:   " . $sws->getTournament()->getTiebreaks()[4]->getValue() . PHP_EOL;
echo "Tiebreak 6:   " . $sws->getTournament()->getTiebreaks()[5]->getValue() . PHP_EOL;
echo "Average Elo:  " . $sws->getTournament()->getAverageElo() . PHP_EOL;
foreach ($sws->getTournament()->getRanking() as $player) {
    echo str_pad($player->getName() . '(' . $player->getElo($sws->getTournament()->getPriorityElo()) . ') ', 35) . implode_pad(' ', $player->getTiebreaks(), 5, ' ') . PHP_EOL;
}

function implode_pad($glue, $collection, $padlength, $padstring): string
{
    $newarray = [];
    foreach ($collection as $elem) {
        $newarray[] = str_pad($elem, $padlength, $padstring);
    }
    return implode($glue, $newarray);
}
