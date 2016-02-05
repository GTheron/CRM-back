php app/console doctrine:schema:drop --force
php app/console doctrine:schema:update --force
php app/console doctrine:fixtures:load
php app/console core:oauth-server:client:create --grant-type "password"

php app/console loadData:city
php app/console loadData:municipality
php app/console loadData:department