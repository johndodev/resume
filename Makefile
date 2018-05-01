#!/usr/bin/env bash
all:
	git pull origin master
	composer install
	make clear-cache --no-print-directory
	make rights --no-print-directory

rights:
	chmod 777 var/cache var/logs

db:
	php vendor/bin/doctrine.php orm:schema-tool:update --force

clear-cache:
	rm -rf var/cache/*
