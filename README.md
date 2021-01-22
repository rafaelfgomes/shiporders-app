## About this project (Shiporders app)

This project has two parts: frontend (Vue.js) and Backend (Symfony) and his goal is upload xml files and save to database.

## Downloading this project

To download this project you can clone this repository with the following command:

SSH
```
git clone git@github.com:rafaelfgomes/shiporders-app.git 
```

HTTPS
```
git clone https://github.com/rafaelfgomes/shiporders-app.git
```

## Prerequsites

To run and test this project you need this dependencies:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Pre configuration

Before run docker compose, you need to prepare the project with environment variables. There are two shell scripts: environment.sh and config.sh.
You need to run environment.sh first and then run config.sh. The enviroment.sh file will create a copy of .env.sample file and set the values of the
variables automatically. The config.sh is an interactive shell that you can choose the database variables, like root password, database name etc.

* OBS: If you are on windows you can copy the .env.sample file and set the values of variables manually

## Installation

After you have your .env file configured, you need to run docker compose to install all the dependencies and create the containers:

```
docker-compose up -d
```

## Project content

After run docker compose will be created 4 containers: api, frontend, database, webserver.
The api container is built based on docker php-fpm alpine image.
The batabase container is built based on docker mariadb image.
The webserver container is built based on docker nginx alpine image.
The frontend container is built based on docker node alpine image.

You can access the database by a client (MySQL Workbench, DBeaver) or command line
The address off database is: 0.0.0.0:33060

## Run the project

If everything goes fine, your project is already running.
The frontend can be accessed on the address: http://0.0.0.0:13000.
The backend api can be accessed on the address http://0.0.0.0:8686.

*OBS: You can change the value of these ports on environment.sh file or directly on .env variables file and run docker compose again to rebuid the application

```
docker-compose up -d --build
```
## Installing more dependencies

If you want to install one or more dependenciees with composer on api, you have to execute this command:

```
docker exec -it shiporders_api sh -c "composer require <package_name>"
```

The same is applied to frontend. If you want to install more dependencies you can run 

```
docker exec -it shiporders_frontend sh -c "npm install <package_name>"
```

## Executing tests

This project has some unit and functional tests implemented. If you want to run and see them working just run:

```
docker exec -it shiporders_api sh -c "./bin/phpunit"
```

## License

This project is licensed by [MIT License](https://opensource.org/licenses/MIT).