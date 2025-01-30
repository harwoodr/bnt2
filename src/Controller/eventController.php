<?php
namespace App\Controller;

use App\Entity;
use App\Trait;
use Flight;

class eventController extends basicController {

    public string $targetName = 'App\Entity\event';

    //add event - POST
    public function store(): void
    {
        //Flight::dump($this->request);
        //$input = json_decode($this->request->getBody(),true);
        $input = $this->request->data;
        $this->target->title = $input['title'];
        $this->target->content = $input['content'];
        if(isset($input['player_id'])) {
            $this->target->player_id = $input['player_id'];
        }
        $this->target->other_player_id = Flight::get('current_player_id');
        $this->target->save();
        Flight::status(201);
    }
    //read event - GET
    public function show(int $id): void
    {
        $this->target->find($id);
        if (!$this->target->isHydrated()) {
            Flight::status(404,'Event/message not found');
        }
        if($this->target->player_id == Flight::get('current_player_id') || $this->target->other_player_id == Flight::get('current_player_id')  || is_null($this->target->player_id)) {
            Flight::json($this->target);

        } else {
            Flight::status(403,'Not sender or valid recipient of event/message');
        }

    }
    //get events - GET
    public function index(): void
    {
        if(isset($this->request->query['from_stamp'])){
            $this->target->ge('stamp',$this->request->query['from_stamp']);
        }
        if(isset($this->request->query['to_stamp'])){
            $this->target->le('stamp',$this->request->query['to_stamp']);
        }

        //player should be able to see events to or from themselves or sent to NULL (everyone)

        if(isset($this->request->query['to'])){
            if($this->request->query['to'] == Flight::get('current_player_id')){
                //to me
                $this->target->eq('player_id',$this->request->query['to']);
            } else {
                //from me to other
                $this->target->eq('player_id',$this->request->query['to'])->eq('other_player_id',Flight::get('current_player_id'));
            }

        }
        if(isset($this->request->query['from'])){
            if ($this->request->query['from'] == Flight::get('current_player_id')) {
                //from me to any
                $this->target->eq('other_player_id',Flight::get('current_player_id'));
            } else {
                //from someone to me
                $this->target->eq('other_player_id',$this->request->query['from'])->eq('player_id',Flight::get('current_player_id'));
            }
        }

        if(!isset($this->request->query['from']) && !isset($this->request->query['to'])) {
            $this->target->where('(player_id='.Flight::get('current_player_id').' OR player_id is null)');
        }
        $this->limits();

        if(isset($this->request->query['order']) && strtoupper($this->request->query['order']) =='DESC') {
            $this->target->orderBy('stamp DESC');
        } else {
            $this->target->orderBy('stamp ASC');
        }
        $this->results = $this->target->findAll();
        //Flight::json([$this->target->getBuiltSQL(),$this->results]);
        Flight::json($this->results);

    }

    //delete event
    public function destroy(string $id): void
    {
        $this->target->find($id);
        if (!$this->target->isHydrated()) {
            Flight::status(404,'Event/message not found');
        }
        if($this->target->player_id == Flight::get('current_player_id')){
            $this->target->delete();
            Flight::status(204,'Event/message deleted');
        } else {
            Flight::status(403,'Not direct recipient of event/message');
        }
    }
}