<?php
namespace core;
use core\Intercept as Intercept;
use config;

/**
 * App Singleton
 * 
 * @package App
 * @version 1.0
 * @link http://www.breezeframework.com
 * @copyright (c) 2013 Edouard Kombo 
 * @license under the MIT license <http://www.opensource.org/licenses/mit-license.php> 
 * @author Edouard Kombo <edouard.kombo@gmail.com>
 */
final class App{
	
	/**
	 * @var App
	 */
	protected static $_instance;	
	
	/**
	 * @var string $_base_path
	 */
	public static $_base_path;

	/**
	 * @var array $_included
	 */
	public static $_included = array();
	
	/**
	 * @var array $_loaded
	 */
	public static $_loaded = array();	

	/**
	 * @var array $_extension
	 */
	public static $_extension = array();

	/**
	 * @var String $_mode (Environment mode)
	 */
	public static $_mode;

	/**
	 * @var String $_version 
	 */
	public static $_version = '1.0.0';

	/**
	 * @var String $_extensions_config_file
	 */
	public static $_extensions_config_file = '';	
	
	
	
	/**
	 * Constructor
	 * 
	 * @return void
	 */
	protected function __construct(){
		
		self::$_extensions_config_file = self::$_base_path . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'Extensions.php';
	}
	

	/**
	 * Destructor
	 */
	public function __destruct()
	{
		unset($this);
	}	
	
	
	/**
	 * Get Instance of App Class
	 *
	 * @return App
	 */
	static function getInstance(){
	
		if (self::$_instance === null) {
			self::$_instance = new App();
		}
		return self::$_instance;
	}	
	
	
	/**
	 * Registers Breeze Framework as an SPL autoloader.
	 *
	 * @param Boolean $prepend Whether to prepend the autoloader or not.
	 */
	public static function register($prepend = false)
	{
		if (version_compare(phpversion(), '5.3.0', '>=')) {
			spl_autoload_register(array(new self, 'autoload'), true, $prepend);
		} else {
			spl_autoload_register(array(new self, 'autoload'));
		}
	}
	
	/**
	 * Handles autoloading of classes in all directories possible
	 *
	 * @param string $class (A class name).
	 * @return boolean
	 */
	private static function autoload($class)
	{
		$file = self::$_base_path . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $class . '.php');
		if( file_exists( $file ) ){
			
			require $file;
			(array) self::$_included[] = $file;
			
			return true;
		}
	}
	
	/**
	 * 
	 * @param string $basePath
	 * @param string $environment
	 * @return void
	 */
	static function setEnvironment($basePath, $mode){
		
		(string) self::$_base_path = $basePath;
		(string) self::$_mode = $mode;
	}

	/**
	 * Call an extension
	 * Check is the Manifest file is included in extension directory
	 * Include extension config file if exists in "config directory"
	 * 
	 * @param string $key
	 * @throws \Exception
	 * @return Ambigous <unknown, stdClass>
	 */
	public static function call($key){
		
		//If key equals to exception or router manager, and extensions don't exist
		//We will not throw exception as it must be the project beginning
		if ($key == 'exception.manager' && !isset(self::$_extension[$key])){ return false; }
		if ($key == 'router.manager' && !isset(self::$_extension[$key])){ return false; }
		
		try{

			$values = array('.php', '/', '\\');
			$newValues = array('', DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR);

			if( !is_object(self::$_extension[$key])){
				
				(string) $class = str_replace($values, $newValues, self::$_extension[$key]);
				
				if(class_exists($class))
				{
					//Get Manifest file string
					(int) $lastDirOccurence = strrpos($class, DIRECTORY_SEPARATOR);
					(string) $manifest = self::$_base_path . DIRECTORY_SEPARATOR . substr($class, 0, $lastDirOccurence) . DIRECTORY_SEPARATOR . 'Manifest.php';
					
					//Get config file string
					(string) $name = substr($class, $lastDirOccurence+1);
					(string) $configFile = self::$_base_path . DIRECTORY_SEPARATOR . 'config'  . DIRECTORY_SEPARATOR . $name . '.config.php';
					
					if(!file_exists($manifest)){ throw new \Exception('Unable to find Manifest of "'.$key.'" extension !'); }
					
					//Instantiate the class, before the config file is loaded, in order to use in the object
					self::$_extension[$key] = new $class();
					
					if(file_exists($configFile)){
						require $configFile;
					}
					
					return self::$_extension[$key];
				
				} else {
					throw new \Exception('Unable to retrieve "'.$key.'" extension. ');				
				}
				
			} else {
				return self::$_extension[$key];
			}							
			
		}catch (Exception $e){
			echo 'Exception received: "'.$e->getMessage().'" ';		
		}
	}

	/**
	 * Do simply a file_exists operation and return a boolean
	 * 
	 * @param string $filename
	 * @return boolean
	 */
	public static function check_file($filename){
		
		return (file_exists($filename)) ? true : false;
	}
	
	/**
	 * Check fundamentals of extensions order
	 * 
	 * @throws \Exception
	 * @return boolean
	 */
	private static function trustExtensions(){
		
		//Otherwhise, continue treatment
		$extensions = config\Extensions::$_extensions;
		$extensionsKeys = array_keys($extensions);		
		
		try {
						
			if( isset($extensions['exception.manager']) && array_shift($extensionsKeys) != 'exception.manager'){ throw new \Exception('First Extension must be "exception.manager", please refactor extensions configuration file with command line like this "php console -r"'); }			
			self::$_extension = $extensions;
			return true;
					
		} catch (Exception $e) {
			echo 'Exception received: "'.$e->getMessage().'" ';			
		}
	}
	
	/**
	 * Start the application
	 * 
	 * @return Ambigous <unknown, boolean>
	 */
	static function start(){
		
		//Autoload Classes
		self::register(true);

		//If extensions configuration file doesn't exists, don't do more, we are at the beginning of the project
		//Download your first extensions by the cli console like this "php console -d libs/xxx"
		if ( !self::check_file(self::$_extensions_config_file) ){ return false; }		
		
		//Trust extensions fundamentals
		(boolean) self::trustExtensions();
		
		//Call Exception manager if we're on dev Mode, NEVER CALL IT IN PROD MODE
		(self::$_mode == 'dev') ? self::call('exception.manager') : '' ;
		
		//Your security code here
		Intercept::before();
		
			//We call the router manager		
			self::call('router.manager');
		
		//Your security code here
		Intercept::after();		
	}
}