#!/bin/bash
clear

LINE="============================================="

folderName=$(basename $(pwd))
prefixContainerName=${folderName%-app}

apiContainerName=$prefixContainerName"_api"

echo "$LINE"
echo -e "Application initial config"
echo "$LINE\n"

read -p "Database root password: " dbRootPass
read -p "Database username: " dbUsername
read -p "Database user password: " dbUserPass
read -p "Database name: " dbName

echo -e "\nChoose the environment type"
read -p "1. local | 2. produção: " choice

case $choice in
    1)
        appEnv="dev"
        ;;
    2)
        appEnv="production"
        ;;
    *)
        echo -e "Invalid option"
        exit 1
        ;;
esac

sed -i "s+APP_ENV=+APP_ENV=$appEnv+g" .env
sed -i "s+DB_ROOT_PASSWD=+DB_ROOT_PASSWD=$dbRootPass+g" .env
sed -i "s+DB_USER=+DB_USER=$dbUsername+g" .env
sed -i "s+DB_PASSWD=+DB_PASSWD=$dbUserPass+g" .env
sed -i "s+DB_NAME=+DB_NAME=$dbName+g" .env

echo -e "installing dependencies on api..."
docker exec -it apiContainerName sh -c "composer install"

echo -e "\nFinished config"
exit 0
