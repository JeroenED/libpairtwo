<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>My tournament</title>
    <meta name="description" content="Libpairtwo">
    <meta name="author" content="The chessclub">

    <link rel="stylesheet" href="css/styles.css">

</head>

<body>
<?php

use JeroenED\Libpairtwo\IOFactory;

require_once 'vendor/autoload.php';

// EDIT ME!
$pairingfile = 'your pairing-file.swar';
$fileformat = 'Swar-4'; // Possible values: Pairtwo-5, Pairtwo-6, Swar-4

if (!file_exists($pairingfile)) {
    trigger_error('Your file is not set or doesn\'t exist! Edit the file: ' . __FILE__ . ' and try again', E_USER_ERROR);
}

$reader = IOFactory::createReader($fileformat);
$reader->read($pairingfile);

// From here on you can start. Please use the examples on https://github.com/jeroened/libpairtwo/wiki
// You can also use the doc/api folder to get all possible methods and fields

// Below is an example of what can be used. Feel free to modify this.
echo '<h1>' . $reader->getTournament()->getName() . '</h1>' . PHP_EOL;
foreach($reader->getTournament()->getRounds() as $round) {
    echo '<h2>Ronde ' . ($round->getRoundNo() + 1) . ': ' . $round->getDate()->format('d/m/Y') . '</h2>' . PHP_EOL;

    echo '<table>' . PHP_EOL;
    echo '<thead>' . PHP_EOL;
    echo '<tr><th>Wit</th><th>Zwart</th><th>Resultaat</th></tr>' . PHP_EOL;
    echo '</thead>' . PHP_EOL;
    echo '<tbody>' . PHP_EOL;
    foreach($round->getGames() as $game) {
        echo '<tr>' . PHP_EOL;
        echo '<td>' . $game->getWhite()->getPlayer()->getName() . '</td>' . PHP_EOL;
        echo '<td>' . $game->getBlack()->getPlayer()->getName() . '</td>' . PHP_EOL;
        echo '<td>' . $game->getResult()->getValue() . '</td>' . PHP_EOL;
        echo '</tr>' . PHP_EOL;
    }
    echo '</tbody>' . PHP_EOL;
    echo '</table>' . PHP_EOL;
    echo '<p><strong>Bye:</strong> ';
    $bye = [];
    foreach ($round->getBye() as $pairing) {
        $bye[] = $pairing->getPlayer()->getName();
    }
    echo implode(', ', $bye);
    echo '</p>' . PHP_EOL;
    echo '<p><strong>Afwezig:</strong> ';
    $bye = [];
    foreach ($round->getAbsent() as $pairing) {
        $bye[] = $pairing->getPlayer()->getName();
    }
    echo implode('; ', $bye);
    echo '</p>' . PHP_EOL;
}

echo '<h2>Klassement</h2>' . PHP_EOL;
echo '<table>' . PHP_EOL;
echo '<thead>' . PHP_EOL;
echo '<tr><th> </th><th>Naam (elo)</th>' . PHP_EOL;
foreach ($reader->getTournament()->getTieBreaks() as $tiebreak) {
    echo '<th>' . $tiebreak->getValue() . '</th>' . PHP_EOL;
}
echo '</tr>' . PHP_EOL;
echo '</thead>' . PHP_EOL;
echo '<tbody>' . PHP_EOL;

$rank = 1;
foreach ($reader->getTournament()->getRanking() as $player) {
    echo '<tr>' . PHP_EOL;
    echo '<td>' . $rank . '</td>' . PHP_EOL;
    echo '<td>' . $player->getName() . '(' . $player->getElo($reader->getTournament()->getPriorityElo()) . ')</td>' . PHP_EOL;
    echo '<td>' . implode('</td><td>', $player->getTiebreaks()) . '</td>' . PHP_EOL;
    echo '</tr>' . PHP_EOL;
    $rank++;
}
echo '</tbody>' . PHP_EOL;
echo '</table>' . PHP_EOL;
?>
    <script src="js/scripts.js"></script>
</body>
</html>
