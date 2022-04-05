# UMTC Election

University of Mindanao Tagum College Election System

## Prerequisites

* Php 8.0.2 or up
* Node and Npm
* composer
* MySQL
* XAMPP (Optional)
* Docker (Optional)

## Run Locally

Clone the repository and go to umtc-election directory
```shell
git clone https://github.com/jedymatt/umtc-election.git

cd umtc-election
```

Generate .env file
```shell
cp .env.development .env
```

Note: If you are using laravel sail, replace `.env.development` to `.env.sail` instead.

Then, configure the .env file according to your use case.

Install the composer dependencies
```shell
composer install --ignore-platform-reqs
```
Run this instead when using docker:
```shell
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

Then, compile the assets
```shell
npm install
npm run dev
```

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
Finally, visit <http://localhost:8000> to view the site.
