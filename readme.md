# Instruction for new developer

### What you need before start
1. Git
2. Composer
3. MySQL(MariaDB) 10.3
4. PHP 7.4
5. Web Server(Apache/Nginx)
6. NodeJS

### Step 1 

Download this repository to your local machine by command:

``` git clone https://github.com/vitaliksokil/b-my-friend.git ```

And then fetch dev branch and checkout to it ( all development is there )

``` git fetch && git checkout dev ```

### Step 2
Go to your project and install all dependencies by running next command: 

``` composer install ```

### Step 3
Next you have to do is copy .env.example file to .env

On linux you can do it by:

``` sudo cp .env.example .env ```

### Step 4

Open your .env file and change database settings to yours:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD= 
```

Also what you have to do is config smtp server for sending emails

```
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
```


### Step 5

Inside your project directory run next commands:

```
php artisan key:generate
php artisan migrate
```

First command will generate unique key for Laravel app, next one will run migration to create tables in your database

### For Angular

### Step 1 

Go into ``` resources/assets/app ```

### Additional information

Of course you should configurate your web server for current project. The enterpoint is folder called public/ .

Or if you don't want to configurate your own web server you can use server that laravel offers to you by running command:

``` php artisan serve ```

This command will run the server, url for it will be something like that : localhost:8000/


## Finish :)

That's all!!! Now you have our api localy on your machine. 

To check docs go to route: http://your-local-host.loc/api/documentation

# ER diagram
![ER diagram](http://pixs.ru/images/2020/12/24/Screenshot-from-2020-12-24-22-06-10.png)

# Architecture diagram
![Architecture diagram](http://pixs.ru/images/2020/11/27/arch-Diagram-1.jpg)
