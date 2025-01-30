<?php
namespace App\Trait;
use App\Entity\player;
use Flight;

trait owner {
    public function isOwner($player_id): bool
    {
        return ($player_id == $this->getOwner());
    }

    public function getOwnerID(): ?int {
        $owner = $this->getOwner();
        return $owner->id;
    }
    abstract public function getOwner(): ?player;
}