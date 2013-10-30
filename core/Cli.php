<?php
namespace core;

/**
 * Breeze Framework CLI Object
 * This class is as generic as possible to suit your needs
 *
 * @package    Console
 * @author     Edouard Kombo <edouard.kombo@gmail.com>
 * @copyright (c) 2013 Edouard Kombo 
 * @license under the MIT license <http://www.opensource.org/licenses/mit-license.php>
 */
class Cli
{
	/**
	 * Extensions download link on http://www.breezeframework.com
	 * 
	 * @var string $_download_url
	 */
	protected static $_download_url = 'http://www.breezeframework.com/extensions/';
	
	/**
	 * Framework download link on http://www.breezeframework.com
	 *
	 * @var string $_download_framework_url
	 */
	protected static $_download_framework_url = 'http://www.breezeframework.com/download/';	
	
    /**
     * CLI error codes & messages
     * @var array
     */
    protected static $cliErrorCodes = array(
        0 => 'Unknown error.',
    	1 => 'That file does not exist.',
        2 => 'The source folder passed does not exist.',
        3 => 'The output file passed must be a PHP file.',
        4 => 'You must declare an extension to install.',
        5 => 'Unknown option: ',
        6 => 'You must pass at least one argument.',
        7 => 'That folder does not exist.',
        8 => 'The folder argument is not a folder.',
        9 => 'Unable to copy this file, please check directory rights.',
        10 => 'You must declare an extension to uninstall.',
        11 => 'Error, extension not found on ',
        12 => 'You must declare an extension to download like this "php console -d libs/router".',
        13 => 'You must specify the extension to download with a similar command "php console -d libs/Router".',
    	14 => 'No other arguments are needed for extensions loader refactoring.',
    	15 => 'Unable to create extension configuration file, check your drectory rights on folder',
     	16 => 'You must declare 4 arguments in your command line, ex. "php console -l Router generate skeleton".',
     	17 => 'This command is unknown by extension cli:'     			    			    		    		    		    		    		    		    		
    );

