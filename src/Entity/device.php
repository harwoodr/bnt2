<?php
namespace App\Entity;

use App\Trait\uri;

class device extends \flight\ActiveRecord {
    protected array $relations = [
        'equipment' => [ self::HAS_MANY, equipment::class, 'device_id' ]
    ];
    public function __construct()
    {
        parent::__construct(\Flight::db(), 'device');

    }
    use uri;

}