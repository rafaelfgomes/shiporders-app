#!/bin/bash
clear

if [ ! -f .env ]; then

  cp .env.sample .env

else

  echo '.env file exists'
  exit 1

fi

#folderName=$(basename $(pwd))
prefixContainerName=shiporders

frontendHttpPort=13000
frontendHttpsPort=4554
nginxHttpPort=8686
nginxHttpsPort=4646
dbPort=33060

apiContainerName=$prefixContainerName"_api"
mariadbContainerName=$prefixContainerName"_db"
nginxContainerName=$prefixContainerName"_nginx"
pageContaineNrame=$prefixContainerName"_frontend"
appTz=$(curl http://ip-api.com/line?fields=timezone)

sed -i "s+API_CONTAINER_NAME=+API_CONTAINER_NAME=$apiContainerName+g" .env
sed -i "s+MARIADB_CONTAINER_NAME=+MARIADB_CONTAINER_NAME=$mariadbContainerName+g" .env
sed -i "s+NGINX_CONTAINER_NAME=+NGINX_CONTAINER_NAME=$nginxContainerName+g" .env
sed -i "s+FRONTEND_CONTAINER_NAME=+FRONTEND_CONTAINER_NAME=$pageContaineNrame+g" .env
sed -i "s+TIMEZONE=+TIMEZONE=$appTz+g" .env

sed -i "s+FRONTEND_HTTP_PORT=+FRONTEND_HTTP_PORT=$frontendHttpPort+g" .env
sed -i "s+FRONTEND_HTTPS_PORT=+FRONTEND_HTTPS_PORT=$frontendHttpsPort+g" .env
sed -i "s+API_HTTP_PORT=+API_HTTP_PORT=$nginxHttpPort+g" .env
sed -i "s+API_HTTPS_PORT=+API_HTTPS_PORT=$nginxHttpsPort+g" .env
sed -i "s+DB_PORT=+DB_PORT=$dbPort+g" .env