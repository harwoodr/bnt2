<?php

namespace App\Entity;

use App\Trait\uri;

class sector extends \flight\ActiveRecord
{

    protected array $relations = [
        'fleet' => [ self::HAS_MANY, fleet::class, 'sector_id' ],
        'planet' => [ self::HAS_MANY, planet::class, 'sector_id' ],
        'port' => [ self::HAS_MANY, port::class, 'sector_id' ],
        'link' => [ self::HAS_MANY, link::class, 'sector_id' ],
        'inverseLink' => [ self::HAS_MANY, link::class, 'destination_id' ],
    ];

    public function __construct()
    {
        parent::__construct(\Flight::db(), 'sector');

    }
    use uri;


}