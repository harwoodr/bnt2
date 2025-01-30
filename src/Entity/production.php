<?php

namespace App\Entity;

class production extends \flight\ActiveRecord
{

    protected array $relations = [
        'planet' => [ self::BELONGS_TO, planet::class, 'planet_id' ],
        'commodity' => [ self::BELONGS_TO, commodity::class, 'commodity_id' ]
    ];

    public function __construct()
    {
        parent::__construct(\Flight::db(), 'production');

    }
}