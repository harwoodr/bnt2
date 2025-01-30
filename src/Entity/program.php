<?php

namespace App\Entity;

use App\Trait\owner;
use App\Trait\uri;

class program extends \flight\ActiveRecord
{

    protected array $relations = [
        'fleet' => [ self::HAS_MANY, fleet::class, 'program_id' ],
        'player' => [ self::BELONGS_TO, player::class, 'player_id' ]
    ];

    public function __construct()
    {
        parent::__construct(\Flight::db(), 'program');

    }

    use owner;
    public function getOwner(): ?player
    {
        return $this->player;
    }

    use uri;

}