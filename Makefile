#!/usr/bin/env bash
deploy:
	git pull origin master
	composer dump-env prod
	composer install --no-dev --optimize-autoloader

db:
	php bin/console doctrine:schema:update --dump-sql
	read -p "Confirm ? (Y/n)" response
	php bin/console doctrine:schema:update --force;
