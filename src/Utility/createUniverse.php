<?php
namespace App\Utility;

use Flight;

class createUniverse {

    public object $log;
    public int $numSectors;

    public int $linksPerSector;

    public int $numPorts;

    public int $numPlanets;
    public function sysname(bool $longer=false): string
    {
        $pairs = "..lexegezacebisousesarmaindirea.eratenberalavetiedorquanteisrion";
        $name ='';
        $length = 4;
        if ($longer) {
            $length += 2;
        }
        for ($i = 0; $i < $length; $i++) {
            $name .= substr($pairs,rand(0,strlen($pairs)-1),2);
            $name = str_replace(".","",$name);
        }
        return ucfirst($name);
    }

    public function __construct($seed = 0, $numSectors = 1000, $linksPerSector = 3, $numPorts = 100, $numPlanets = 100) {
        srand($seed);
        $this->numSectors = $numSectors;
        $this->linksPerSector = $linksPerSector;
        $this->numPorts = $numPorts;
        $this->numPlanets = $numPlanets;
        $this->log = Flight::get("log");
        $this->log->info('start universe creation');
    }
    public function genesis()
    {


        Flight::db()->runQuery('SET FOREIGN_KEY_CHECKS=0');
        Flight::db()->runQuery('TRUNCATE link');
        Flight::db()->runQuery('TRUNCATE planet');
        Flight::db()->runQuery('TRUNCATE port');
        Flight::db()->runQuery('TRUNCATE sector');
        Flight::db()->runQuery('TRUNCATE production');
        Flight::db()->runQuery('TRUNCATE trade');
        Flight::db()->runQuery('SET FOREIGN_KEY_CHECKS=1');
        //create sectors
        $sector = new \App\Entity\sector();
        $sector->name = "Sol";
        $sector->save();

        for ($i = 1; $i < $this->numSectors; $i++) {
            $newSector = new \App\Entity\sector();

            do {
                $name = $this->sysname();
                $newSector->eq('name', $name)->find();
            } while ($name == $newSector->name);
            $newSector->name = $name;
            $newSector->save();
        }

        //create ports
        $port = new \App\Entity\port();
        $port->sector_id = 1;
        $port->save();
        echo "Sol created<br>";
        $sectors = range(1, $this->numSectors);
        shuffle($sectors);
        for ($i = 0; $i < $this->numPorts; $i++) {
            $newPort = new \App\Entity\port();
            $newPort->sector_id = $sectors[$i];
            $newPort->commodity_id = $i % 3 + 1;
            $newPort->save();
            for($j=1; $j <=3; $j++) {
                $newTrade = new \App\Entity\trade();
                $newTrade->port_id = $i+1;
                $newTrade->commodity_id = $j;
                $newTrade->stock = 5000;
                if ($newPort->commodity_id == $j) {
                    $newTrade->demand = -100;
                } else {
                    $newTrade->demand = 100;
                }
                $newTrade->save();
            }
        }
        $this->log->info($this->numSectors . ' sectors created');
        $this->log->reset();
        echo $this->numSectors . " sectors created<br>";

        //create unowned planets
        shuffle($sectors);
        for ($i = 0; $i < $this->numPlanets; $i++) {
            $newPlanet = new \App\Entity\planet();
            $newPlanet->sector_id = $sectors[$i];
            $currentSector = new \App\Entity\sector();
            $currentSector->find($i);
            $newPlanet->name = $currentSector->name . " I";
            $newPlanet->save();
            for($j=1; $j <=4; $j++) {
                $newProduction = new \App\Entity\production();
                $newProduction->planet_id = $i+1;
                $newProduction->commodity_id = $j;
                $newProduction->quantity = 1000;
                $newProduction->save();
            }


        }
        $this->log->info($this->numPlanets . ' planets created');
        $this->log->reset();
        echo $this->numPlanets . " planets created<br>";

        //create links - loop
        for ($i = 1; $i <= $this->numSectors; $i++) {
            $link = new \App\Entity\link();
            $rlink = new \App\Entity\link();
            $link->sector_id = $i;
            $rlink->destination_id = $i;
            $link->destination_id = ($i%$this->numSectors)+1;
            $rlink->sector_id = ($i%$this->numSectors)+1;
            $link->flags = 'permanent';
            $rlink->flags = 'permanent';
            $link->save();
            $rlink->save();
            $remainder = $this->linksPerSector - 2;
            //need to check for duplicates
            while ($remainder >0)
            {
                $randomLink = new \App\Entity\link();
                $randSector = rand(1,$this->numSectors);
                $result = $randomLink->eq('sector_id',$i)->eq('destination_id',$randSector)->find();

                if ($randomLink->destination_id != $randSector) {
                    $randomLink->sector_id = $i;
                    $randomLink->destination_id = $randSector;
                    $randomLink->save();
                    $remainder--;
                } else {
                    $this->log->info('link collision: '.$i.' and '.$randSector);
                }


            }
        }

    }
}


//$port = new App\Entity\port();
//$planet = new App\Entity\planet();



