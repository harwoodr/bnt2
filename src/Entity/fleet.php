<?php
namespace App\Entity;

use App\Trait\owner;
use App\Trait\uri;

class fleet extends \flight\ActiveRecord {

    protected array $relations = [
        'cargo' => [ self::HAS_MANY, cargo::class, 'fleet_id' ],
        'ship' => [ self::HAS_MANY, ship::class, 'fleet_id' ],
        'equipment' => [ self::HAS_MANY, equipment::class, 'fleet_id' ],
        'player' => [ self::BELONGS_TO, player::class, 'player_id' ],
        'sector' => [ self::BELONGS_TO, sector::class, 'sector_id' ],
        'program' => [ self::BELONGS_TO, program::class, 'program_id' ]
    ];

    public function __construct()
    {
        parent::__construct(\Flight::db(), 'fleet');
    }
    use uri;
    use owner;
    public function getOwner(): ?player
    {
        return $this->player;
    }
}