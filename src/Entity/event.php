<?php

namespace App\Entity;

use App\Trait\owner;
use App\Trait\uri;

class event extends \flight\ActiveRecord
{

    protected array $relations = [
        'player' => [ self::BELONGS_TO, player::class, 'player_id' ],
        'sender' => [ self::BELONGS_TO, player::class, 'player_id' ]
    ];

    public function __construct()
    {
        parent::__construct(\Flight::db(), 'event');

    }

    use owner;
    public function getOwner(): ?player
    {
        return $this->player;
    }
    use uri;

}