<?php
namespace App\Controller;

use App\Entity;
use App\Trait;
use Flight;


abstract class basicController {

    use Trait\controller;
    use Trait\basicResource;

    public function __construct() {
        $this->request = Flight::request();
        $this->target = new $this->targetName();

    }

}