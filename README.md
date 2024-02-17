# Content Management System (CMS)
## Description
This project is a custom Content Management System (CMS) designed to allow users to create, edit, and publish dynamic content in a flexible, secure, and easy way. It uses the Laravel framework for the backend and Blade for the frontend. It is primarily developed as an API and also includes some Blade views.
## Technologies Used
- Docker
- Laravel - Blade
- MariaDB
- Sanctum
- L5-swagger
- PHPUnit
- Bootstrap
- TinyMCE

## Installation and Configuration
### Prerequisites
Before starting, make sure you have Docker and Docker Compose installed on your system.
### Clone the Repository
Clone it on your local machine using:
```
git clone https://github.com/jagaleanov/pruebaT.git
```
### Build and Run the Container
From the Laravel folder, where the Dockerfile and docker-compose.yml files are located, run the following commands to build and run your Docker environment:
```
docker-compose up --build
```
### Run Shell
Once the containers are up and running, you will need to initiate the shell inside the container. Use the following command:
```
docker-compose exec app bash
```
### Run Database Migrations
Run the migrations to set up the database. Use the following command:
```
php artisan migrate
```
### Run Database Seeders
Run the seeders to populate the database with test data. Use the following command:
```
php artisan db:seed
```
## Access the Project
After the containers are up and running, and the migrations have been executed, you can access the Laravel project through a web browser using:
```
http://prueba.test/api/documentation
http://prueba.test
```
To make the domain work, make sure you have added prueba.test to your hosts file:
```
127.0.0.1 prueba.test
```
## Log in as Administrator
You can log in using the credentials:
```
{
"email": "admin@admin.com",
"password": "password"
}
```
## Close the Project
To stop and remove the containers you can use
```
docker-compose down -v
```
This command will stop all the containers associated with the project and remove the volumes, ensuring that all temporary data is cleaned up. Remember, using -v will delete all data stored in Docker volumes. If you wish to keep the data, omit the -v flag.

After executing this command, your Docker environment will be cleaned up, and you can start fresh the next time you decide to run the project. This is especially useful during development phases or if you wish to reset the project to its initial state.
