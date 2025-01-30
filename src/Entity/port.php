<?php

namespace App\Entity;

use App\Trait\uri;

class port extends \flight\ActiveRecord
{

    protected array $relations = [
        'sector' => [ self::BELONGS_TO, sector::class, 'sector_id' ],
        'commodity' => [ self::BELONGS_TO, commodity::class, 'commodity_id' ],
        'trade' => [ self::HAS_MANY, trade::class, 'port_id' ]
    ];

    public function __construct()
    {
        parent::__construct(\Flight::db(), 'port');

    }
    use uri;

}