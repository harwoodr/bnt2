<?php
namespace App\Entity;

use App\Trait\uri;

class commodity extends \flight\ActiveRecord {
    protected array $relations = [
        'production' => [ self::HAS_MANY, production::class, 'commodity_id' ],
        'cargo' => [ self::HAS_MANY, cargo::class, 'commodity_id' ],
        'trade' => [ self::HAS_MANY, trade::class, 'commodity_id' ]
    ];
    public function __construct()
    {
        parent::__construct(\Flight::db(), 'commodity');
    }
    use uri;

}