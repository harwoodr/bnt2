<?php
namespace App\Entity;


use App\Trait\owner;

class invite extends \flight\ActiveRecord {
    protected array $relations = [
        'player' => [ self::BELONGS_TO, player::class, 'player_id' ],
        'team' => [ self::BELONGS_TO, team::class, 'team_id' ]
    ];
    public function __construct()
    {
        parent::__construct(\Flight::db(), 'invite');

    }
    use owner;
    public function getOwner(): ?player
    {
        return $this->player;
    }

}