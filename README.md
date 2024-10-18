# PokeApi

Api Project that makes you know everything about Pokemons

## INSTALLATION

- Install **docker** and **ddev**: <https://ddev.com/get-started/>

- Extract the project in the folder you prefer

- Launch **ddev start** (the docker containers will be created)

- Launch **ddev import-db --file=./db.sql** if you want to import a ready database with datas otherwise launch **ddev artisan migrate** (the Laravel command to launch migrations, files that create the database tables) that creates an empty database instance
- Launch **ddev composer** install
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

## Contacts
If you need any other help just write me:
**pietrocalzolari@live.com**

# Thanks
