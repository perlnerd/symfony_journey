Symfony User Exercise
=====================

Welcome to the Symfony User Exercise - An example of an application developed from the ground up using Symfony 2.8 and Bootstrap 3.3.6.  

Install:
--------

### Clone this repo to the location of your choice:

`git clone git@github.com:perlnerd/symfony_user.git`

### Run composer

`cd symfony_user && composer install`
 
Answer the questions about you database config when prompted.

### Create your database if needed

`mysql -u root -e 'create database symfony'`

### Import the database schema

`cd ../../`
`mysql -u root < symfony_user_dump.sql`

### Run a webserver and access the web app from your web browser.

  * Serve `symfony_user/web` with your [favourite http server](http://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html) OR run the built in web server:

`php app/console server:run` 

  * Visit `localhost:8000/` if using the built in webserver.  Otherwise visit http://YOURDOMAIN.com/

What's it do?
--------------
  
  * You can log in with username `admin` and password `admin`.  You will land on a welcome page where you can click a button to be taken to another page where you can change your name and change your password.

### Run the CSV Import Command

From the base directory of the repo run:

`app/console import:user:csv ./user_data.csv`

What's it do?
--------------------
  
  * This Symfony Console Command reads a csv file and persists the entries to your database.

What doesn't it do?
-------------------

  * Print informative messages, validation and extensive error handling.  This I would add to a real app, but haven't here.
  

