<?php

namespace App\Entity;

use App\Trait\owner;
use App\Trait\uri;

class player extends \flight\ActiveRecord
{

    protected array $relations = [
        'fleet' => [ self::HAS_MANY, fleet::class, 'player_id' ],
        'program' => [ self::HAS_MANY, program::class, 'player_id' ],
        'planet' => [ self::HAS_MANY, planet::class, 'player_id' ],
        'event' => [ self::HAS_MANY, event::class, 'player_id' ],
        'link' => [ self::HAS_MANY, link::class, 'player_id' ],
        'team' => [ self::HAS_MANY, fleet::class, 'player_id' ],
        'membership' => [ self::BELONGS_TO, team::class, 'team_id' ]
    ];

    public function __construct()
    {
        parent::__construct(\Flight::db(), 'player');

    }
    use owner;
    public function getOwner(): ?player
    {
        return $this;
    }
    use uri;

}