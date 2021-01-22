#!/bin/bash
clear

if [ -f .env ]; then

    LINE="============================================="

    echo -e "$LINE"
    echo -e "Application initial config"
    echo -e "$LINE\n"

    read -p "Database root password: " dbRootPass
    read -p "Database name: " dbName

    echo -e "\nChoose the environment type"
    read -p "1. dev | 2. production: " choice

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
    sed -i "s+DB_USER=+DB_USER=root+g" .env
    sed -i "s+DB_ROOT_PASSWD=+DB_ROOT_PASSWD=$dbRootPass+g" .env
    sed -i "s+DB_NAME=+DB_NAME=$dbName+g" .env

    echo -e "\nFinished config"
    exit 0

else

    echo '.env file not exists, please execute environment.sh file first'
    exit 1

fi
