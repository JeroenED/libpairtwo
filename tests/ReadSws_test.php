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

echo "Release:      " . $sws->Release . PHP_EOL;
echo "Name:         " . $sws->Tournament->Name . PHP_EOL;
echo "Organiser:    " . $sws->Tournament->Organiser . PHP_EOL;
echo "TempoIndex:   " . $sws->Tournament->TempoIndex . PHP_EOL;
echo "TempoType:    " . $sws->Tournament->TournoiStd . PHP_EOL;
echo "Tempo:        " . $sws->Tournament->Tempo . PHP_EOL;
echo "Place:        " . $sws->Tournament->OrganiserPlace . PHP_EOL;
echo "Arbiter 1:    " . $sws->Tournament->Arbiters[ 0 ] . PHP_EOL;
echo "Arbiter 2:    " . $sws->Tournament->Arbiters[ 1 ] . PHP_EOL;
echo "Rounds:       " . $sws->Tournament->NoOfRounds . PHP_EOL;
echo "Fidehomol:    " . $sws->Tournament->FideHomol . PHP_EOL;
echo "Start-Date:   " . $sws->Tournament->StartDate->format('d/m/Y') . PHP_EOL;
echo "End-Date:     " . $sws->Tournament->EndDate->format('d/m/Y') . PHP_EOL;
echo "System:       " . $sws->Tournament->System->getKey() . PHP_EOL;
echo "Place:        " . $sws->Tournament->OrganiserPlace . PHP_EOL;
echo "Unrated-Elo:  " . $sws->Tournament->NonRatedElo . PHP_EOL;
echo "Federation:   " . $sws->Tournament->Federation . PHP_EOL;
echo "Organiser:    " . $sws->Tournament->OrganiserClubNo . PHP_EOL;
echo "Fide Elo P1:  " . $sws->Tournament->PlayerById(0)->getElo('Fide') . PHP_EOL;
echo "Fide Elo P2:  " . $sws->Tournament->PlayerById(1)->getElo('Fide') . PHP_EOL;
echo "Fide Elo P3:  " . $sws->Tournament->PlayerById(2)->getElo('Fide') . PHP_EOL;
echo "KBSB Elo P1:  " . $sws->Tournament->PlayerById(0)->getElo('Nation') . PHP_EOL;
echo "KBSB Elo P2:  " . $sws->Tournament->PlayerById(1)->getElo('Nation') . PHP_EOL;
echo "KBSB Elo P3:  " . $sws->Tournament->PlayerById(2)->getElo('Nation') . PHP_EOL;
echo "Name P1:      " . $sws->Tournament->PlayerById(0)->Name . PHP_EOL;
echo "Name P2:      " . $sws->Tournament->PlayerById(1)->Name . PHP_EOL;
echo "Name P3:      " . $sws->Tournament->PlayerById(2)->Name . PHP_EOL;
echo "Gender P1:    " . $sws->Tournament->PlayerById(0)->Gender->getKey() . PHP_EOL;
echo "Gender P2:    " . $sws->Tournament->PlayerById(1)->Gender->getKey() . PHP_EOL;
echo "Gender P3:    " . $sws->Tournament->PlayerById(2)->Gender->getKey() . PHP_EOL;
echo "Absent P1:    " . $sws->Tournament->PlayerById(0)->Absent . PHP_EOL;
echo "Absent P2:    " . $sws->Tournament->PlayerById(1)->Absent . PHP_EOL;
echo "Absent P3:    " . $sws->Tournament->PlayerById(2)->Absent . PHP_EOL;
echo "Category P1:    " . $sws->Tournament->PlayerById(0)->Category . PHP_EOL;
echo "Category P2:    " . $sws->Tournament->PlayerById(1)->Category . PHP_EOL;
echo "Category P3:    " . $sws->Tournament->PlayerById(2)->Category . PHP_EOL;
echo "Date Round 1: " . $sws->Tournament->RoundByNo(0)->Date->format('d/m/Y') . PHP_EOL;
echo "Date Round 2: " . $sws->Tournament->RoundByNo(1)->Date->format('d/m/Y') . PHP_EOL;
echo "Date Round 3: " . $sws->Tournament->RoundByNo(2)->Date->format('d/m/Y') . PHP_EOL;
echo "Game Round 1: " . $sws->Tournament->RoundByNo(0)->Games[ 0 ]->Result->getValue() . PHP_EOL;
echo "Game Round 2: " . $sws->Tournament->RoundByNo(1)->Games[ 0 ]->Result->getValue() . PHP_EOL;
echo "Game Round 3: " . $sws->Tournament->RoundByNo(2)->Games[ 0 ]->Result->getValue() . PHP_EOL;
echo "Color Pairing 1: " . $sws->Tournament->Pairings[ 1 ]->Color->getKey() . PHP_EOL;
echo "Color Pairing 2: " . $sws->Tournament->Pairings[ 2 ]->Color->getKey() . PHP_EOL;
echo "Color Pairing 3: " . $sws->Tournament->Pairings[ 3 ]->Color->getKey() . PHP_EOL;
echo "Player Pairing 1: " . $sws->Tournament->Pairings[ 0 ]->Player->Name . PHP_EOL;
echo "Player Pairing 2: " . $sws->Tournament->Pairings[ 1 ]->Player->Name . PHP_EOL;
echo "Player Pairing 3: " . $sws->Tournament->Pairings[ 2 ]->Player->Name . PHP_EOL;
echo "Bye Round 1:  " . $sws->Tournament->RoundByNo(2)->Bye[ 0 ]->Player->Name . PHP_EOL;
echo "Absent Round 1: " . $sws->Tournament->RoundByNo(2)->Absent[ 0 ]->Player->Name . PHP_EOL;
echo "Tiebreak 1:   " . $sws->Tournament->Tiebreaks[ 0 ]->getValue() . PHP_EOL;
echo "Tiebreak 2:   " . $sws->Tournament->Tiebreaks[ 1 ]->getValue() . PHP_EOL;
echo "Tiebreak 3:   " . $sws->Tournament->Tiebreaks[ 2 ]->getValue() . PHP_EOL;
echo "Tiebreak 4:   " . $sws->Tournament->Tiebreaks[ 3 ]->getValue() . PHP_EOL;
echo "Tiebreak 5:   " . $sws->Tournament->Tiebreaks[ 4 ]->getValue() . PHP_EOL;
echo "Tiebreak 6:   " . $sws->Tournament->Tiebreaks[ 5 ]->getValue() . PHP_EOL;
echo "Average Elo:  " . $sws->Tournament->AverageElo . PHP_EOL;
foreach ($sws->Tournament->RankingForCategory('+2500') as $player) {
    echo str_pad($player->Name . '(' . $player->getElo($sws->Tournament->PriorityElo) . ') ', 35) .
         implode_pad(' ', $player->Tiebreaks, 5, ' ') .
         PHP_EOL;
}

function implode_pad($glue, $collection, $padlength, $padstring): string
{
    $newarray = [];
    foreach ($collection as $elem) {
        $newarray[] = str_pad($elem, $padlength, $padstring);
    }

    return implode($glue, $newarray);
}
