<?php
namespace App\Trait;
use App\Entity;


trait uri {

    public function afterFind($self) {
        $uri = '/'.$this->table.'/'.$this->id;
        $self->setCustomData('links', ['self' =>$uri]);
    }
    protected function afterFindAll(array $results) {

        foreach($results as $self) {
            // do something cool like afterFind()
            $uri = '/'.$this->table.'/'.$self->id;
            $self->setCustomData('links', ['self' =>$uri]);
        }
    }
}