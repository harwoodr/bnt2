<?php

namespace App\Entity;

use App\Trait\owner;

class link extends \flight\ActiveRecord
{

    protected array $relations = [
        'sector' => [ self::BELONGS_TO, sector::class, 'sector_id' ],
        'destination' => [ self::BELONGS_TO, sector::class, 'destination_id' ]
    ];

    public function __construct()
    {
        parent::__construct(\Flight::db(), 'link');

    }

    use owner;
    public function getOwner(): ?player
    {
        return $this->player;
    }
}