Symfony User Exercise
=====================

Welcome to the Symfony User Exercise - An example of an application developed from the ground up using Symfony 2.8 and Bootstrap 3.3.6.  

Install:
--------

### Clone this repo to the location of your choice:

`git clone git@github.com:perlnerd/symfony_user.git`

### Run composer

`cd symfony_user && composer install`

### Create Your Database Config

`cd app/config`
`cp parameters.yml.dist parameters.dist`

Update the database setting in parameters.yml to match your database name and server.

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
  
  * You can log in with username `admin` and password `admin`.  You will land on a welcome page, where you can click a button to be taken to a page where you can change your name and change your password.

### Run the CSV Import Command





What else can it do?
--------------------
  
  * You can change the hashtag by appending a different one to the URL! Try `/hashtag/JustinBieber`

  * Try a bogus hashtag like `/hashtag/Justingngnght876Bieber` and you'll get a friendly error message.

  * There's also a handy little form that lets you select a date range to search within.

What doesn't it do?
-------------------

  * Pagination.  This is just a demo.  I may add pagination in the future.

  * There should be a bit of form validation but I haven't done that yet.

  * Old IE support is not there.  
  

