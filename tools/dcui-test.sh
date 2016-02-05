#!/usr/bin/env bash

php app/console doctrine:schema:drop --force --env=test
php app/console doctrine:schema:update --force --env=test
php app/console loadData:city -e test
php app/console loadData:municipality -e test
php app/console loadData:department -e test