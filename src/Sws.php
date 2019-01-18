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

use JeroenED\Libpairtwo\Models\Tournament;
use JeroenED\Libpairtwo\Models\Sws as MyModel;

/**
 * This class reads a SWS file
 *
 * @author Jeroen De Meerleer
 */
class Sws
{
    /**
     * @param string $swsfile
     * @return MyModel
     */
    public static function ReadSws(string $swsfile)
    {
        $swshandle = fopen($swsfile, 'rb');
        $swscontents = fread($swshandle, filesize($swsfile));
        fclose($swshandle);

        $sws = new MyModel();
        $offset = 0;
        

        $length = 4;
        $sws->setRelease(Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        $sws->setTournament(new Tournament());

        // UserCountry
        $length = 4;
        $sws->setBinaryData("UserCountry", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // SavedOffset
        $length = 4;
        $sws->setBinaryData("SavedOffset", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // NewPlayer
        $length = 4;
        $sws->setBinaryData("NewPlayer", hexdec(Self::ReadHexData(substr($swscontents, $offset, $length))));
        $offset += $length;

        // AmericanHandicap
        $length = 4;
        $sws->setBinaryData("AmericanHandicap", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // LowOrder
        $length = 4;
        $sws->setBinaryData("LowOrder", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // PairingMethod
        $length = 4;
        $sws->setBinaryData("PairingMethod", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // AmericanPresence
        $length = 4;
        $sws->setBinaryData("AmericanPresence", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // CheckSameClub
        $length = 4;
        $sws->setBinaryData("CheckSameClub", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // NoColorCheck
        $length = 4;
        $sws->setBinaryData("NoColorCheck", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // SeparateCategories
        $length = 4;
        $sws->setBinaryData("SeparateCategories", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // EloUsed
        $length = 4;
        $sws->setBinaryData("EloUsed", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // AlternateColors
        $length = 4;
        $sws->setBinaryData("AlternateColors", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // MaxMeetings
        $length = 4;
        $sws->setBinaryData("MaxMeetings", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // MaxDistance
        $length = 4;
        $sws->setBinaryData("MaxDistance", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // MinimizeKeizer
        $length = 4;
        $sws->setBinaryData("MinimizeKeizer", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // MinRoundsMeetings
        $length = 4;
        $sws->setBinaryData("MinRoundsMeetings", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // MaxRoundsAbsent
        $length = 4;
        $sws->setBinaryData("MaxRoundsAbsent", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // SpecialPoints
        $length = 4 * 6;
        $sws->setBinaryData("SpecialPoints", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // NewNamePos
        $length = 4;
        $sws->setBinaryData("NewNamePos", hexdec(Self::ReadHexData(substr($swscontents, $offset, $length))));
        $offset += $length;

        // CurrentRound
        $length = 4;
        $sws->setBinaryData("CurrentRound", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // CreatedRounds
        $length = 4;
        $sws->setBinaryData("CreatedRounds", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // CreatedPlayers
        $length = 4;
        $sws->setBinaryData("CreatedPlayers", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // MaxSelection
        $length = 4;
        $sws->setBinaryData("MaxSelection", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // NumberOfRounds
        $length = 4;
        $sws->setBinaryData("NumberOfRounds", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // NumberOfPairings
        $length = 4;
        $sws->setBinaryData("NumberOfPairings", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // CreatedPairings
        $length = 4;
        $sws->setBinaryData("CreatedPairings", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // PairingElems
        $length = 4;
        $sws->setBinaryData("PairingElems", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // RandomSeed
        $length = 4;
        $sws->setBinaryData("RandomSeed", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // TieOrder
        $length = 4 * 5;
        $sws->setBinaryData("TieOrder", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // Categorie
        $length = 4 * 10;
        $sws->setBinaryData("Categorie", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // ExtraPoints
        $length = 4 * 20;
        $sws->setBinaryData("ExtraPoints", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // SelectP
        $length = 4 * 20;
        $sws->setBinaryData("SelectP", Self::ReadHexData(substr($swscontents, $offset, $length)));
        $offset += $length;

        // Players
        $length = 68 * $sws->getBinaryData("NewPlayer");
        $sws->setBinaryData("Players", substr($swscontents, $offset, $length));
        $offset += $length;

        // PlayerNames
        $length = $sws->getBinaryData("NewNamePos");
        $sws->setBinaryData("PlayerNames", substr($swscontents, $offset, $length));
        $offset += $length;

        // TournamentName
        $length = 80;
        $sws->getTournament()->setName(substr($swscontents, $offset, $length));
        $offset += $length;

        // TournamentOrganiser
        $length = 50;
        $sws->getTournament()->setOrganiser(substr($swscontents, $offset, $length));
        $offset += $length;

        // TournamentTempo
        $length = 50;
        $sws->getTournament()->setTempo(substr($swscontents, $offset, $length));
        $offset += $length;

        // TournamentCountry
        $length = 32;
        $sws->getTournament()->setOrganiserCountry(substr($swscontents, $offset, $length));
        $offset += $length;

        // Arbiters
        $length = 128;
        $sws->getTournament()->setArbiter(substr($swscontents, $offset, $length));
        $offset += $length;

        return $sws;
    }

    private static function ReadHexData(String $data)
    {
        $hex = implode(unpack("H*", $data));
        $hex = str_replace("00", "", $hex);
        return $hex;
    }
}