    /**
     * Constructor
     */
    function __construct(){}
    
    
    /**
     * Parse file content and echo content
     * 
     * @param string $file
     * @return boolean
     */
    static function parseFile($file, $msg){
    	
    	(array) $object = file($file);
    	
    	if (!empty($object)) {
    		
    		foreach ($object as $key => $val){
    			
    			echo $msg . $val;
    			usleep(8000); //For the beauty of code generation
    		}
    		echo PHP_EOL . PHP_EOL;
    	}
    	return true;
    }    
    
    
    /**
     * Deleteing directories recursively
     * 
     * @param string $path
     */
    static function removeDir($path) {
    
    	// Normalise $path.
    	$path = rtrim($path, '/') . '/';
    
    	// Remove all child files and directories.
    	$items = glob($path . '*');
    	
    	foreach($items as $item) {
    		if (is_dir($item)){
    			echo 'Deleting ' .$item . PHP_EOL; 
    			self::removeDir($item);
    		} else {
    			echo 'Deleting ' . $item . PHP_EOL; 
    			unlink($item);
    		}
    	}
    
    	// Remove directory.
    	if( file_exists($path)){
    		
    		if (!rmdir($path)){
    			return false;
    		}
    	}
    	return true;
    }    
    
    
    /**
     * Install extension by his manifest file
     *
     * @param string $installFile
     * @param string $directory
     * @param string $extension
     * @return boolean
     */
    public static function install($installFile, $directory, $extension)
    {
    	//Get extension namespace
    	(string) $installFile = str_replace('.php', '', $installFile);
    	(string) $installFile = str_replace(App::$_base_path, '', $installFile);
    	
    	//Get Manifest and dependencies
    	(object) $manifest = new $installFile();
    	(array) $dependencies = $manifest::$_dependencies;
    	
    	//Copy config dependency
    	if (isset($dependencies['config'])){
    		
    		self::copyDependency($dependencies['config'], 'config', $directory, $extension);
    	} else {
    		echo 'No config dependency to install, pass to cli dependency.' . PHP_EOL;    		
    	}
    	
    	//Copy cli dependency
    	if (isset($dependencies['cli'])){
    		
    		self::copyDependency($dependencies['cli'], 'cli', $directory, $extension);    	
    	} else {
    		echo 'No cli dependency to install. You can start using your extension.' . PHP_EOL;    		
    	}
    	
    	echo PHP_EOL . 'Dependencies have been successfully installed.' . PHP_EOL . PHP_EOL;
    	
    	return true;
    }
    
    
    /**
     *
     * @param string $val
     * @param string $type
     * @param string $directory
     * @param string $extension
     * @return void
     */
    private static function copyDependency($val, $type, $directory, $extension){
    
    	//Clean directory_separator
    	(string) $val = str_replace('/', DIRECTORY_SEPARATOR, $val);
    
    	//GET FULL PATH
    	(string) $file = $directory . $val;
    
    	//Get new patth
    	if ($type == 'config'){
    
    		(string) $newPath = App::$_base_path . DIRECTORY_SEPARATOR . 'config';
    		(string) $newFile = $newPath . DIRECTORY_SEPARATOR . $extension .'.config.php';
    		 
    	} else {
    
    		(string) $newPath = App::$_base_path . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR . 'cli';
    		(string) $newFile = $newPath . DIRECTORY_SEPARATOR . $extension;
    	}
    	
    	//Test Path existence
    	self::testPath($newPath);
    	 
    	//Copy
    	if (copy($file, $newFile)) {
    		 
    		echo "Copying $newFile directory //OK" . PHP_EOL;
    	} else {
    	 
    		echo self::cliError(9, $newFile);
    		return false;
    	}
    }    
    
    
    /**
     * Uninstall extension by his manifest file
     *
     * @param string $installFile
     * @param string $directory
     * @param string $extension
     * @return boolean
     */
    public static function uninstall($installFile, $directory, $extension)
    {
    	//BaseFile to delete
    	$lastOccurence = strrpos($installFile, DIRECTORY_SEPARATOR);
    	$basePath = substr($installFile, 0, $lastOccurence);
    	
    	//Get extension namespace
    	(string) $installFile = str_replace('.php', '', $installFile);
    	(string) $installFile = str_replace(App::$_base_path, '', $installFile);
    	
    	//Get Manifest and dependencies
    	(object) $manifest = new $installFile();
    	(array) $dependencies = $manifest::$_dependencies;
    	 
        //Delete config dependency if exists
    	if (isset($dependencies['config'])){
    		
    		$file = App::$_base_path . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . $extension . '.config.php';
    		if (file_exists($file)) {
	    		if ( unlink($file) ){
	    			echo $extension . ' config dependency successfully deleted !' . PHP_EOL . PHP_EOL;
	    		}
    		}    		
    	}
    	
    	//Delete cli dependency if exists
    	if (isset($dependencies['cli'])){
    		
    		$file = App::$_base_path . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR . 'cli' . DIRECTORY_SEPARATOR . $extension;
    	    if (file_exists($file)){
	    	    if ( unlink($file) ){
	    			echo $extension . ' cli dependency sucessfully deleted !' . PHP_EOL . PHP_EOL;
	    		}
    	    }   		
    	}
    	
    	//Delete extension folder if exists
    	if ( self::removeDir($basePath) ){
    		echo PHP_EOL . $extension . ' extension has been successfully uninstalled.' . PHP_EOL . PHP_EOL;
    	} else {
    		echo PHP_EOL . 'Unable to uninstall ' . $extension . ' extension. Please check directory rights.' . PHP_EOL . PHP_EOL;    		
    	}
    	
    	return true;
    }
    
    
    /**
     * does a remote installation from server http://www.breezeframework.com, by name
     *
     * @param string $name
     * @return boolean
     */
    public static function download($name)
    {
    	if (false == strrpos($name, '/')){
    		
    		self::cliError(13, $name);
    		return false;
    	}
    	
    	(string) $download_url = self::$_download_url . $name . '.zip';
    	echo 'Downloading ' . $name . ' extension from ' . $download_url . PHP_EOL . PHP_EOL;
    	
    	//Make process
		return self::download_process($download_url, $name, 1);
    }


