<?php
namespace App\Controller;

use App\Entity;
use App\Entity\fleet;
use App\Trait;
use Flight;

class fleetController extends basicController {

    public string $targetName = 'App\Entity\fleet';


    //add fleet - POST - may do through ships?

    //read fleet - GET /@id
    public function show(int $id): void
    {

        $this->target->find($id);
        if (!$this->target->isHydrated()) {
            Flight::status(404);
        }
        if($this->target->getOwnerID() == Flight::get('current_player_id')) {
            if(isset($this->request->query['cargo'])) {
                $this->target->setCustomData('cargo', $this->target->cargo);
            }

            if (isset($this->request->query['equipment'])) {
                $this->target->setCustomData('equipment', $this->target->equipment);

            }
            if (isset($this->request->query['ship'])) {
                $this->target->setCustomData('ship', $this->target->ship);

            }

                Flight::json($this->target);







        } else {
            //TODO: add in stuff for cloaking...
            $playerFleets = new Entity\fleet();
            $this->results  = $playerFleets->eq('player_id',Flight::get('current_player_id'))->findAll();
            $sectors = array_column($this->results , 'sector_id');
            if (in_array($this->target->sector_id, $sectors)) {
                Flight::json($this->target);
            } else {
                Flight::status(403,'Not fleet owner and no owned fleet in same sector');
            }

        }
    }

    //get fleets - GET
    public function index(): void
    {
        //TODO: add orderBy and limits
        $playerFleets = new Entity\fleet();
        $results = $playerFleets->eq('player_id',Flight::get('current_player_id'))->findAll();
        $sectors = array_column($results, 'sector_id');

        if(isset($this->request->query['sector_id'])){
            if(in_array($this->request->query['sector_id'],$sectors)){
                //all visible fleets in a sector if I have a fleet in said sector
                //TODO: add in stuff for cloaking...

                $this->results  = $this->target->eq('sector_id',$this->request->query['sector_id'])->findAll();

            } else {
                Flight::status(403,'No owned fleet in sector');

            }

        } else {
            //all of my fleets
            $this->results  = $results;
        }
        Flight::json($this->results);


    }
    //delete fleet - DELETE  /@id - may do through ships?

    //'update' => 'PUT /@id'
    public function update(string $id): void
    {
        $this->target->find($id);
        if (!$this->target->isHydrated()) {
            Flight::status(404,'Fleet not found');
        }
        if($this->target->getOwnerID() == Flight::get('current_player_id')) {
            //Flight::dump($this->request->data);
            if(isset($this->request->data['sector_id']) && $this->request->data['sector_id'] != $this->target->sector->id) {
                //use warp link to another sector TODO: ->Q
                if (in_array($this->request->data['sector_id'],array_column($this->target->sector->link, 'destination_id'))) {
                    $this->target->sector_id = $this->request->data['sector_id'];
                    $this->target->save();
                } else {
                    Flight::status(422,'Problem with target sector');
                }
            } elseif(isset($this->request->data['target_id'])) {
                //attack another fleet TODO: ->Q and account for cloak
                $victim = new Fleet();
                $victim->find($this->request->data['target_id']);
                if(!$victim->isHydrated()) {
                    Flight::status(422, "Target not found");
                }
                //check if on same team
                if ($victim->player->team_id != $this->target->player->team_id || is_null($victim->player->team_id)) {
                    if ($victim->sector_id == $this->target->sector_id) {
                        //attack logic TODO
                        Flight::status(202, "Attack added to queue");

                    } else {
                        //not in same sector
                        Flight::status(422, "Target not in same sector as player fleet");
                    }


                } else {
                    //on same team
                    Flight::status(409, "Target on same team as player");
                }
                //flight::json($victim->player);
            } elseif (isset($this->request->data['merge_id']) ) {
                //merge fleets TODO: ->Q
                $mergee = new Fleet();
                $mergee->find($this->request->data['merge_id']);
                if (!$mergee->isHydrated()) {
                    Flight::status(422, "Merge target not found");
                }
                if ($mergee->getOwnerID() != Flight::get('current_player_id')) {
                    Flight::status(403, 'Not merge target owner');
                } else {
                    //merge logic TODO
                    Flight::status(202, "Merger added to queue");
                }
            } elseif(isset($this->request->data['purchase'])) {
                //buy commodity from port and add it to the fleet
                //TODO: lots (credits for one)
            } else {
                Flight::status(422,'No recognized operation');
            }




        } else {
            Flight::status(403,'Not fleet owner');

        }

    }

}