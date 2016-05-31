Symfony Journey Exercise
=====================

Welcome to the Symfony Journey Exercise - An example of an application developed from the ground up using Symfony 2.7 and Bootstrap 3.3.6.  

Install:
--------

### Clone this repo to the location of your choice:

`git clone git@github.com:perlnerd/symfony_journey.git`

### Run composer

`cd symfony_journey && composer install`
 
Answer the questions about you database config when prompted.

### Create your database if needed

`mysql -u root -e 'create database symfony_journey'`

### Create the database schema

`php app/console doctrine:schema:update --force`

### Run a webserver and access the web app from your web browser.

  * Serve `symfony_user/web` with your [favourite http server](http://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html) OR run the built in web server:

`php app/console server:run` 

  * Visit `localhost:8000/` if using the built in webserver.  Otherwise visit http://YOURDOMAIN.com/

What's it do?
--------------
  
  * You will land on a welcome page where you can click a button to be taken to another page where you can 'buy' a product.  You will then be asked to create a username and password.   From there you will be taken to the 'learn' page, and from there you'll take a 'test'.  At the end you will have your license (to be awesome?  Dunno.)

  * Click on 'Logout' on the top right, and go through the process a few more times.  Complete the process, don't complete the process, etc.

  * now go to `/admin`.  You'll see a summary of todays user events.

  * From there you can search for the events making up the journey of a specific user.  Enter one of the addresses you registered with to see that user's journey.

What doesn't it do?
-------------------

  * Confirm registrations via email, strict form validations, much beyond jumping from page to page and logging the jumps.

  Have fun!
  

