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

    /**
     * @deprecated
     */
    public function wye(Wye $wye = null)
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated', E_USER_DEPRECATED);

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
