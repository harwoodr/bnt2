<?php
namespace App\Entity;


class cargo extends \flight\ActiveRecord {
    protected array $relations = [
        'fleet' => [ self::BELONGS_TO, fleet::class, 'fleet_id' ],
        'commodity' => [ self::BELONGS_TO, commodity::class, 'commodity_id' ]
    ];

    public function __construct()
    {
        parent::__construct(\Flight::db(), 'cargo');

    }


}