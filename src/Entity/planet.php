<?php

namespace App\Entity;

use App\Trait\owner;
use App\Trait\uri;

class planet extends \flight\ActiveRecord
{

    protected array $relations = [
        'sector' => [ self::BELONGS_TO, sector::class, 'sector_id' ],
        'player' => [ self::BELONGS_TO, player::class, 'player_id' ],
        'production' => [ self::HAS_MANY, production::class, 'planet_id' ]
    ];

    public function __construct()
    {
        parent::__construct(\Flight::db(), 'planet');

    }
    use owner;
    public function getOwner(): ?player
    {
        return $this->player;
    }
    use uri;

}