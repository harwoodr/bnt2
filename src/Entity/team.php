<?php

namespace App\Entity;

use App\Trait\owner;
use App\Trait\uri;

class team extends \flight\ActiveRecord
{

    protected array $relations = [
        'player' => [ self::BELONGS_TO, player::class, 'player_id' ],
        'member' => [ self::HAS_MANY, player::class, 'team_id' ]
    ];

    public function __construct()
    {
        parent::__construct(\Flight::db(), 'team');

    }

    use owner;
    public function getOwner(): ?player
    {
        return $this->player;
    }
    use uri;

}