#!/usr/bin/env bash
deploy:
	git pull origin master
	composer install --no-dev --optimize-autoloader
	php bin/console cache:clear
	make rights --no-print-directory

rights:
	chmod 777 -R var/cache var/log

db:
	php bin/console doctrine:schema:update --dump-sql
	read -p "Confirm ? (Y/n)" response
	php bin/console doctrine:schema:update --force;
