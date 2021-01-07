#!/bin/bash

LINE="============================================="

if [ ! -f .env ]; then

  cp .env.sample .env
  clear

else

  echo '.env file exists'
  exit 1

fi

echo -e "$LINE"
echo "          Setup inicial da aplicação"
echo -e "$LINE"

folderName=$(basename $(pwd))

apiContaineName=$folderName"_api"
composerContainerName=$folderName"_composer"
mariadbContainerName=$folderName"_db"
nginxContainerName=$folderName"_nginx"
pageContaineNrame=$folderName"_page"

sed -i "s+API_CONTAINER_NAME=+API_CONTAINER_NAME=$apiContaineName+g" .env
sed -i "s+COMPOSER_CONTAINER_NAME=+COMPOSER_CONTAINER_NAME=$composerContainerName+g" .env
sed -i "s+MARIADB_CONTAINER_NAME=+MARIADB_CONTAINER_NAME=$mariadbContainerName+g" .env
sed -i "s+NGINX_CONTAINER_NAME=+NGINX_CONTAINER_NAME=$nginxContainerName+g" .env
sed -i "s+PAGE_CONTAINER_NAME=+PAGE_CONTAINER_NAME=$pageContaineNrame+g" .env

echo -e "\nEscolha o ambiente"
read -p "1. local | 2. produção: " choice

case $choice in
    1)
        appEnv="dev"
        ;;
    2)
        appEnv="production"
        ;;
    *)
        echo -e "Opção inválida"
        exit 1
        ;;
esac

read -p "Nginx HTTP Port: " nginxHttpPort
read -p "Nginx HTTPS Port: " nginxHttpsPort
read -p "Frontend Port: " frontendPort
read -p "Database Port: " dbPort

read -p "Database root password: " dbRootPass
read -p "Database username: " dbUsername
read -p "Database user password: " dbUserPass
read -p "Database name: " dbName

appTz=$(curl https://ipapi.co/timezone)
echo -e "\nTimezone: $appTz"

sed -i "s+APP_ENV=+APP_ENV=$appEnv+g" .env
sed -i "s+FRONTEND_PORT=+FRONTEND_PORT=$frontendPort+g" .env
sed -i "s+NGINX_API_HTTP_PORT=+NGINX_API_HTTP_PORT=$nginxHttpPort+g" .env
sed -i "s+NGINX_API_HTTPS_PORT=+NGINX_API_HTTPS_PORT=$nginxHttpsPort+g" .env
sed -i "s+DB_PORT=+DB_PORT=$dbPort+g" .env
sed -i "s+DB_ROOT_PASSWD=+DB_ROOT_PASSWD=$dbRootPass+g" .env
sed -i "s+DB_USER=+DB_USER=$dbUsername+g" .env
sed -i "s+DB_PASSWD=+DB_PASSWD=$dbUserPass+g" .env
sed -i "s+DB_NAME=+DB_NAME=$dbName+g" .env
sed -i "s+TIMEZONE=+TIMEZONE=$appTz+g" .env

echo -e "\nVariáveis env setadas..."