    /**
     * Check framework current version and download new version if available
     * Also check php version, Breeze is configured to work on PHP 5.3 and higher
     *
     * @return boolean
     */
    public static function checkVersion(){
    	 
    	(int) $current_version = App::$_version;
    	(string) $file_version = self::$_download_framework_url . 'version.txt';
    	(string) $framework_url = self::$_download_framework_url . 'BreezeFramework.zip';
    	(int) $online_version = file_get_contents($file_version);

    	if (version_compare(PHP_VERSION, '5.3.0') >= 0){
    		 echo "Congrats, you're using at least the minimum php version required, let's go!" . PHP_EOL . PHP_EOL;
    	} else {
    		
    		echo "WARNING! You php version is lower than required. Breeze needs at least PHP 5.3.0 to work!" . PHP_EOL . PHP_EOL;
    		return false;
    	}
    	
    	if ($current_version == $online_version){
    
    		echo 'You are also using the latest version of Breeze Framework, '.$current_version.'.' . PHP_EOL . PHP_EOL;
    		return true;
    		 
    	} else {
    
    		if (self::cliInput('A new version of BreezeFramework ('.$online_version.') is available, upgrading will only replace core, install and readme files. Upgrade?') == 'y'){
    
    			return self::download_process($framework_url, 'BreezeFramework', 2);
    		}
    	}
    	 
    }    
    
    
    /**
     * Downloading process
     * Type 1 = extension
     * Type 2 = framework
     * 
     * @param string $download_url
     * @param string $name
     * @param string $type
     * @return boolean
     */
    private static function download_process($download_url, $name, $type){
    	
    	//Get file, if file doesn't exists, show an error
    	$file = file_get_contents($download_url);
    	if (false == $file) { echo self::cliError(11, $download_url); return false; }
    	 
    	//Clean $name separator
    	$name = str_replace('/', DIRECTORY_SEPARATOR, $name);
    	 
    	//Get Path, zipFile and put downloaded content in
    	if ($type == 1){
    		$path = App::$_base_path . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR . $name;
    	} else {
    		$path = App::$_base_path . DIRECTORY_SEPARATOR;
    	}
    	
    	//Test path existence
    	self::testPath($path);
    	
    	$zipFile = $path . '.zip';
    	file_put_contents($zipFile, $file);
    	 
    	echo 'Extracting ' . $name . '.zip, please wait.' . PHP_EOL;
    	 
    	//Unzip Extension archive
    	$zip = new \ZipArchive();
    	$zip->open($zipFile);
    	$zip->extractTo($path);
    	$zip->close();
    	
    	echo 'Dezipping ' . $name . '.zip, please wait.' . PHP_EOL;
    	 
    	//Delete zip archive
    	if (!unlink($zipFile)){ echo 'Unable to delete '.$name.' zip archive' . PHP_EOL; return false;}
    	 
    	echo 'Deleting downloaded ' . $name . ' zip archive, please wait.' . PHP_EOL;
    	if ($type == 1){
    		echo 'Congratulations, you have successfully downloaded '.$name.' extension.' . PHP_EOL . PHP_EOL;
    	} else {
    		echo 'Congratulations, you have successfully downloaded '.$name.' new version.' . PHP_EOL . PHP_EOL;
    	}
    	return true;
    }
    
    
    /**
     * Connect to an extension cli, like this "php console -l Router generate skeleton"
     * 
     * @param string $extension
     * @param string $method
     * @param string $args
     * @return boolean
     */
    public static function link($extension, $method, $args){
    	
    	$filename = App::$_base_path . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR . 'cli' . DIRECTORY_SEPARATOR . $extension ;
    	$namespace = '\extensions\cli\\';
    	$class = $namespace . $extension;

    	if (file_exists($filename)){
    		
    		require $filename;
    		$object = $class::getInstance();
			
    		if (!is_object($object)){
    			echo self::cliError(17, $args);
    			return false;
    			
    		} else {
    			return $object::$method($args);
    			
    		}
    		
    		
    	} else {
    		
    		echo self::cliError(1, $filename);
    		return false;
    	}
    }
    
