Welcome to Breeze Framework 1.0.0 Release!
===============================================

RELEASE INFORMATION
-------------------
Breeze Framework 1.0.0 Release  
Released October 28, 2013


OVERVIEW
--------
Breeze Framework is a POWERFUL, ROBUST php framework inspired by java for android, and 
that lets you think and act like an architect.
No loss of time by learning big basics or huge awful documentations.
It comes with only two files and a cli manager, it is as simple as that, let's breathe !!!
All you have to do is to download extensions you feel comfortable with on Breeze website, or create yours,
or adapt one insteresting on internet and share it.
You can download some extensions on http://www.breezeframework.com via the cli manager.
Every extension is independent, that makes Breeze really scalable and best for both small and big projects.

!!IMPORTANT!!!
One more point, Because of its architecture, Breeze will never require a major upgrade, only your extensions
have to evolve, not the framework.
Isn't that great and a revolution in the world of frameworks? 

OK Let's start now !

1) INSTALLING BREEZE
----------------------------------

### Download an Archive File

Simply download an archive file and unpack it under your web server root directory.
You can download an archive on Github or directly on http://www.breezeframework.com.


2) CHECKING YOUR SYSTEM CONFIGURATION
-------------------------------------

Before starting coding, make sure that your local system is properly
configured for Breeze.

Target your console to `core` directory of Breeze, from the command line:

    php console -c

this command will check for your php configuration and breeze latest version.
If a new version is available, you will be prompted to download it.


Then, open the `index.php` file in 'public_html' folder.
Here, you will be able to change mode (dev or prod).


3) GETTING STARTED WITH BREEZE
--------------------------------

Congratulations! You're now ready to use Breeze.

If you think like an architect, of course you do, you have already guessed that,
we need at least two extensions to run any project.

- Debug console for dev environment
- Router

Well, Breeze has already has these extensions ready for download.

Open your command line and type :

	php console -d libs/Php_error
	php console -d libs/Router
	
Breeze will download and install:
 - these extensions in the `extensions\libs` directory.
 - these extensions configuration files in the `config\` directory.
 
Here, you will find only a "Router.config.php" in the `config\` directory.
This configuration file will hosts all the routes of the project and will be
generated and updated automatically.

You will be prompted to upgrade extensions configuration file in `config\Extensions.php`
You don't have to touch	this file, it will be generated and upgraded automatically.

When you build manually your own extension, you have to upgrade `config\Extensions.php`.
Breeze lets you do it from command line, just like this:

	php console -r
	OR
	php console --refactor
	
	
Well, you can open the downloaded extensions to see the simplicity of Breeze.
Let's go to next step.


4) FIRST HELLO WORLD
-------------------------------

Having your first "Hello World" is magic, really magic.

Breeze has its own cli manager that gives the opportunity to extend an extension cli.
Wow, hopefully, the router extension has been built with a cli.
It gives you the ability to generate skeletons.

When you code your own extensions, think independent, think community, give a cli to
your extension to simplify everything.

Well, so, let's generate a first hello world with the Router cli.
In your command line, type this

	php console -l Router generate skeleton
	OR
	php console --link Router generate skeleton
	
You will be prompted to give an activity (controller) name.
Type 'home' for a default route will hello world.
Type anything else to generate a crud skeleton.

 - Open your `src\` folder, you will see your activity (controller) generated.
 - Open your `config\Router.config.php`, yu will generated routes.

Now, simply type in your browser 'http://localhost' to see your first hello world. 
That's it.


5) GOING FURTHER WITH BREEZE
-------------------------------

If you don't like our router manager, you can use a router you feel comfortable with
and adapt it to Breeze.
To see how to create an extension, report on http://www.breezeframework.com.

When you build an extension or adapt an interesting one, please, share it on http://www.breezeframework.com.
Your experience will help others.

Well, we have other extensions available and more coming soon.
Visit our website to see them.

FEEL FREE TO PLAY WITH BREEZE.



What's inside Breeze?
---------------
	config/
	core/
		App.php
		Cli.php
		Console
		Intercept.php
	extensions/
		libs/
		cli/
		i18n/
		schema/
	src/
		cache/
		tmp/
		views/

Breeze is yours, unleash the power, and... THINK LIKE AN ARCHITECT!


SYSTEM REQUIREMENTS
-------------------
You will need PHP 5.3.0 or later.

QUESTIONS AND FEEDBACK
----------------------
An online overview and documentation can be found at
http://www.breezeframework.com

The Pop PHP Framework is available for anonymous checkout via
GitHub at https://github.com/nicksagona/PopPHP

Further contact or comments can be emailed to edouard.kombo@gmail.com.