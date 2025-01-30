<?php

namespace App\Entity;


class equipment extends \flight\ActiveRecord
{

    protected array $relations = [
        'fleet' => [ self::BELONGS_TO, fleet::class, 'fleet_id' ],
        'device' => [ self::BELONGS_TO, device::class, 'device_id' ]
    ];

    public function __construct()
    {
        parent::__construct(\Flight::db(), 'equipment');

    }

}