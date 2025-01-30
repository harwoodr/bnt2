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

