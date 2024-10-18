# PokeApi

API project that will let you know everything about pokemon

## INSTALLATION

- Install **docker** and **ddev**: <https://ddev.com/get-started/>

- Extract the project in the folder you prefer

- Inside your project launch **ddev start** (the docker containers will be created)

- Launch **ddev import-db --file=./db.sql** if you want to import a ready database with datas otherwise launch **ddev artisan migrate** (the Laravel command to launch migrations, files that create the database tables) that creates an empty database instance
- Launch **ddev composer install**
- Launch **ddev artisan key:generate**
- Launch **ddev artisan config:cache**
- Launch **ddev launch** in order to open your favourite browser with the
local project

# IF YOU SEE A GREEN SCREEN WITH A POKEBALL YOU ARE READY!

## Database
A prepared DB already full of data is ready for you in the repo, just import it in your database with
**ddev import-db --file=./db.sql**

If you want to see it just launch this command:
**ddev phpmyadmin**

## API
A collection with all the API you can call from the project is ready for you, you can import it in Postman, its name is **collection.json**

## DDEV
I have already installed in the ddev instance of this project phpmyadmin so that the database could be seen very easily. Just launch **ddev phpmyadmin** and the browser will open a new tab with phpmyadmin already open. The database name will be db!
To stop the ddev container you can run **ddev stop**, this is the opposite of ddev start. In order to clear the cache of the project you can launch **ddev artisan cache:clear** but in Laravel you will not need it very much.
In order to have information about the ddev containers of the project you can run **ddev describe**

## Command and Jobs
If you want to import all the datas from the API you can use the command app:import, just launch **ddev artisan app:import**. This command will create a lot of jobs that the local server will run when it will be ready in the order it prefers. Since we are locally we have to make the server listen for the jobs in the queue and make those jobs be runnable, in order to do that just launch **ddev artisan queue:work** and the jobs will be dispatched.

Since there are lots of API to call in order to retrieve all the data I suggest to use the database in the repository, otherwise waiting for all the jobs to import all the datas will cost you some **hours**! I have spent this time for you, don't be crazy like me! :)

## Contacts
If you need any other help or tip just write me here:
**pietrocalzolari@live.com**

# Thanks
