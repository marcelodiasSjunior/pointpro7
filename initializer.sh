cp ./laravel/.env.example ./laravel/.env
cp ./flask/.env.example ./flask/.env
cd laravel && npm i && cd ../
docker-compose -f ./pro7_dev/docker-compose.yml up -d --build
docker exec pro7_php composer update
docker exec pro7_php php artisan migrate:refresh --seed --force
docker restart pro7_php

# This below can be ignored
#docker-compose -f /var/www/pro7/pro7_prod/docker-compose.yml up -d --build
#openssl req -x509 -nodes -newkey rsa:2048 -keyout key.pem -out cert.pem -sha256 -days 365 -subj "/C=GB/ST=London/L=London/O=Alros/OU=IT Department/CN=localhost"
#openssl req -x509 -nodes -newkey rsa:2048 -keyout key_python.pem -out cert_python.pem -sha256 -days 365 -subj "/C=GB/ST=London/L=London/O=Alros/OU=IT Department/CN=localhost"