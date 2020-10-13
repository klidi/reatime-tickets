
## Realtime-tickets-reservation

Thank you for taking time to review this.

There are so many way to implement this in laravel like (pusher or socket.io + redis broadcasting through laravel events) 
but I went with Swoole and more specifically with laravel-swoole package.

I made this choice with the future intent to utilize the full power of swoole event loop, websockets + coroutines;
I did not have a chance to utilize  coroutines due to time constraints but there is definitely place for them when calculating clearance levels
and accessing redis or mysql.

I have used a scaffolding tool to quickly generate a ui as the task is somewhat large. I would have preferred to go with something
like a spa in Angular or Vue but a fullstack laravel setup was what the tool offered as first choice.

The acl implementation i did is very basic (not granular at all), just to give the idea of roles

The algorithm that calculates the clearance levels its very basic though i could have gone with something like
a DFS with polynomial time but it would make it less readable

What i am doing instead if i need to calculate from scratch (reserve and delete actions): 
I am just summing the next clearance with the sums that are calculated before it 
Lets say i have [10, 15, 10] and sums [10, 15, 25] after iterating the first 2 items
next i have element 3rd item which is 10. I dont grab [10, 15, 10] and find out all combos but i sum directly with [10, 15, 25] and so on and so fourth.

Now one interesting part this is that i also save the sum and array index (prevents duplicates) and the first combo(ticket ids) that produces this sum
as its value example: $clearances[25] => [1,2]  1,2 is the ticket ids and 25 is their sum. The clearance combos are stored in redis
This makes it easier for me to when i want to reserve a clearance level, basically  i just get the clearances from redis and grab/access the tickets ids by 
the clearance value that the user clicked. $ticketsIds = $clearances[25]. 25 is the value that the user clicked and was emited from
ui to webserver.

The code run fine locally on my macbook on very limited resources with up to 16773 

## Some features
The reserve is done through the socket connection both ways. User clicks -> backend reserves and responds with the recalculated values ->
ui reflects this in the grid/table. this event is also broadcasted to all connected users so their grids are also updated in real time

If an admin creates a new ticket or deletes a ticket , the change will be broadcasted to all connected users and grid will update
update its items according to the action performed

## TO DO / IMPROVEMENTS

- I have done only one development cycle due to time constraints and i did not have time to refactor or add tests
- The tickets service and controllers needs some refactoring. Tickets Service is doing business logic which belongs to the domain mode
- Clearances are stored as array but they need their own type (ClearanceCollection), not only for type hinting but also for easier testing and 
moving some calculation logic inside the collection class where it belongs. This will also help with pagination.
- Implement Clearance pagination and realtime search, in very large items (above 15k combos) the ui and socket becomes bloated due to the size of data
- Lock/mutex might need to be implemented on resources (redis and db) to prevent racing conditions
- Indexing tables when we have more use cases , cant decide indexes just based on cardinality
- Acl can be more granular
- Memory footprint test
- Coroutine implementation.


## How to set up and run

- how to setup swoole and run the server: https://github.com/swooletw/laravel-swoole
- acl package: https://github.com/kodeine/laravel-acl
- laravel scaffolding: https://labs.infyom.com/laravelgenerator/

- composer install
- npm install
- php artisan migrate
- php artisan db:seed --Class (i have provided some seeding for user/admin, permissions, roles)
- php artisan swoole:http start
