<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 1/02/19
 * Time: 11:26
 */

namespace JeroenED\Libpairtwo;

use JeroenED\Libpairtwo\Models\Player as PlayerModel;

class Player extends PlayerModel
{
    
    /**
     * Adds a pairing to the tournament
     *
     * @param Pairing $pairing
     */
    public function addPairing(Pairing $pairing)
    {
        $newArray = $this->GetPairings();
        $newArray[] = $pairing;
        $this->setPairings($newArray);
    }
}
