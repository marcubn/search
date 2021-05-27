The project is created with Laravel + Vue + MariaDB.


Docker:
To start the container we run `docker-compose up -d` (or `docker-compose up -d --build if it's the first time).


Database:
To connect to the database we use the user `bobby` with password `bobby_secret` and database `search`.
To create the tables run `php artisan migrate` from inside the web container (`docker exec -it b-m-2021-05-21_app_1 sh`).
To populate the data run `php artisan db:seed`.


Frontend:
The frontend can be accessed at `http://localhost:8080/`.


Backend:
The backend can be accessed via `http://localhost:8000/`.
For the api's I went for this project with a simple authentication via a token.
The token can be created with `php artisan make:token` and use it on every api call.


Tests:
I did only a couple of tests to check the flows
I used the real data on the DB because it is populated with fake data using seeders
For the future we could use the RefreshTable and not use the real db

Things that I am currently working on or trying to fix:
The connection between backend end frontend for POST and DELETE is not working because CORS
The validation redirects to home when not valid
The api token redirects to 'login' when token not valid

To be upgraded in future versions:
Replace basic token with something more complex. Passport or Sanctum
Not use the real db for tests
Add a modal for adding or editing a product
Add sort by in the columns
Add more validation: Check fields are int|string|etc, check brand from brands list, check for duplicate products etc
Create a better looking delete confirmation
Add logs to flows



