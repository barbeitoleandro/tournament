#!/bin/sh

# Setup a cron schedule
echo "* * * * * cd /var/www/html && /usr/local/bin/php artisan schedule:run >> /var/log/cron.log 2>&1
# This extra line makes it a valid cron" > /scheduler.txt

apachectl start
# php artisan queue:work

# crontab /scheduler.txt
# cron -f




