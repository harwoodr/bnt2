# Primary game objects

## Commodity
Either a basic item/material for trade or colonists.

### Cargo
The quantity of a commodity carried by a fleet.  Cargo takes up space in the ships in a fleet.

### Production
The quantity of a commodity on a planet.

### Trade
Includes the demand (negative being a supply) for a commodity and current stock of said commodity for a port.

## Player
There are (currently) three types of player defined:
- system - the default owner of many things, not actually a player
- pc - actual human players
- npc - computer/ai operated players

### Program
A set of instructions for fleet automation - much of this is TBD.

## Event
System notifications and messages from other players.  Either directly to a player or system wide.  This will probably evolve to something better over time.

## Team
A group of allied/friendly players.  Effectively a non-aggression and defense pact. 

### Invite
An offer from a team owner to another player to join their team.  Currently, a player may only belong to one team.

## Fleet
A group of ships that is owned by a player.  May move from sector to sector using links.

## Ship
A spaceship - has attributes that define its capabilities and qualities.

## Device
A consumable item that is carried by a fleet and can be used to some effect.  Examples could include planet creation and link editing.

### Equipment
The quantity of a given device carried by a fleet.

## Sector
A place with a star that is connected to others via links.  It can also contain planets, fleets and ports.

### Link
A one way connection from one sector to another.  Can be defined as permanent (system created) or stealth (player created and purposely hidden).  Player created links can have a stability value that when decreased to zero removes the link - how this value is decreased is still TBD.

## Port
A spaceport that buys and sells commodities and/or provides services (repair, sales, equipment) for ships.

## Planet
A place where colonists live and work - producing and consuming commodities.  Can be owned by a player and plans for capabilities (like defenses) are TBD.



