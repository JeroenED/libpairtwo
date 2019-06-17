<?php


use JeroenED\Libpairtwo\IOFactory;

require_once 'vendor/autoload.php';


// EDIT ME!
$pairingfile = 'your pairing-file.sws';


if(!file_exists($pairingfile)) {
	trigger_error('Your file is not set or doesn\'t exist! Edit the file: ' . __FILE__ . ' and try again', E_USER_ERROR);
}

$reader = IOFactory::createReader('Pairtwo-6');
$reader->read($pairingfile);

// From here on you can start. Please use the examples on https://github.com/jeroened/libpairtwo/wiki
// You can also use the doc/api folder to get all possible methods and fields

// Below is an example of what can be used. Feel free to modify this.
echo "<pre>";
echo "Name:         " . $sws->getTournament()->getName() . PHP_EOL;
echo "Organiser:    " . $sws->getTournament()->getOrganiser(). PHP_EOL;
echo "Tempo:        " . $sws->getTournament()->getTempo() . PHP_EOL;
echo "Country:      " . $sws->getTournament()->getOrganiserCountry() . PHP_EOL;
echo "Arbiter:      " . $sws->getTournament()->getArbiter() . PHP_EOL;
echo "Rounds:       " . $sws->getTournament()->getNoOfRounds() . PHP_EOL;
echo "Participants: " . $sws->getTournament()->getNoOfRounds() . PHP_EOL;
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


echo "</pre>";
function implode_pad($glue, $collection, $padlength, $padstring): string
{
    $newarray = [];
    foreach ($collection as $elem) {
        $newarray[] = str_pad($elem, $padlength, $padstring);
    }
    return implode($glue, $newarray);
}
