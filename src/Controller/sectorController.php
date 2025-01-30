<?php
namespace App\Controller;

use App\Entity;
use App\Trait;
use Flight;

class sectorController extends basicController {

    public string $targetName = 'App\Entity\sector';

    //'index' => 'GET '
    public function index(): void
    {
        if(isset($this->request->query['from'])){
            $this->target->ge('id',$this->request->query['from']);
        }
        if(isset($this->request->query['to'])){
            $this->target->le('id',$this->request->query['to']);
        }

        $this->limits();

        $this->results = $this->target->findAll();
        $numResults = count($this->results);
        for($i=0; $i<$numResults; $i++) {
            $this->results[$i]->setCustomData('port', $this->results[$i]->port);
        }
        $links = $this->uri($numResults);
        Flight::json([$links,$this->results]);

    }

    //'show' => 'GET /@id'
    public function show(int $id): void
    {

        $this->target->find($id);
        if (!$this->target->isHydrated()) {
            Flight::status(404,'Sector not found');
        }
        //TODO: add in stuff for cloaking...
        $playerFleets = new Entity\fleet();
        $this->results  = $playerFleets->eq('player_id',Flight::get('current_player_id'))->findAll();
        $sectors = array_column($this->results , 'sector_id');
        if (in_array($this->target->id, $sectors)) {
            //if the player has a fleet in this sector, show more info
            //TODO: add in stuff for cloaking...
            //TODO: trim some data
            $extra = ['fleet','port','link','planet'];
            foreach ($extra as $relation){
                $this->target->setCustomData($relation,$this->target->$relation);
            }
        }
        Flight::json($this->target);

    }


}