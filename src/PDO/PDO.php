<?php

namespace Stratedge\Wye\PDO;

use PDO as BasePDO;
use Stratedge\Wye\Traits\UsesWye;
use Stratedge\Wye\Wye;

class PDO extends BasePDO
{
    use UsesWye;


    public function __construct(Wye $wye)
    {
        $this->setWye($wye);
    }


    //**************************************************************************
    // PDO METHODS
    //**************************************************************************

    public function prepare($statement, $options = null)
    {
        return $this->wye()->makeStatement($statement, $options);
    }
}
