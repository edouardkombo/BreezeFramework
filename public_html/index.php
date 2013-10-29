<?php
session_start();

// make sure to set the timezone if it is not already set in your php.ini
date_default_timezone_set('UTC');

$basePath = str_replace(DIRECTORY_SEPARATOR . 'public_html', '', __DIR__);
require $basePath . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'App.php' ;
use core\App as App;

App::getInstance();
App::setEnvironment($basePath, 'dev'); //Modes available are "dev" & "prod" 
App::start();