    /**
     * Refactor extensions configuration file
     * IT WILL CREATE EXTENSIONS.PHP IN CONFIG DIRECTORY
     * IT WILL INCLUDE EXTENSIONS TO LOAD ONLY IF MANIFEST, AND MANAGER FILE ARE FOUND
     * This operation needs presence of "manager.txt" in the extension folder
     * manager.txt specifies at the first line, the name of the extension manager that will be used
     * Example: for extension php_error, we will use exception.manager, so we write exception in manager file
     *
     * @param string $name
     * @return boolean
     */
    public static function refactor()
    {
    	(string) $dir = App::$_base_path . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR;
    	(array) $content = scandir($dir);
    	(array) $extensions = array();
    	
    	if (!empty($content)){
    		
    		foreach ($content as $key => $val){

    			(string) $newContent = $dir . $val;
    			if ($val == '.' || $val == '..'){ continue; }    			
    			if (!is_dir($newContent)){ continue; }   			
	
    			(array) $newDir = scandir($newContent);
    			if (!in_array('manager.txt', $newDir) && !in_array('Manifest.php', $newDir)){ continue; }
    				
    			foreach ($newDir as $k => $v){

    				if ($v == '.' || $v == '..'){ continue; }
    				$lastPath = $newContent . DIRECTORY_SEPARATOR . $v;
    				if (!is_file($lastPath)){ continue; }

	    			if($v == 'manager.txt'){
	    				(string) $manager = file_get_contents($lastPath);
	    				
	    				//Add extension
	    				$extensions[$manager.'.manager'] = 'extensions' . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . $val . DIRECTORY_SEPARATOR . $val.'.php'; 
	    				break;
	    			}			
	    		}
    		}    		
    	}
  
    	//If there are extensions, we can update
    	if (!empty($extensions)){
    		
	    	$extensionsKeys = array_keys($extensions);
	    	
	    	$content = '<?php'."\n";
	    	$content .= 'namespace config;'."\n\n";
	    	$content .= '/**'."\n";
	    	$content .= ' * Automatically generated - '.date('y-m-d H:i:s')."\n";
	    	$content .= ' *'."\n";    	
	    	$content .= ' * Configure all extensions needed for a project'."\n";
	    	$content .= ' *'."\n";
	    	$content .= ' * @package config'."\n";
	    	$content .= ' * @author Edouard Kombo <edouard.kombo@gmail.com>'."\n";
	    	$content .= ' */'."\n\n";
	    	$content .= 'class Extensions {'."\n\n";
	    	$content .= "\t" . '/**'."\n";
	    	$content .= "\t" . ' * For security reasons, FIRST extension you have to download MUST ABSOLUTELY BE an exception.manager'."\n";
	    	$content .= "\t" . ' * The key of an extension (Ex: extension.manager) is stored in its "manager.txt" file, withtout the ".manager" text.'."\n";
	    	$content .= "\t" . ' * Example, inside "manager.txt" of php_error extension you will uniquely find at the first line "exception".'."\n";	    	
	    	$content .= "\t" . ' * NOTE: Each valid extension must contain a "Manifest.php" file and a "manager.txt" for the extension key'."\n";
	    	$content .= "\t" . ' * IMPORTANT! The main extension file = the directory name = the extension name'."\n";
	    	$content .= "\t" . ' * Don\'t forget to insert namespaces at the beginning of each files in order to work'."\n";
	    	$content .= "\t" . ' * Your namespaces must begin with "extensions\libs\xxxx"'."\n";
	    	$content .= "\t" . ' *'."\n";
	    	$content .= "\t" . ' * OPTIONALS'."\n";
	    	$content .= "\t" . ' * You can freely name your other extensions according to your wishes'."\n";
	    	$content .= "\t" . ' *'."\n";
	    	$content .= "\t" . ' * @var array $_extensions'."\n";
	    	$content .= "\t" . ' */'."\n";
	    	$content .= "\t" . 'static $_extensions = array('."\n";
	    		//Content
	    		if (in_array('exception.manager', $extensionsKeys)){
	    			$content .= "\t\t\t" . "'exception.manager' => '".$extensions['exception.manager']."', "."\n";
	    		}
	    			
	    		foreach ($extensions as $key => $val){
	    			
	    			if ($key != 'exception.manager'){
	    				$content .= "\t\t\t" . "'".$key."' => '".$val."', "."\n";
	    			}   			
	    		}	
	    	$content .= "\t" . ');'."\n\n";
	    	$content .= '}'."\n";

	    	//Insert content in file
	    	$filePath = App::$_base_path . DIRECTORY_SEPARATOR . 'config';
	    	self::testPath($filePath);
	    	$filename = $filePath . DIRECTORY_SEPARATOR . 'Extensions.php';	    	
	    	
	    	if ( file_put_contents($filename, $content) ){
	    		
	    		self::parseFile($filename, 'Writing line ');
	    		echo 'Extension configuration file has been successfully refactored.' . PHP_EOL;
	    		echo 'If it is your first time, please check your extensions config directory!' . PHP_EOL . PHP_EOL;	    		
	    		return true;
	    		
	    	} else {
	    		echo self::cliError(15, $filename);
	    		return false;
	    	}
    	
    	} else {
    		
    		//If no extension has been found, there is no need to keep the config\extensions.php if exists
    		//So, we delete it
    		//We also delete the extensions directory if exists
    		
    		(string) $extensionsDir = App::$_base_path . DIRECTORY_SEPARATOR . 'extensions';
    		(string) $configDir = App::$_base_path . DIRECTORY_SEPARATOR . 'config'; 
    		
    		if(is_dir($extensionsDir)){ self::removeDir($extensionsDir); }
    		if(is_dir($configDir)){ self::removeDir($configDir); }
    		
    		return true;
    	}
    }    
    
