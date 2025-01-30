<?php

namespace App\Controller;

use App\Entity;
use App\Trait;
use Flight;


abstract class compoundController  {

    use Trait\controller;
    use Trait\compoundResource;
    public string $ida_name;
    public string $idb_name;

    public function __construct() {
        $this->target = new $this->targetName();
        $this->request = Flight::request();


    }

}