<?php
namespace App\Entity;

use App\Trait\owner;
use App\Trait\uri;

class ship extends \flight\ActiveRecord {

    protected array $relations = [
        'fleet' => [ self::BELONGS_TO, fleet::class, 'fleet_id' ]
    ];

    public function __construct()
    {
        parent::__construct(\Flight::db(), 'ship');

    }

    use owner;
    public function getOwner(): ?player
    {
        return $this->fleet->player;
    }
    use uri;

}