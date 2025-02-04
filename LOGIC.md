# Game logic notes

## Queue use for some commands
If a command will cause a change in the game state, it should be added to the job queue.  Jobs in the queue will be dealt with by a stand-alone process (either long-running or periodic in nature) - our "queue runner".  
How the queue runner interacts with game objects is still TBD - it could be through the API (meaning it could run on a different system than the game itself) or it may directly access the game controllers with a different access profile.
This will prevent many race conditions that can plague a game of this nature.

The current plan is to use [Enqueue](https://enqueue.forma-pro.com/) to support different queue back ends - the file based approach is the simplest and will be the default for development.

Queued commands will return generally result in a [202 Accepted](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/202) [HTTP response status code](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status).

Commands that simply read data from the system will return the data immediately.

## System update
The original bnt performed system updates server side by executing the scheduler via cron.  The plan for bnt2 is to still use cron (or a cron-like service) to add a system update commands to the queue - which would then be executed by the queue runner.  
This again removes the threat of some race conditions and also allows for dealing with the possibility of heavy system load.

## Ship numbers

- hull: is the size of the hull dictating cargo capacity but also target size
- engines: motive forces for the ship aids in both defensive and offensive capabilities as well.
- power: provides energy for engines, weapons, shields and cloak - too low and these dependent systems will suffer and perform at a degraded level
- computer: enhances offensive capabilities and sensor analysis
- sensors: provides scanning information and potentially sees past adversarial cloaks
- weapons: primary offensive capabilities - directly affects damage inflicted
- shields: regenerative defensive system - regenerates between combat sessions
- armour: ablative defensive system - must be repaired to restore damage
- cloak: a system that hides the ship from others

## Planet numbers

- planets with no player_id are unowned and can be claimed by players
- shields and weapons are similar to the values for ships but can be much larger (in theory)
- commodity quantities, production facilities are stored in the production table

### Combat 

- offensive and defensive are both a function of computer, engines, hull, sensors and cloak
- offensive is modified by weapons
- defensive is modified by shields and armour
- damage inflicted is a direct function of weapons, modified by computer and sensors.
- damage sustained is opponent's inflicted damage, modified by shields and armour.
- damage is applied first to shields and then to armour.
- if armour is reduced to zero, the ship is destroyed.
- when a ship is destroyed, if the fleet's cargo capacity is reduced below the current cargo carried, random cargo is jettisoned until the capacity limit is met.
- jettisoned cargo may be salvaged by the attacker
- if there are defender aligned fleets or planets in the same sector as the combat - they join as defenders in the combat. 
