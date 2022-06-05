#!/bin/sh

# migrations
php bin/console doctrine:schema:update --force;

apache2-foreground
