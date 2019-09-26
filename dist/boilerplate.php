<?php


use JeroenED\Libpairtwo\IOFactory;

require_once 'vendor/autoload.php';


// EDIT ME!
$pairingfile = 'your pairing-file.sws';
$fileformat = 'Pairtwo-6'; // Possible values: Pairtwo-5, Pairtwo-6, Swar-4


if (!file_exists($pairingfile)) {
    trigger_error('Your file is not set or doesn\'t exist! Edit the file: ' . __FILE__ . ' and try again', E_USER_ERROR);
}

$reader = IOFactory::createReader($fileformat);
$reader->read($pairingfile);

// From here on you can start. Please use the examples on https://github.com/jeroened/libpairtwo/wiki
// You can also use the doc/api folder to get all possible methods and fields

// Below is an example of what can be used. Feel free to modify this.
echo "<pre>";
echo "Name:         " . $reader->getTournament()->getName() . PHP_EOL;
echo "Organiser:    " . $reader->getTournament()->getOrganiser(). PHP_EOL;
echo "Tempo:        " . $reader->getTournament()->getTempo() . PHP_EOL;
echo "Country:      " . $reader->getTournament()->getOrganiserCountry() . PHP_EOL;
echo "Arbiter:      " . $reader->getTournament()->getArbiter() . PHP_EOL;
echo "Rounds:       " . $reader->getTournament()->getNoOfRounds() . PHP_EOL;
echo "Participants: " . $reader->getTournament()->getParticipants() . PHP_EOL;
echo "Fidehomol:    " . $reader->getTournament()->getFideHomol() . PHP_EOL;
echo "Start-Date:   " . $reader->getTournament()->getStartDate()->format('d/m/Y') . PHP_EOL;
echo "End-Date:     " . $reader->getTournament()->getEndDate()->format('d/m/Y') . PHP_EOL;
echo "System:       " . $reader->getTournament()->getSystem()->getKey() . PHP_EOL;
echo "Place:        " . $reader->getTournament()->getOrganiserPlace() . PHP_EOL;
echo "Unrated-Elo:  " . $reader->getTournament()->getNonRatedElo() . PHP_EOL;
echo "Federation:   " . $reader->getTournament()->getFederation() . PHP_EOL;
echo "Organiser:    " . $reader->getTournament()->getOrganiserClubNo() . PHP_EOL;
echo "Fide Elo P1:  " . $reader->getTournament()->getPlayerById(0)->getElo('Fide') . PHP_EOL;
echo "Fide Elo P2:  " . $reader->getTournament()->getPlayerById(1)->getElo('Fide') . PHP_EOL;
echo "Fide Elo P3:  " . $reader->getTournament()->getPlayerById(2)->getElo('Fide') . PHP_EOL;
echo "KBSB Elo P1:  " . $reader->getTournament()->getPlayerById(0)->getElo('Nation') . PHP_EOL;
echo "KBSB Elo P2:  " . $reader->getTournament()->getPlayerById(1)->getElo('Nation') . PHP_EOL;
echo "KBSB Elo P3:  " . $reader->getTournament()->getPlayerById(2)->getElo('Nation') . PHP_EOL;
echo "Name P1:      " . $reader->getTournament()->getPlayerById(0)->getName() . PHP_EOL;
echo "Name P2:      " . $reader->getTournament()->getPlayerById(1)->getName() . PHP_EOL;
echo "Name P3:      " . $reader->getTournament()->getPlayerById(2)->getName() . PHP_EOL;
echo "Gender P1:    " . $reader->getTournament()->getPlayerById(0)->getGender()->getKey() . PHP_EOL;
echo "Gender P2:    " . $reader->getTournament()->getPlayerById(1)->getGender()->getKey() . PHP_EOL;
echo "Gender P3:    " . $reader->getTournament()->getPlayerById(2)->getGender()->getKey() . PHP_EOL;
echo "Absent P1:    " . $reader->getTournament()->getPlayerById(0)->getBinaryData("Absent") . PHP_EOL;
echo "Absent P2:    " . $reader->getTournament()->getPlayerById(1)->getBinaryData("Absent") . PHP_EOL;
echo "Absent P3:    " . $reader->getTournament()->getPlayerById(2)->getBinaryData("Absent") . PHP_EOL;
echo "Date Round 1: " . $reader->getTournament()->getRoundByNo(0)->getDate()->format('d/m/Y') . PHP_EOL;
echo "Date Round 2: " . $reader->getTournament()->getRoundByNo(1)->getDate()->format('d/m/Y') . PHP_EOL;
echo "Date Round 3: " . $reader->getTournament()->getRoundByNo(2)->getDate()->format('d/m/Y') . PHP_EOL;
echo "Game Round 1: " . $sws->getTournament()->getRoundByNo(0)->getGames()[0]->getResult()->getValue() . PHP_EOL;
echo "Game Round 2: " . $sws->getTournament()->getRoundByNo(1)->getGames()[0]->getResult()->getValue() . PHP_EOL;
echo "Game Round 3: " . $sws->getTournament()->getRoundByNo(2)->getGames()[0]->getResult()->getValue() . PHP_EOL;
echo "Color Pairing 1: " . $reader->getTournament()->getPairings()[1]->getColor()->getKey() . PHP_EOL;
echo "Color Pairing 2: " . $reader->getTournament()->getPairings()[2]->getColor()->getKey() . PHP_EOL;
echo "Color Pairing 3: " . $reader->getTournament()->getPairings()[3]->getColor()->getKey() . PHP_EOL;
echo "Player Pairing 1: " . $reader->getTournament()->getPairings()[0]->getPlayer()->getName() . PHP_EOL;
echo "Player Pairing 2: " . $reader->getTournament()->getPairings()[1]->getPlayer()->getName()  . PHP_EOL;
echo "Player Pairing 3: " . $reader->getTournament()->getPairings()[2]->getPlayer()->getName()  . PHP_EOL;
echo "Bye Round 1:  " . $reader->getTournament()->getRoundByNo(2)->getBye()[0]->getPlayer()->getName()  . PHP_EOL;
echo "Absent Round 1: " . $reader->getTournament()->getRoundByNo(2)->getAbsent()[0]->getPlayer()->getName()  . PHP_EOL;
echo "Tiebreak 1:   " . $reader->getTournament()->getTiebreaks()[0]->getValue() . PHP_EOL;
echo "Tiebreak 2:   " . $reader->getTournament()->getTiebreaks()[1]->getValue() . PHP_EOL;
echo "Tiebreak 3:   " . $reader->getTournament()->getTiebreaks()[2]->getValue() . PHP_EOL;
echo "Tiebreak 4:   " . $reader->getTournament()->getTiebreaks()[3]->getValue() . PHP_EOL;
echo "Tiebreak 5:   " . $reader->getTournament()->getTiebreaks()[4]->getValue() . PHP_EOL;
echo "Tiebreak 6:   " . $reader->getTournament()->getTiebreaks()[5]->getValue() . PHP_EOL;
echo "Average Elo:  " . $reader->getTournament()->getAverageElo() . PHP_EOL;
foreach ($reader->getTournament()->getRanking() as $player) {
    echo str_pad($player->getName() . '(' . $player->getElo($reader->getTournament()->getPriorityElo()) . ') ', 35) . implode_pad(' ', $player->getTiebreaks(), 5, ' ') . PHP_EOL;
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
