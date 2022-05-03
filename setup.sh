#!/bin/bash

su - larasail

cd /var/www/laravel

# Install important php dependencies

sudo apt install php8.1-xml php8.1-gd php8.1-zip php8.1-mysql -y

# setup for laravel queue

sudo apt-get install supervisor -y

sudo bash -c '
cat << EOF >/etc/supervisor/conf.d/laravel-worker.conf
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/laravel/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=larasail
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/laravel/storage/logs/worker.log
stopwaitsecs=3600
EOF'

sudo supervisorctl reread

sudo supervisorctl update

sudo supervisorctl start laravel-worker:*

# end of setup queue

composer install --optimize-autoloader --no-dev

cp .env.production .env

php artisan key:generate --force

larasail database init --user larasail --db umtc_election

php artisan migrate --seed

php artisan optimize

echo 'Run `crontab -e` and append this line:'
echo "* * * * * cd /var/www/laravel && php artisan schedule:run >> /dev/null 2>&1"
