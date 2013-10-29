Welcome to Breeze Framework 1.0.0 Release!
===============================================

RELEASE INFORMATION
-------------------
Breeze Framework 1.0.0 Release  
Released October 28, 2013


OVERVIEW
--------
Breeze is a SCALABLE, revolutionary php framework inspired by java, that lets you <b>think and code like an architect</b>.<br/>
The base framework is as simple as stupid, but its philosophy brings you robust possibilities for both tiny and huge projects.<br/>
NOW, BREATHE PLEASE! No more loss of time learning complex basic structures or huge awful online docs.<br/>
No more loss of time, searching on forums because of an internal structure bug... Take a breeze now!

Breeze simple philosophy (BSP) is that, you must feel really comfortable with each component you use in a framework.<br/>
So we made a structure only based over extensions that you can download from our website, create or adapt your favorite ones.
Each extension has its role, is independent and can implement its own cli, so you can build a powerful scalable application.

EVERYTHING is an extension, even the router, we created one inspired from laravel that you can download from our cli,
but you can also use a special one you feel really comfortable with, that's the Breeze simple philosophy, the BSP!

If you encounter bugs with an extension, you can quickly use another one that matches your needs today and go on!
The never seen Breeze revolution comes with two files and a cli (command line interface), and that's all !
Everything you need already exists on the web, just adapt it to your needs and share the extension on our website.

!!! IMPORTANT THING ABOUT BREEZE MAINTENANCE !!!<br/>
Its architecture (only three files) never requires major upgrades, so Breeze is here to last and grow smartly, join the community.

OK check it yourself, let's start having fun now !

1) INSTALLING BREEZE
----------------------------------

### Download an Archive File

Simply download an archive file and unpack it under your web server root directory.<br/>
You have two choices:<br/>
<u>Github</u>: https://github.com/edouardkombo/BreezeFramework<br/> 
<u>Breeze website</u>: http://www.breezeframework.com/download/breezeframework.zip.


2) CHECKING YOUR SYSTEM CONFIGURATION
-------------------------------------

Before starting coding, make sure that your local system is properly
configured for Breeze.

Target your console (on windows, cmd.exe) to `core` directory of Breeze, and type from the command line:

    php console -c
	OR
	php console --check

This command will check for your php configuration (php 5.3 at least), and check for breeze latest version on Breeze website.
If a new version is available, you will be prompted to download it.


Now, just open the `index.php` file in `\public_html` folder.
Here, you will be able to change environment mode (dev or prod).


3) GETTING STARTED WITH BREEZE
--------------------------------

Congratulations! You're now ready to use Breeze.

But, you are so alone, with only a couple of files. It is here you have to think like an architect!<br/>
Every project has its own dna, and some extensions will never be useful for all projects.
In this tutorial, we just need a simple 'Hello World !' (in mvc please).

To do that, my little architect mind tells me I will need at least two kinds of extensions:

- Php Debug console for targeting more precisely php errors in dev environment
- Router

No problems, Breeze has already implemented the excellent `php_router` From Joseph Lenton (http://phperror.net/),
and we have built our own router extension.
These extensions are all available for download on breeze website (http://www.breezeframework.com/extensions/libs/).
So, let's download them for our project.

Open your command line and type :

	php console -d libs/Php_error
	php console -d libs/Router
	OR
	php console --download libs/Php_Error
	php console --download libs/Router
	
Breeze will download and install:
 - these extensions in the `extensions\libs` directory.
 - them config files (if exist) in the `config\{:extension}.config.php` directory.
 - them cli (if exist) in the `extensions\cli\{:extension}` directory.
 
For best extension independence, each can implements a personal configuration file that will be loaded by the framework.<br/>
Here, only the router extension comes with a config file, you will now find it in `config\Router.config.php`.
Check also, the router cli extension installed in `extensions\cli\Router`.

Now, you get extensions, you have to tell it to breeze, don't worry, it is done automatically, you will be prompted to upgrade extensions configuration file in `config\Extensions.php`
You don't have to touch	this file, it will be generated and upgraded automatically each time you download, or build extension.

To upgrade the extension config file, in your command line just type this, and it will be done:

	php console -r
	OR
	php console --refactor
	
	
To learn more about extensions, visit http://www.breezeframework.com.
Now, let's get our first "Hello World !".


4) FIRST HELLO WORLD
-------------------------------

Having your first "Hello World" is magic, really magic.

Remember, Breeze has its own cli manager and extensions can have their own too !<br/> 
Also, from Breeze Cli manager, you can call an extension cli, So, you don't have to touch Breeze Core files.


Breeze Router extension let's you build skeleton routes and controllers in minutes.<br/>
Inspired by java for android, we have chosen to replace "controller" by "activity".<br/>
Well, so, let's generate our first "Hello World!" now, in your command line, type this

	php console -l Router generate skeleton
	OR
	php console --link Router generate skeleton
	
You will be prompted to give an activity (controller) name.
Type 'home' for a single default route, with a single activity action.
Type anything else to generate a complete crud skeleton.

 - Open your `src\` folder, you will see your activity generated (`src\{:activityname}Activity.php`).
 - Open your `config\Router.config.php`, to see the generated routes.

Now, simply type in your browser 'http://localhost' to see your first hello world. 
That's it.

!!! IMPORTANT FUN ONE !!!<br/>
You can uninstall at any moment our router extension, and replace it. Breeze framework is highly customisable and scalable.
To uninstall an extension, juste type:

	php console -u extension
	OR
	php console --uninstall extension

5) GOING FURTHER WITH BREEZE
-------------------------------

Here we are, you can adapt any extensions that has been thought for php5.3 or later. Need an example?<br/>
You can implement a phpDataMapper, ACL, Authentication, Template Manager, Request Manager, Session Manager... anything you need,
The simplest it is, the faster you can reach your goals with fun.

More tutorials coming on http://www.breezeframework.com.
 
Help us offering great and fun extensions to the world, share your extensions with us, take a breeze!
Your experience will help others.

Have fun little php architect !



What's inside Breeze?
---------------
	core/
		App.php
		Cli.php
		Console
		Intercept.php
	public_html/
		.htaccess
		favicon.ico
		index.php

Breeze is yours now, unleash its great power and TELL IT TO THE WORLD... THINK LIKE AN ARCHITECT!


SYSTEM REQUIREMENTS
-------------------
You will need PHP 5.3.0 or later.

QUESTIONS AND FEEDBACK
----------------------
An online overview and documentation can be found at
http://www.breezeframework.com

Breeze Framework is also available for anonymous checkout via
GitHub at https://github.com/edouardkombo/BreezeFramework

Further contact or comments can be emailed to edouard.kombo@gmail.com.