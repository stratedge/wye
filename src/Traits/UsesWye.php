<?php

namespace Stratedge\Wye\Traits;

use Stratedge\Wye\Wye;

trait UsesWye
{
    /**
     * @var Wye
     */
    protected $wye;


    //**************************************************************************
    // WYE
    //**************************************************************************

    public function wye(Wye $wye = null)
    {
        if (is_null($wye)) {
            return $this->getWye();
        } else {
            return $this->setWye($wye);
        }
    }

    public function getWye()
    {
        return $this->wye;
    }

    public function setWye(Wye $wye)
    {
        $this->wye = $wye;
    }
}
