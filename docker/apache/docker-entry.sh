php bin/console doctrine:database:create --if-not-exists
php bin/console d:m:m --no-interaction
php bin/console asset-map:compile

/usr/bin/supervisord
