#!/bin/bash

sudo apt install php8.1-xml php8.1-gd php8.1-zip php8.1-mysql

cd /var/www/laravel && composer install --optimize-autoloader --no-dev

php artisan key:generate --force

php artisan optimize

sudo apt-get install supervisor

worker_file_content='
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
'

# sudo bash -c 'cat << EOF >/etc/supervisor/conf.d/laravel-worker.conf
# $worker_file_content
# EOF'
sudo bash -c '"$worker_file_content" >> /etc/supervisor/donf.d/laravel-worker.conf'


sudo supervisorctl reread

sudo supervisorctl update

sudo supervisorctl start laravel-worker:*

echo "Run 'crontab -e' and append this line:"
echo "* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1"
