#!/usr/bin/env bash
all:
	git pull origin master
	composer install
	make rights --no-print-directory

rights:
	chmod 777 -R var/cache var/log

db:
	php bin/console doctrine:schema:update --force

