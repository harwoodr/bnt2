<?php

namespace App\Entity;

class trade extends \flight\ActiveRecord
{

    protected array $relations = [
        'port' => [ self::BELONGS_TO, port::class, 'port_id' ],
        'commodity' => [ self::BELONGS_TO, commodity::class, 'commodity_id' ]
    ];

    public function __construct()
    {
        parent::__construct(\Flight::db(), 'trade');

    }
}