<?php
namespace App\Trait;
use App\Entity;
use Flight;

trait controller {

    public ?object $target;
    public ?array $results;
    public string $targetName;
    public $request;
    public int $offset = 0;
    public int $limit = 10;

    public function limits() {
        if(isset($this->request->query['limit']) || isset($this->request->query['offset'])) {
            if(isset($this->request->query['offset']) ) {
                $this->offset = $this->request->query['offset'];
            }
            if(isset($this->request->query['limit'])) {
                $this->limit = $this->request->query['limit'];
            }
            $this->target->limit($this->offset,$this->limit);
        }
        $this->target->limit(0,10);
    }

    public function uri() {
        $results = $this->target->select('COUNT(*) as count')->findAll();

        $uri = $this->request->url;
        $links['self'] = $uri;
        $links['start'] = $uri . '?limit='.$this->limit;
        $links['next'] = $uri . '?offset='.$this->offset+$this->limit.'&limit='.$this->limit;
        if($this->offset > 0) {
            $links['prev'] = $uri . '?offset='.$this->offset-$this->limit .'&limit='.$this->limit;
        }
        if (isset($results[0]->count)) {
            $links['end'] = $uri . '?offset='.$results[0]->count-$this->limit.'&limit='.$this->limit;
        }

        return $links;
    }

}