    /**
     * Test a path existence, and create recursive directories if needed 
     * 
     * @param string $path
     * @return boolean
     */
    public static function testPath( $path ){
    	
    	if( !is_dir($path)){
    		return mkdir($path, 0, true);
    	}
    }
    
    /**
     * Display CLI instructions
     *
     * @return string
     */
    public static function instructions()
    {
        $msg1 = "This interface will help you configure the base foundation of Breeze Framework, like download and install extensions from http;://www.breezeframework.com, accessing extensions own cli.";
        $msg2 = "Breeze let's you act like an architect. The framework comes with no extensions, you have to download extensions that suits your project needs on http://www.breezeframework.com, or manually implement those you feel comfortable with. Each extensions must implement a manifest file which specifies if extension has a config file and a own cli manager. For further informations, please visit http://www.breezeframework.com. We believe this approach fastens development and make it more fun, friendly and understandable to every developer even with minimum php knowledge. Have fun with Breeze Framework.";
        echo wordwrap($msg1, 70, PHP_EOL) . PHP_EOL . PHP_EOL;
        echo wordwrap($msg2, 70, PHP_EOL) . PHP_EOL . PHP_EOL;
    }

    /**
     * Print the CLI help message
     *
     * @return void
     */
    public static function cliHelp()
    {
        echo ' -c --check                              ' . 'Check app version, update if outdated' . PHP_EOL;        
        echo ' -e --extend extension method            ' . 'Call an extension cli method' . PHP_EOL;        
        echo ' -h --help                               ' . 'Display this help' . PHP_EOL;
        echo ' -i --install extension method args      ' . 'Install extension library' . PHP_EOL;
        echo ' -l --link extensionCli                  ' . 'call extension cli' . PHP_EOL;
        echo ' -r --refactor                           ' . 'Refactor extensions config file' . PHP_EOL;
        echo ' -s --show                               ' . 'Show install instructions' . PHP_EOL;
        echo ' -u --uninstall                          ' . 'Uninstall extension library' . PHP_EOL;        
        echo ' -v --version                            ' . 'Display Breeze current version' . PHP_EOL . PHP_EOL;
    }

    /**
     * Return a CLI error message based on the code
     *
     * @param int    $num
     * @param string $arg
     * @return string
     */
    public static function cliError($num = 0, $arg = null)
    {
        $i = (int)$num;
        if (!array_key_exists($i, self::$cliErrorCodes)) {
            $i = 0;
        }
        $msg = self::$cliErrorCodes[$i] . $arg . PHP_EOL .
               'Run \'php console -h\' for help.' . PHP_EOL . PHP_EOL;
        return $msg;
    }

    /**
     * Return the (Y/N) input from STDIN
     *
     * @param  string $msg
     * @return string
     */
    public static function cliInput($msg = null, $freeInput = null )
    {
        $input = null;
        if (true == $freeInput){

        	echo $msg;
       		     	
        	$prompt = fopen("php://stdin", "r");
        	$input = fgets($prompt, 10);
        	$input = strtolower(rtrim($input));
        	fclose ($prompt);
        	        
        } else {
        	
        	echo ((null === $msg) ? 'Continue?' . ' (y/n) ' : $msg . ' (y/n)');
        	while (($input != 'y') && ($input != 'n')) {
        		if (null !== $input) {
        			echo $msg;
        		}
        		$prompt = fopen("php://stdin", "r");
        		$input = fgets($prompt, 5);
        		$input = substr(strtolower(rtrim($input)), 0, 1);
        		fclose ($prompt);
        	}

        }

        return $input;
    }    

}
