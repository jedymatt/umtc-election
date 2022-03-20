# UMTC Election

University of Mindanao Tagum College Election System

## Run Locally

Clone the repository and go to umtc-election directory
```shell
git clone https://github.com/jedymatt/umtc-election.git

cd umtc-election
```

Generate .env file
```shell
cp .env.example .env
```

Note: If you are using laravel sail, replace `.env.example` to `.env.sail` instead.

Then, configure the .env file according to your use case.

Populate the tables and the data to the database
```shell
php artisan migrate --seed
```

Generate app key
```shell
php artisan key:generate
```

Run the application
```shell
php artisan serve
```
Finally, visit http://localhost:8000 to view the site.
